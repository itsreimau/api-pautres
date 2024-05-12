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
function getSholatResponse($kota)
{
    $kota = preg_replace('/\b(?:kabupaten|kota)\b/i', '', $kota);
    $kota = trim($kota);

    $cariKotaUrl = "https://api.myquran.com/v2/sholat/kota/cari/" . urlencode($kota);
    $resultKota = file_get_contents($cariKotaUrl);
    $dataKota = json_decode($resultKota, true);

    if ($dataKota["status"] && !empty($dataKota["data"])) {
        $selectedCity = null;

        foreach ($dataKota["data"] as $kotaData) {
            if (stripos($kotaData["lokasi"], "KOTA") !== false || stripos($kotaData["lokasi"], "KAB.") !== false) {
                $selectedCity = $kotaData;
                break;
            }
        }

        if ($selectedCity === null) {
            $selectedCity = $dataKota["data"][0];
        }

        $kotaId = $selectedCity["id"];

        $tanggal = date("Y/m/d");
        $jadwalSholatUrl = "https://api.myquran.com/v2/sholat/jadwal/" . $kotaId . "/" . $tanggal;
        $resultJadwal = file_get_contents($jadwalSholatUrl);
        $dataJadwal = json_decode($resultJadwal, true);

        if ($dataJadwal["status"] && !empty($dataJadwal["data"])) {
            return $dataJadwal["data"];
        } else {
            return "Terjadi kesalahan saat mendapatkan jadwal sholat.";
        }
    } else {
        return "Terjadi kesalahan saat mencari kota.";
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
    if (isset($_SERVER["HTTP_EXPERIMENTAL"]) && $_SERVER["HTTP_EXPERIMENTAL"] === "true") {
        if (isset($_SERVER["HTTP_REGEX"])) {
            $regexPattern = $_SERVER["HTTP_REGEX"];
            if (preg_match($regexPattern, $message, $argument)) {
                $capturingGroup1 = isset($_SERVER["HTTP_ARGS1"]) ? $_SERVER["HTTP_ARGS1"] : 1;
                $argument1 = isset($argument[$capturingGroup1]) ? trim($argument[$capturingGroup1]) : '';
                $result = getSholatResponse($argument1);
                if (is_array($result)) {
                    $response = $result["lokasi"] . " - " . $result["daerah"] . "\n";
                    $response .= "• Imsak: " . $result["jadwal"]["imsak"] . "\n";
                    $response .= "• Subuh: " . $result["jadwal"]["subuh"] . "\n";
                    $response .= "• Terbit: " . $result["jadwal"]["terbit"] . "\n";
                    $response .= "• Dhuha: " . $result["jadwal"]["dhuha"] . "\n";
                    $response .= "• Dzuhur: " . $result["jadwal"]["dzuhur"] . "\n";
                    $response .= "• Ashar: " . $result["jadwal"]["ashar"] . "\n";
                    $response .= "• Maghrib: " . $result["jadwal"]["maghrib"] . "\n";
                    $response .= "• Isya: " . $result["jadwal"]["isya"] . "\n";
                } else {
                    $response = $result;
                }

                $replies = ["replies" => [["message" => $response]]];
            }
        }
    } else {
        $result = getSholatResponse($message);
        if (is_array($result)) {
            $response = $result["lokasi"] . " - " . $result["daerah"] . "\n";
            $response .= "• Imsak: " . $result["jadwal"]["imsak"] . "\n";
            $response .= "• Subuh: " . $result["jadwal"]["subuh"] . "\n";
            $response .= "• Terbit: " . $result["jadwal"]["terbit"] . "\n";
            $response .= "• Dhuha: " . $result["jadwal"]["dhuha"] . "\n";
            $response .= "• Dzuhur: " . $result["jadwal"]["dzuhur"] . "\n";
            $response .= "• Ashar: " . $result["jadwal"]["ashar"] . "\n";
            $response .= "• Maghrib: " . $result["jadwal"]["maghrib"] . "\n";
            $response .= "• Isya: " . $result["jadwal"]["isya"] . "\n";
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