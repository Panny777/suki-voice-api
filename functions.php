<?php

class Functions
{

    function httpInput()
    {
        $input = file_get_contents("php://input");
        if (!$this->json_validator($input)) {
            return False;
        }
        $input = json_decode($input, TRUE);
        return $input;
    }


    // Functions to Validate Data from SQLI
    function test_input($data)
    {
        global $connection;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        $data = mysqli_real_escape_string($connection, $data);

        // return preg_replace('/[^A-Za-z0-9\-]/', '', $data); // Removes special chars. 
        return $data;
    }



    function json_validator($data)
    {
        if (!empty($data)) {
            @json_decode($data, true);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }


    function dbConnection()
    {
        // Database Credentials
        $mode = "127.0.0.1";
        $username = "root";
        $password = "";
        $database = "suki-voice";

        $connection = mysqli_connect($mode, $username, $password, $database);

        if (!$connection) {
            die("Database conection failed!!");
        };

        return $connection;
    }



    function getTillInfo($tillNumber)
    {
        global $connection, $data_array;

        $query = "SELECT * FROM tills WHERE `till_number` = '{$tillNumber}'";
        $select_till = mysqli_query($connection, $query);

        if (!$tillRow = mysqli_fetch_assoc($select_till)) {
            $stdClass = new stdClass();
            $stdClass->result = "Till Number does not exist";
            $stdClass->status_code = 400;
            array_push($data_array, $stdClass);
            return False;
        } else {
            $clientId = $tillRow['client_id'];
            $TerminalId = $tillRow['terminal_id'];
            $networkId = $tillRow['network_id']; // 1 for Vodacom, 2 for Yas, 3 for airtel
            $till_network = $this->getTillNetwork($networkId);

            if ($networkId == 1) {
                $networkAudioFile = "VODA_LIPA.mp3+";
            } elseif ($networkId == 2) {
                $networkAudioFile = "YAS_LIPA.mp3+";
            } elseif ($networkId == 3) {
                $networkAudioFile = "AIRTEL_LIPA.mp3+";
            }

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
                return array($till_network, $networkAudioFile, $terminalRow['serial_number']);
            } else {
                // make Request to Another API or Log info
                echo "Client not active";
                return False;
            }
        }
    }

    function getTillNetwork($till_network_id)
    {
        global $connection;
        $select_till_network_query = "SELECT * FROM networks WHERE id = '{$till_network_id}'";
        $select_till_network = mysqli_query($connection, $select_till_network_query);

        $till_network_row = mysqli_fetch_assoc($select_till_network);
        $till_network = $till_network_row['network'];
        return $till_network;
    }
}
