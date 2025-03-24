<?php

include 'vendor/autoload.php';
include 'getAudioFiles.php';
include 'functions.php';

$functions = new Functions;

$data_array = array();
$connection = $functions->dbConnection();


// Connection Configuration
$server   = '193.27.90.199';
$port     = 1883;
$ApiclientId = 'mainServer';

// Accept Json
header('Content-Type: application/json');

/*
curl "http://127.0.0.1:5000" -H "Content-Type: application/json"  -d '{"tillNumber":"1","MSISDN":"+255", "amount":"1000", "transactionId":"111-1a32-12s", "name":"MUNIRU"}' 

*/

// Receive data from POST Request
// {"tillNumber":"","MSISDN":"+255", "amount":"1000", "transactionId":"111-1a32-12s", "name":"MUNIRU"}
$data = $functions->httpInput();

$amount = isset($data['amount']) ? $functions->test_input($data['amount']) : NULL;
$amount = intval($amount);
$msisdn = isset($data['MSISDN']) ? $functions->test_input($data['MSISDN']) : NULL;
$msisdn_names = isset($data['name']) ? $functions->test_input($data['name']) : NULL;
$tillNumber = isset($data['tillNumber']) ? $functions->test_input($data['tillNumber']) : NULL;
$transactionId = isset($data['transactionId']) ? $functions->test_input($data['transactionId']) : NULL;

try {
    if (!$amount || !$msisdn || !$msisdn_names || !$tillNumber || !$transactionId) {
        $data_array = [
            'code' => 401,
            'message' => 'Some Fields are missing'
        ];
    } else {
        // Get Client Serial Number
        list($till_network, $networkAudioFile, $terminalSerialNumber) = $functions->getTillInfo($tillNumber);

        if ($terminalSerialNumber) {
            $message = $data;
            $files = getAudioFiles($amount);
            $files = $networkAudioFile . $files;

            $message = '{"type":"MP", "file":"' . $files . '"}';
            // $message = '{"type":"MP", "file":"' . $files . '"}';
            // $receiver = '{"type":"TB", "msg":"' . $name . '"}';
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

            // Insert Transaction details
            $add_transaction_query = "INSERT INTO transactions(transaction_id, till_number, network, amount, msisdn, msisdn_names)";
            $add_transaction_query .= "VALUES('{$transactionId}', '{$tillNumber}', '{$till_network}', '{$amount}', '{$msisdn}', '{$msisdn_names}')";

            $add_transaction = mysqli_query($connection, $add_transaction_query);
            if (!$add_transaction) {
                throw new Exception("Duplicate Transaction Id");
                // Make Json data
                $data_array = [
                    'code' => 402,
                    'message' => 'Duplicate Transaction Id'
                ];
            } else {

                $mqtt_topic = 'suki/' . $terminalSerialNumber;
                $mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $ApiclientId);
                $mqtt->connect();
                $mqtt->publish($mqtt_topic, $message, 0); // imepokea Tsh {$amount}
                // $mqtt->publish($mqtt_topic, $receiver, 0); // kutoka kwa {$name}
                $mqtt->disconnect();

                // Return Success Message
                $stdClass = new stdClass();
                $stdClass->result = "success";
                $stdClass->status_code = 200;
                array_push($data_array, $stdClass);
            }
        }
    }
} catch (Exception $e) {
    // $this->log("SUKI *** " . $e->getMessage() . " - " . $e->getCode(), 1);
    $data_array = [
        'code' => 500,
        'message' => $e->getMessage()
    ];
}




$data_array = json_encode($data_array);
$data_array = str_replace('[', '', $data_array);
$data_array = str_replace(']', '', $data_array);
print_r($data_array);
