<?php

/*
 * testing started on Feb 23 2024
 * 
 * 
 */

//Establish testing cases between 1k - 99.99K
/* 1000 - 9999
  * 10,000 - 99,9999
  * 100,000 - 999,999
  * ignore Millionth case
  */

// $audioFiles = announce(readNumber($argv[1]));

// // Remove spaces from audio file string
// echo  str_replace(' ', '', $audioFiles);


function getAudioFiles($amount) {
    $audioFiles = str_replace(' ', '', announce(readNumber($amount)));
    $audioFiles = str_replace('MP3', 'mp3', $audioFiles);
    $audioFiles = str_replace('+.mp3', '', $audioFiles);

    return $audioFiles;
}



function newLine()
{
    echo "<BR>";
}

function printLine($string)
{
    echo $string;
    echo "<BR>";
}

function checkNumberSize($number)
{
    /*
     * check if it's a valid number
     */

    $numberString = strval($number);
    $length = strlen($numberString);

    return $length;

    /*
     switch($length)
     {
        case 1 : 1;
        break;
        case 2 
     } */
}



function readNumber($number)
{
    $finalValue = "";
    $numberSize = checkNumberSize($number);
    // echo "number size is " . $numberSize . "<BR>";
    switch ($numberSize) {
        case 1:
            $finalValue = announce(mamoja($number));
            break;
        case 2:
            $finalValue = buildMakumi($number);
            break;
        case 3:
            $finalValue = buildMamia($number);
            break;
        case 4:
            $finalValue = buildMaelfu($number);
            break;
        case 5:
            $finalValue = buildMakumiElfu($number);
            break;
        case 6:
            $finalValue = simpleBuildMalaki($number);
            break;
        case 7:
            $finalValue = buildMamilioni($number);
    }
    return $finalValue;
}

function buildMakumi($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number));

    if (getDigitAtMamoja($number) == 0)
        return $makumi;
    return $makumi . " NA " . $mamoja;
}

function buildMamia($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number));
    $mamia = mamia(getDigitAtMamia($number));

    if (getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0) {
        return $mamia;
    } else if (getDigitAtMamoja($number) == 0) //i.e. 780 >> preventing mia saba themanini na sifuri :)
    {
        echo "1";
        return $mamia . " " . $makumi . "" . $mamoja;
    }
    echo "2";
    echo "3";
    return $mamia . " " . $makumi . " NA " . $mamoja;
}

function simpleBuildMalaki($number)
{
    $malaki = intval(substr(strval($number), 0, 1));
    $makumiElfu = intval(substr(strval($number), 1, 5));
    $announce = $makumiElfu == 0 ? malaki($malaki)  :  malaki($malaki) . "  " . buildMakumiElfu($makumiElfu);
    return strtoupper($announce) . "";   
}

function buildMalaki($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number));
    $mamia = mamia(getDigitAtMamia($number));
    $maelfu = maelfu(getDigitAtMaelfu($number));
    $malaki = malaki(getDigitAtMalaki($number));

    if (getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0 && getDigitAtMaelfu($number) == 0) //9000 //9100 //9110
    {
        return $malaki;
    } else if (getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0) //i.e. 7800 >> preventing mia saba themanini na sifuri :)
    {

        //return $malaki . " " .   $maelfu; // . " " . $makumi . "" . $mamoja;  //old logic
        return $malaki . " " .   $maelfu  . " " . $makumi . "" . $mamoja;
    }
}

