<?php

// Don't disturb
require __DIR__ . "/../../vendor/autoload.php";

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Add this PHP file to your web server and enter the complete URL in AutoResponder (e.g., https://www.example.com/api_autoresponder.php)

// To allow only authorized requests, configure your .htaccess file and set the credentials with the Basic Auth option in AutoResponder

// Access a custom header added in your AutoResponder rule
// Replace XXXXXX_XXXX with the name of the header in UPPERCASE (and with '-' replaced by '_')
$myheader = $_SERVER["HTTP_XXXXXX_XXXX"];

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Function
function getSimsimiResponse($message, $language, $apiKey = "")
{
    // SimSimi API URL
    $apiUrl = "https://api.simsimi.vn/v1/simtalk";

    // Prepare POST data
    $postData = [
        "text" => $message,
        "lc" => $language,
        "key" => $apiKey,
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/x-www-form-urlencoded"]);

    // Execute cURL session and get the API response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        // You may want to handle the error appropriately, for example, log it
        return null;
    }

    // Close cURL session
    curl_close($ch);

    // Decode the JSON response
    $result = json_decode($response, true);

    // Check if the response contains 'message' and return it, otherwise return null
    return isset($result["message"]) ? $result["message"] : null;
}

// Make sure JSON data is not incomplete
if (!empty($data->query) && !empty($data->appPackageName) && !empty($data->messengerPackageName) && !empty($data->query->sender) && !empty($data->query->message)) {
    // Package name of AutoResponder to detect which AutoResponder the message comes from
    $appPackageName = $data->appPackageName;
    // Package name of messenger to detect which messenger the message comes from
    $messengerPackageName = $data->messengerPackageName;
    // Name/number of the message sender (like shown in the Android notification)
    $sender = $data->query->sender;
    // Text of the incoming message
    $message = $data->query->message;
    // Is the sender a group? True or false
    $isGroup = $data->query->isGroup;
    // Name/number of the group participant who sent the message if it was sent in a group, otherwise empty
    $groupParticipant = $data->query->groupParticipant;
    // ID of the AutoResponder rule which has sent the web server request
    $ruleId = $data->query->ruleId;
    // Is this a test message from AutoResponder? True or false
    $isTestMessage = $data->query->isTestMessage;

    // Process messages here

    // Check if the "HTTP_COMMAND" header exists
    if (isset($_SERVER["HTTP_COMMAND"])) {
        // Get the command from the header
        $command = $_SERVER["HTTP_COMMAND"];

        // Check if the message starts with the command
        if (strpos($message, $command) === 0) {
            // Remove the command from the message
            $message = trim(substr($message, strlen($command)));

            // Headers
            $language = $_SERVER["HTTP_LANGUAGE"];
            $apiKey = $_SERVER["HTTP_APIKEY"];

            // Further processing or reply generation can be added here based on the extracted message
            $response = getSimsimiResponse($message, $language, $apiKey);

            // Set response code - 200 success
            http_response_code(200);

            // Send one or multiple replies to AutoResponder
            echo json_encode(["replies" => [["message" => $response]]]);

            // Exit the script to avoid processing the message further
            exit();
        }
    }

    // Headers
    $language = $_SERVER["HTTP_LANGUAGE"];
    $apiKey = $_SERVER["HTTP_APIKEY"];

    // Further processing or reply generation can be added here based on the extracted message
    $response = getSimsimiResponse($message, $language, $apiKey);

    // If "HTTP_COMMAND" header is not present, provide a different response
    // Set response code - 200 success
    http_response_code(200);

    // Send one or multiple replies to AutoResponder
    echo json_encode(["replies" => [["message" => $response]]]);

    // Or this instead for no reply:
    // echo json_encode(array("replies" => array()));
}

// Tell the user JSON data is incomplete
else {
    // Set response code - 400 bad request
    http_response_code(400);

    // Send error
    echo json_encode([
        "replies" => [
            ["message" => "❌ Error!"],
            [
                "message" => "JSON data is incomplete. Was the request sent by AutoResponder?",
            ],
        ],
    ]);
}
?>