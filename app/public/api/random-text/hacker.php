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
function pickRandom($list)
{
    $randomIndex = array_rand($list);
    return $list[$randomIndex];
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
    $hacker = [
        "Dear kamu yang tertulis di halaman defacementku, Kapan jadi pacarku?",
        "Aku rela ko jadi Processor yg kepanasan, asalkan kmu yg jadi heatsink'y yg setiap saat bisa mendinginkan ku.",
        "Gak usah nyari celah xss deh, karena ketika kamu ngeklik hatiku udah muncul pop up namamu.",
        "berharap setelah aku berhasil login di hati kamu ga akan ada tombol logout, dan sessionku ga bakal pernah expired.",
        "Masa aku harus pake teknik symlink bypass buat buka-buka folder hatimu yg open_basedir enabled.",
        "Diriku dan Dirimu itu ibarat PHP dan MySQL yang belum terkoneksi.",
        "Jangan cuma bisa inject hatinya,tapi harus bisa patchnya juga. Biar tidak selingkuh sama hacker lain.",
        "Aku memang programmer PHP,tapi aku nggak akan php-in kamu kok.",
        "Eneeeng. | Apache? | Km wanita yg paling Unix yg pernah aku kenal |",
        "Sayang, capslock kamu nyala ya? | ngga, kenapa emangnya? | soalnya nama kamu ketulis gede bgt di hati aku | zzz! smile",
        "Aku deketin kamu cuma untuk redirect ke hati temenmu.",
        "Domain aja bisa parkir, masa cintaku ga bisa parkir dihatimu?",
        "Aku boleh jadi pacarmu? | 400(Bad Request) | Aku cium boleh? | 401(Authorization Required) | Aku buka bajumu yah | 402(Payment Required) sad",
        "kamu tau ga beda'y kamu sama sintax PHP, kalo sintax PHP itu susah di hafalin kalo kamu itu susah di lupain",
        "Kamu dulu sekolah SMK ambil kejuruan apa? | Teknik Komputer Jaringan | Terus sekarang bisa apa aja? | Menjaring hatimu lewat komputerku | biggrin",
        "Jika cinta itu Array, maka,cintaku padamu tak pernah empty jika di unset().",
        "SQLI ( Structured Query Love Injection )",
        "aku ingin kamu rm -rf kan semua mantan di otak mu,akulah root hati kamu",
        "Senyumu bagaikan cooler yang menyejukan hatiku ketika sedang overclock.",
        "kamu adalah terminalku, dimana aku menghabiskan waktuku untuk mengetikan beribu baris kode cinta untukmu smile",
        "Aku seneng nongkrong di zone-h, karena disanalah aku arsipkan beberapa website yang ada foto kamunya.",
        "hatiku ibarat vps hanya untukmu saja bukan shared hosting yg bisa tumpuk berbagai domain cinta.",
        "Aku bukanlah VNC Server Tanpa Authentication yg bisa kamu pantau kapan saja.",
        "Jangan men-dualboot-kan hatiku kepadamu.",
        "cintaku kan ku Ctrl+A lalu kan ku Ctrl+C dan kan ku Ctrl+V tepat di folder system hatimu.",
        "KDE kalah Cantiknya, GNOME kalah Simplenya, FluxBox kalah Ringannya, pokonya Semua DE itu Kalah Sama Kamu.",
        "Cintamu bagaikan TeamViewer yang selalu mengendalikan hatiku",
        "cinta kita tak akan bisa dipisahkan walau setebal apapun itu firewall...!!",
    ];

    http_response_code(200);
    echo json_encode(["replies" => [["message" => pickRandom($hacker)]]]);
} else {
    http_response_code(400);
    echo json_encode(["replies" => [["message" => "❌ Error!"], ["message" => "JSON data is incomplete. Was the request sent by AutoResponder?"]]]);
}
?>