function buildMakumiElfu($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number));
    $mamia = mamia(getDigitAtMamia($number));
    $maelfu = maelfu(getDigitAtMaelfu($number));
    $makumiElfu = makumiElfuDouble($number);
    $makumiElfuReverse = makumiElfuReverse($number);

    if (getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0
        /** && getDigitAtMaelfu($number) == 0  */
    ) //90,000 //9100 //9110
    {
        return $makumiElfu;
    } else if (getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0) //i.e. 21,100 >> preventing mia saba themanini na sifuri :)
    {
        return $makumiElfu . " NA.mp3+ " .   $mamia; // . " " . $makumi . "" . $mamoja; 
    } else if (getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0) //i.e. 21,001 >> preventing mia saba themanini na sifuri :)
    {
        return $makumiElfuReverse . " NA " .   $mamoja; // . " " . $makumi . "" . $mamoja;  //announce in reverse
    }
    // else if(getDigitAtMamoja($number) == 0 && getDigitAtMamia($number) == 0 ) //90010 //90015
    // {
    //     return $makumiElfuReverse . " NA " . $makumi ; // . " " . $makumi . "" . $mamoja;  //announce in reverse
    // }
    else if ( /* getDigitAtMamoja($number) == 0   && */getDigitAtMamia($number) == 0) //90010 //90015
    {
        return (getDigitAtMakumi($number) > 0 && getDigitAtMamoja($number)) > 0 ?  $makumiElfuReverse . " NA " . $makumi . " NA " . $mamoja :  $makumiElfuReverse . " NA " . $makumi; // . " " . $makumi . "" . $mamoja;  //announce in reverse
    }
    /* below block was added on Feb 23 2025 at 0851hrs to cater for 19,110 */ else if (getDigitAtMamoja($number) == 0) //19110 //19120
    {
        return $makumiElfu  . " " .  $mamia . " NA " . $makumi; // . "" . $mamoja;  19110
    }

    return getDigitAtMamoja($number) > 0 ? $makumiElfu . " " . $mamia . " " . $makumi . " NA.mp3+ " . $mamoja : $makumiElfu . " " . $mamia . " " . $makumi . " " . $mamoja;
}

function buildMaelfu($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number));
    $mamia = mamia(getDigitAtMamia($number));
    $maelfu = maelfu(getDigitAtMaelfu($number));

    if (getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0) //9000 //9100 //9110
    {
        return $maelfu;
    } else if (getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0) //i.e. 7800 >> preventing mia saba themanini na sifuri :)
    {
        return $maelfu . " " .   $mamia; // . " " . $makumi . "" . $mamoja; 
    } else if (getDigitAtMamia($number) == 0 && getDigitAtMamoja($number) == 0) {
        return $maelfu . " NA.mp3+ " . $makumi; //9020 
    } else if (getDigitAtMamoja($number) == 0) {
        return $maelfu . " " . $mamia . " NA.mp3+ " . $makumi; //9120 
    }

    return $maelfu . " " . $mamia . " " . $makumi . " NA.mp3+ " . $mamoja;
}

function mamoja($number)
{
    $announce = "";
    switch ($number) {
        case 1:
            $announce = "moja";
            break;
        case 2:
            $announce = "mbili";
            break;
        case 3:
            $announce = "tatu";
            break;
        case 4:
            $announce = "nne";
            break;
        case 5:
            $announce = "tano";
            break;
        case 6:
            $announce = "sita";
            break;
        case 7:
            $announce = "saba";
            break;
        case 8:
            $announce = "nane";
            break;
        case 9:
            $announce = "tisa";
            break;
    }

    return strtoupper($announce) . ".mp3+";   
}


function makumi($number)
{
    $announce = "";
    switch ($number) {
        case 1:
            $announce = "kumi";
            break;
        case 2:
            $announce = "ishirini";
            break;
        case 3:
            $announce = "thelathini";
            break;
        case 4:
            $announce = "arobaini";
            break;
        case 5:
            $announce = "hamsini";
            break;
        case 6:
            $announce = "sitini";
            break;
        case 7:
            $announce = "sabini";
            break;
        case 8:
            $announce = "themanini";
            break;
        case 9:
            $announce = "tisini";
            break;
    }
    return strtoupper($announce) . ".mp3+";   
}

function mamia($number)
{
    $announce = "";
    switch ($number) {
        case 1:
            $announce = "mia_moja";
            break;
        case 2:
            $announce = "mia_mbili";
            break;
        case 3:
            $announce = "mia_tatu";
            break;
        case 4:
            $announce = "mia_nne";
            break;
        case 5:
            $announce = "mia_tano";
            break;
        case 6:
            $announce = "mia_sita";
            break;
        case 7:
            $announce = "mia_saba";
            break;
        case 8:
            $announce = "mia_nane";
            break;
        case 9:
            $announce = "mia_tisa";
            break;
    }

    return strtoupper($announce) . ".mp3+";   
}

