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
function postDataToAPI($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    return json_decode($response, true);
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
    $result = postDataToAPI($url);

    if ($result) {
        $response = "- DNS: " . $result['dns'] . "\n";
        $response .= "- Username: " . $result['username'] . "\n";
        $response .= "- Connections: " . $result['connections'] . "\n";
        $response .= "- Password: " . $result['password'] . "\n";
        $response .= "- Package: " . $result['package'] . "\n";
        $response .= "- Created At: " . $result['createdAt'] . "\n";
        $response .= "- Expires At: " . $result['expiresAt'] . "\n";
        $response .= "- Pay URL: " . $result['payUrl'] . "\n";
        $response .= "- Reply: " . $result['reply'] . "\n";
        $replies = ["replies" => [["message" => $response]]];
    }

    http_response_code(200);
    echo json_encode($replies ?? ["replies" => [["message" => "No response from API."]]]);
} else {
    http_response_code(400);
    echo json_encode(["replies" => [["message" => "❌ Error!"], ["message" => "JSON data is incomplete. Was the request sent by AutoResponder?"]]]);
}
?>
