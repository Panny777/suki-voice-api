<?php
$data_array = array();


// Database Credentials
$mode = "127.0.0.1";
$username = "root";
$password = "";
$database = "suki-voice";

$connection = mysqli_connect($mode, $username, $password, $database);

if (!$connection) {
    die("Database conection failed!!");
}

include 'vendor/autoload.php';
include 'getAudioFiles.php';

// Connection Configuration
$server   = '193.27.90.199';
$port     = 1883;
$clientId = 'mainServer';

// Accept Json
header('Content-Type: application/json');

// curl "http://127.0.0.1:5000" -H "Content-Type: application/json" -d '{"tillNumber":"1","MSISDN":"+255", "amount":"1000", "transactionId":"111-1a32-12s", "name":"MUNIRU"}'
// Receive data from POST Request
// {"tillNumber":"","MSISDN":"+255", "amount":"1000", "transactionId":"111-1a32-12s", "name":"MUNIRU"}
$data = file_get_contents('php://input');
if (!json_validator($data)) {
    echo '{"success":false, "message":"Provide Valid JSON"}';
} else {
    // Get Details from POST Data
    $data = json_decode($data, true);
    $amount = test_input($data['amount'], $connection);
    $tillNumber = test_input($data['tillNumber'], $connection);
    $name = test_input($data['name'], $connection);

    // Get Client Serial Number
    $serialNumber = getSerialNumber($tillNumber);
    if ($serialNumber) {
        $message = $data;
        $files = getAudioFiles($amount);
        $message = '{"type":"MP", "file":"' . $files . '"}';

        // $sender = '{"type":"TB", "msg":"uumeepokea"}';
        /*
        * Message comes in the following JSON format:
        * 1. transaction broadcasting		{"type":"TB", "msg":"Hello"}
        * 2. update notification			{"type":"UN"}
        * 3. synchronize time				{"type":"ST", "time":"20211016213200"}
        * 4. play MP3 file					{"type":"MP", "file":"2.mp3+1.mp3+3.mp3+2.mp3"}
        * 5. play amount					{"type":"TS", "amount":"12.33"}
        * Invalid messages are just ignored.
        *
        * Message should be less than 1024 bytes
        */
        $mqtt_topic = 'suki/' . $serialNumber;
        $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        $mqtt->connect();
        $mqtt->publish($mqtt_topic, $message, 0);
        $mqtt->disconnect();

        // Return Success Message
        $stdClass = new stdClass();
        $stdClass->result = "success";
        $stdClass->status_code = 200;
        array_push($data_array, $stdClass);
    }
}


function json_validator($data)
{
    if (!empty($data)) {
        @json_decode($data, true);
        return (json_last_error() === JSON_ERROR_NONE);
    }
    return false;
}

// Functions to Validate Data from SQLI
function test_input($data, $connection)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    $data = mysqli_real_escape_string($connection, $data);

    // return preg_replace('/[^A-Za-z0-9\-]/', '', $data); // Removes special chars. 
    return $data;
}


function getSerialNumber($tillNumber)
{
    global $connection, $data_array;

    $query = "SELECT * FROM tills WHERE `till_number` = '{$tillNumber}'";
    $select_till = mysqli_query($connection, $query);

    if (!$row = mysqli_fetch_assoc($select_till)) {
        $stdClass = new stdClass();
        $stdClass->result = "Till Number does not exist";
        $stdClass->status_code = 400;
        array_push($data_array, $stdClass);
        return False;
    } else {
        $clientId = $row['client_id'];
        $TerminalId = $row['terminal_id'];

        // Fetch User Informations
        $selectClientQuery = "SELECT * FROM clients WHERE `id` = '{$clientId}'";
        $selectClient = mysqli_query($connection, $selectClientQuery);

        $clientRow = mysqli_fetch_assoc($selectClient);
        $clientStatus = $clientRow['is_active'];
        if ($clientStatus) {
            // Fetch Termianl Serial Number
            $selectTerminalQuery = "SELECT * FROM terminals WHERE `id` = '{$TerminalId}' AND `is_active` = 1";
            $selectTerminal = mysqli_query($connection, $selectTerminalQuery);

            $terminalRow = mysqli_fetch_assoc($selectTerminal);

            if (!$terminalRow || !isset($terminalRow['serial_number'])) {
                echo "Terminal not active";
                return false;
            }
            return $terminalRow['serial_number'];

        } else {
            // make Request to Another API or Log info
            echo "Client not active";
            return False;
        }
    }
}

$data_array = json_encode($data_array);
$data_array = str_replace('[', '', $data_array);
$data_array = str_replace(']', '', $data_array);
print_r($data_array);