function mamilioni($number)
{
    $announce = "";
    $length = strlen(strval($number));
    if ($length == 1) {
        switch ($number) {
            case 1:
                $announce = "Milioni moja";
                break;
            case 2:
                $announce = "Milioni mbili";
                break;
            case 3:
                $announce = "Milioni tatu";
                break;
            case 4:
                $announce = "Milioni nne";
                break;
            case 5:
                $announce = "Milioni tano";
                break;
            case 6:
                $announce = "Milioni sita";
                break;
            case 7:
                $announce = "Milioni saba";
                break;
            case 8:
                $announce = "Milioni nane";
                break;
            case 9:
                $announce = "Milioni tisa";
                break;
        }
    } else if ($length == 2) {
        $firstDigit = intval(substr(strval($number), 0, 1));
        $secondDigit = intval(substr(strval($number), 1, 1));
        $announce = "Milioni " . buildMakumi($number);
    } else if ($length == 3) {
        $firstDigit = intval(substr(strval($number), 0, 1));
        $firstDigit = intval(substr(strval($number), 0, 1));
        $thirdDigit = intval(substr(strval($number), 2, 1));
        $announce = "Milioni " . buildMamia($number);
    }


    return strtoupper($announce) . ".mp3+";   
}


function buildMamilioni($number)
{
    $length = strlen(strval($number));
    if ($length < 4)
        return mamilioni($number);

    $mamilioni = intval(substr(strval($number), 0, 1));
    $malaki = intval(substr(strval($number), 1, 1));
    // printLine("malaki is $malaki");
    // $makumiElfu = intval(substr(strval($number),2,5));
    $makumiElfu = getDigitAtMakumiElfu($number);
    $maelfu = intval(substr(strval($number), 3, 1));
    $mamia = intval(substr(strval($number), 4, 1));
    $makumi = intval(substr(strval($number), 5, 1));
    $mamoja = intval(substr(strval($number), 6, 1));

    // printLine("maelfu is $maelfu");
    // printLine("mamia is $mamia");
    // printLine("makumi is $makumi");
    // printLine("mamoja is $mamoja");
    // printLine("makumi elfu is $makumiElfu");
    // $announce = $makumiElfu == 0 ? mamilioni($mamilioni) . " NA " . malaki($malaki) : mamilioni($mamilioni) . " " . malaki($malaki) . " NA " . buildMakumiElfu($makumiElfu);
    if ($makumiElfu  == 0 && $maelfu  == 0 && $mamia  == 0 && $mamoja  == 0) //1400010
    {
        $announce = mamilioni($mamilioni) . " " . malaki($malaki) . " NA " . makumi($makumi);
    } else if ($mamia  == 0 && $makumi  == 0 && $mamoja  == 0) //1401000
    {
        $announce = mamilioni($mamilioni) . " NA " . maelfu($maelfu);
    } else if ($makumiElfu == 0) {
        $announce = mamilioni($mamilioni) . " NA " . malaki($malaki);
    } else {
        $announce = mamilioni($mamilioni) . " " . malaki($malaki) . " NA " . buildMakumiElfu($makumiElfu);
    }
    return strtoupper($announce) . ".mp3+";   
}

function malaki($number)
{
    $announce = "";
    switch ($number) {
        case 1:
            $announce = "laki_moja";
            break;
        case 2:
            $announce = "laki_mbili";
            break;
        case 3:
            $announce = "laki_tatu";
            break;
        case 4:
            $announce = "laki_nne";
            break;
        case 5:
            $announce = "laki_tano";
            break;
        case 6:
            $announce = "laki_sita";
            break;
        case 7:
            $announce = "laki_saba";
            break;
        case 8:
            $announce = "laki_nane";
            break;
        case 9:
            $announce = "laki_tisa";
            break;
    }

    return strtoupper($announce) . ".mp3+";   
}

function makumiElfuDouble($number)
{

    $announce = "";
    $maelfu = getDigitAtMaelfu($number);
    $makumiElfu = getDigitAtMakumiElfu($number);

    switch ($makumiElfu) {
        case 1:
            $announce = ($maelfu > 0) ?  "elfu_kumi" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_kumi";
            break;
        case 2:
            $announce = $maelfu > 0 ?  "elfu_ishirini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_ishirini";
            break;
        case 3:
            $announce = $maelfu > 0 ?  "elfu_thelathini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_thelathini";
            break;
        case 4:
            $announce = $maelfu > 0 ?  "elfu_arobaini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_arobaini";
            break;
        case 5:
            $announce = $maelfu > 0 ?  "elfu_hamsini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_hamsini";
            break;
        case 6:
            $announce = $maelfu > 0 ?  "elfu_sitini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_sitini";
            break;
        case 7:
            $announce = $maelfu > 0 ?  "elfu_sabini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_sabini";
            break;
        case 8:
            $announce = $maelfu > 0 ?  "elfu_themanini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_themanini";
            break;
        case 9:
            $announce = $maelfu > 0 ?  "elfu_tisini" . " .mp3+NA.mp3+ " . mamoja($maelfu) : "elfu_tisini";
            break;
    }
    return strtoupper($announce) . ".mp3+";   
}

