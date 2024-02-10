<?php

// Don't disturb
require __DIR__ . '/../../vendor/autoload.php';

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
$myheader = $_SERVER['HTTP_XXXXXX_XXXX'];

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Function
function getChatGPTResponse($api, $query)
{
    switch ($api) {
        case "vihangayt":
            $instances = [1, 2, 3, 4];

            foreach ($instances as $instance) {
                $api_url = "https://vihangayt.me/tools/chatgpt$instance?q=" . urlencode($query);
                $response = file_get_contents($api_url);
                $chatgpt_response = json_decode($response, true);

                // Check if the response status is true
                if ($chatgpt_response['status']) {
                    return $chatgpt_response['data'];
                }

                // If none of the ChatGPT instances provide a valid response
                return ["status" => false, "message" => "Unable to get a valid response from ChatGPT instances."];
                break;
            }
        case "apinepdev":
            $api_url = "https://chatgpt.apinepdev.workers.dev/?question=" . urlencode($query);
            $response = file_get_contents($api_url);
            $chatgpt_response = json_decode($response, true);

            // Check if the response status
            if (isset($chatgpt_response['answer'])) {
                return $chatgpt_response['answer'];
            }

            // If none of the ChatGPT provide a valid response
            return ["status" => false, "message" => "Unable to get a valid response from ChatGPT."];
            break;
        default:
            echo "API not found!";
    }
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
    if (isset($_SERVER['HTTP_COMMAND'])) {
        // Get the command pattern from the header
        $commandPattern = $_SERVER['HTTP_COMMAND'];

        // Check if the message contains a valid command
        if (preg_match($commandPattern, $message)) {
            // Remove the command from the message and trim the result
            $message = trim(preg_replace($commandPattern, '', $message));

            // Further processing or reply generation can be added here based on the extracted message
            $response = getChatGPTResponse('apinepdev', $message);

            // Set response code - 200 success
            http_response_code(200);

            // Send one or multiple replies to AutoResponder
            echo json_encode(["replies" => [["message" => $response]]]);

            // Exit the script to avoid processing the message further
            exit();
        }
    }

    // Further processing or reply generation can be added here based on the extracted message
    $response = getChatGPTResponse('apinepdev', $message);

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
    echo json_encode(["replies" => [["message" => "❌ Error!"], ["message" => "JSON data is incomplete. Was the request sent by AutoResponder?"]]]);
}
?>
