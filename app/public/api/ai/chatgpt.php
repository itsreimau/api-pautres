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
function getChatGPTResponse($query, $uid)
{
    $api_url = "https://ai-tools.replit.app/gpt?prompt=" . urlencode($query) . "&uid=" . urlencode($uid);
    $response = @file_get_contents($api_url);
    return $response ? json_decode($response, true)["gpt4"] : null;
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
            $response = getChatGPTResponse($argument, $sender);
            $replies = ["replies" => [["message" => $response]]];
        }
    } else {
        $response = getChatGPTResponse($message, $sender);
        $replies = ["replies" => [["message" => $response]]];
    }

    http_response_code(200);
    echo json_encode($replies);
} else {
    http_response_code(400);
    echo json_encode(["replies" => [["message" => "❌ Error!"], ["message" => "JSON data is incomplete. Was the request sent by AutoResponder?"]]]);
}
?>