function makumiElfu($number)
{
    printLine("number is " . $number);
    $announce = "";
    $makumiElfu = getDigitAtMakumiElfu($number);
    switch ($makumiElfu) {

        case 1:
            $announce = (getDigitAtMaelfu($number) > 0) ?  "elfu_kumi" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_kumi";
            break;
        case 2:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_ishirini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_ishirini";
            break;
        case 3:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_thelathini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_thelathini";
            break;
        case 4:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_arobaini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_arobaini";
            break;
        case 5:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_hamsini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_hamsini";
            break;
        case 6:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_sitini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_sitini";
            break;
        case 7:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_sabini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_sabini";
            break;
        case 8:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_themanini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_themanini";
            break;
        case 9:
            $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_tisini" . " NA " . mamoja(getDigitAtMaelfu($number)) : "elfu_tisini";
            break;
    }
    return strtoupper($announce) . ".mp3+";   
}

function makumiElfuReverse($number)
{
    $announce = "";

    $maelfu = getDigitAtMaelfu($number);
    $makumiElfu = getDigitAtMakumiElfu($number);

    switch ($makumiElfu) {
        case 1:
            $announce = ($maelfu > 0) ?  "kumi " . " NA " . mamoja($maelfu) . " elfu" : "kumi elfu";
            break;
        case 2:
            $announce = $maelfu > 0 ?  "ishirini" . " NA " . mamoja($maelfu) . " elfu" : "ishirini elfu";
            break;
        case 3:
            $announce = $maelfu > 0 ?  "thelathini" . " NA " . mamoja($maelfu) . " elfu" : "thelathini elfu";
            break;
        case 4:
            $announce = $maelfu > 0 ?  "arobaini" . " NA " . mamoja($maelfu) . " elfu" : "arobaini elfu";
            break;
        case 5:
            $announce = $maelfu > 0 ?  "hamsini" . " NA " . mamoja($maelfu) . " elfu" : "hamsini elfu";
            break;
        case 6:
            $announce = $maelfu > 0 ?  "sitini" . " NA " . mamoja($maelfu) . " elfu" : "sitini elfu";
            break;
        case 7:
            $announce = $maelfu > 0 ?  "sabini" . " NA " . mamoja($maelfu) . " elfu" : "sabini elfu";
            break;
        case 8:
            $announce = $maelfu > 0 ?  "themanini" . " NA " . mamoja($maelfu) . " elfu" : "themanini elfu";
            break;
        case 9:
            $announce = $maelfu > 0 ?  "tisini" . " NA " . mamoja($maelfu) . " elfu" : "tisini elfu";
            break;
    }

    return strtoupper($announce) . ".mp3+";   
}

function maelfu($number)
{
    $announce = "";
    switch ($number) {
        case 1:
            $announce = "elfu_moja";
            break;
        case 2:
            $announce = "elfu_mbili";
            break;
        case 3:
            $announce = "elfu_tatu";
            break;
        case 4:
            $announce = "elfu_nne";
            break;
        case 5:
            $announce = "elfu_tano";
            break;
        case 6:
            $announce = "elfu_sita";
            break;
        case 7:
            $announce = "elfu_saba";
            break;
        case 8:
            $announce = "elfu_nane";
            break;
        case 9:
            $announce = "elfu_tisa";
            break;
    }

    return strtoupper($announce) . ".mp3+";   
}

function testmamoja()
{
    echo "one thousand";
    newLine();
    echo mamoja(1);
    newLine();
    echo mamoja(2);
    newLine();
    echo mamoja(3);
    newLine();
    echo mamoja(4);
    newLine();
    echo mamoja(5);
    newLine();
    echo mamoja(6);
    newLine();
    echo mamoja(7);
    newLine();
    echo mamoja(8);
    newLine();
    echo mamoja(9);
}



function getDigitAtMakumi($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number) - 2, 1));
}

function getDigitAtMamoja($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number) - 1, 1));
}

function getDigitAtMamia($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number) - 3, 1));
}

function getDigitAtMaelfu($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number) - 4, 1));
}

function getDigitAtMakumiElfu($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number) - 5, 1));
}

function getDigitAtMalaki($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number) - 6, 1));
}



function announce($number)
{
    return $number;
    // newLine();
}

function announceInline($number)
{
    echo $number;
    echo " ";
}
