<?php

// Don't disturb
require __DIR__ . "/../../vendor/autoload.php";

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Function
function getSimsimiResponse($message, $language)
{
    $api_url = "https://sandipbaruwal.onrender.com/sim?chat=" . urlencode($message) . "&lang=" . urlencode($language);
    $response = @file_get_contents($api_url);
    return $response ? json_decode($response, true)["answer"] : null;
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
    if (isset($_SERVER["HTTP_COMMAND"])) {
        $commandPattern = $_SERVER["HTTP_COMMAND"];
        if (preg_match('/^' . $commandPattern . '\s*(.*)/', $message, $matches)) {
            $argument = trim($matches[1]);
            $language = $_SERVER["HTTP_LANGUAGE"];
            $response = getSimsimiResponse($argument, $language);
            $replies = ["replies" => [["message" => $response]]];
        }
    } else {
        $language = $_SERVER["HTTP_LANGUAGE"];
        $response = getSimsimiResponse($message, $language);
        $replies = ["replies" => [["message" => $response]]];
    }

    http_response_code(200);
    echo json_encode($replies);
} else {
    http_response_code(400);
    echo json_encode(["replies" => [["message" => "❌ Error!"], ["message" => "JSON data is incomplete. Was the request sent by AutoResponder?"]]]);
}
?>