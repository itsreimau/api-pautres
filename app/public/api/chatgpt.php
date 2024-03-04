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
function getChatGPTResponse($api, $query, $uid)
{
    switch ($api) {
        case "ai-tools":
            $api_url = "https://ai-tools.replit.app/gpt?prompt=" . urlencode($query) . "&uid=" . urldecode($uid);
            $response = @file_get_contents($api_url);
            return $response ? json_decode($response, true)["gpt4"] : null;
        case "vihangayt":
            $instances = [1, 2, 3, 4];
            foreach ($instances as $instance) {
                $api_url = "https://vihangayt.me/tools/chatgpt$instance?q=" . urlencode($query);
                $response = @file_get_contents($api_url);
                if ($response) {
                    $chatgpt_response = json_decode($response, true);
                    if ($chatgpt_response["status"] && isset($chatgpt_response["data"]["message"])) {
                        return $chatgpt_response["data"]["message"];
                    }
                }
            }
            return null;
        case "apinepdev":
            $api_url = "https://chatgpt.apinepdev.workers.dev/?question=" . urlencode($query);
            $response = @file_get_contents($api_url);
            return $response ? json_decode($response, true)["answer"] : null;
        default:
            return null;
    }
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
        $command = $_SERVER["HTTP_COMMAND"];
        if (strpos($message, $command) === 0) {
            $message = trim(substr($message, strlen($command)));
            $response = getChatGPTResponse("ai-tools", $message, $sender);
            http_response_code(200);
            echo json_encode(["replies" => [["message" => $response]]]);
            exit();
        }
    }

    $response = getChatGPTResponse("ai-tools", $message, $sender);
    http_response_code(200);
    echo json_encode(["replies" => [["message" => $response]]]);
} else {
    http_response_code(400);
    echo json_encode([
        "replies" => [["message" => "❌ Error!"], ["message" => "JSON data is incomplete. Was the request sent by AutoResponder?"]],
    ]);
}
?>