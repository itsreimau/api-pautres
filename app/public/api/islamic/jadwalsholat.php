<?php

// Don't disturb
require __DIR__ . "/../../../vendor/autoload.php";

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Function
function getSholatResponse($message)
{
    $api_url = "https://api-gabut.bohr.io/api/jadwalsholat?query=" . urlencode($message);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_code == 200 && $response) {
        $data = json_decode($response, true);
        return isset($data["result"]) ? $data["result"] : null;
    }

    return null;
}

// Make sure JSON data is not incomplete
if (!empty($data->query) && !empty($data->appPackageName) && !empty($data->messengerPackageName) && !empty($data->query->sender) && !empty($data->query->message)) {
    $appPackageName = $data->appPackageName;
    $messengerPackageName = $data->messengerPackageName;
    $sender = $data->query->sender;
    $message = $data->query->message;
    $isGroup = $data->query->isGroup;
    $groupParticipant = $data->query->groupParticipant;
    $ruleId = $data->query->ruleId;
    $isTestMessage = $data->query->isTestMessage;

    // Process messages here
    $defaultMessage = "➲ %region%\n";
    $defaultMessage .= "➲ Shubuh: %shubuh%\n";
    $defaultMessage .= "➲ Dzuhur: %dzuhur%\n";
    $defaultMessage .= "➲ Ashr: %ashr%\n";
    $defaultMessage .= "➲ Maghrib: %maghrib%\n";
    $defaultMessage .= "➲ Isya: %isya%";

    $messageReplies = isset($_SERVER["HTTP_MESSAGE_REPLIES"]) ? $_SERVER["HTTP_MESSAGE_REPLIES"] : $defaultMessage;

    $variable = ['%region%', '%shubuh%', '%dzuhur%', '%ashr%', '%maghrib%', '%isya%'];
    $replace = [$result['region'], $result['schedule']['today']['Shubuh'], $result['schedule']['today']['Dzuhur'], $result['schedule']['today']['Ashr'], $result['schedule']['today']['Maghrib'], $result['schedule']['today']['Isya']];

    if (isset($_SERVER["HTTP_EXPERIMENTAL"]) && $_SERVER["HTTP_EXPERIMENTAL"] === "true") {
        if (isset($_SERVER["HTTP_REGEX"])) {
            $regexPattern = $_SERVER["HTTP_REGEX"];
            if (preg_match($regexPattern, $message, $argument)) {
                $capturingGroup1 = isset($_SERVER["HTTP_ARG1"]) ? $_SERVER["HTTP_ARG1"] : 1;
                $argument1 = isset($argument[$capturingGroup1]) ? trim($argument[$capturingGroup1]) : '';
                $result = getSholatResponse($argument1);
                if (is_array($result)) {
                    $response = str_replace($variable, $replace, $messageReplies);
                } else {
                    $response = $result;
                }

                $replies = ["replies" => [["message" => $response]]];
            }
        }
    } else {
        $result = getSholatResponse($message);
        if (is_array($result)) {
            $response = str_replace($variable, $replace, $messageReplies);
        } else {
            $response = $result;
        }

        $replies = ["replies" => [["message" => $response]]];
    }

    http_response_code(200);
    echo json_encode($replies);
} else {
    http_response_code(400);
    echo json_encode(["replies" => [["message" => "❌ Error!"], ["message" => "JSON data is incomplete. Was the request sent by AutoResponder?"]]]);
}
?>
