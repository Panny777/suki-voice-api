<?php

function getAudioFiles($amount) {
    $audioFiles = str_replace(' ', '', readNumber($amount));
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
    switch($numberSize)
    {
        case 1: $finalValue = announce(mamoja($number));
        break;
        case 2: $finalValue = buildMakumi($number);
        break;
        case 3: $finalValue = buildMamia($number);
        break;
        case 4: $finalValue = buildMaelfu($number);
        break;
        case 5: $finalValue = buildMakumiElfu($number);
        break;
        case 6: $finalValue = buildMalaki($number);
        break;
    }
    return $finalValue;
}

function buildMakumi($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number));

    if(getDigitAtMamoja($number) == 0)
        return $makumi;
    return $makumi . " na " . $mamoja;
}

function buildMamia($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number));
    $mamia = mamia(getDigitAtMamia($number));

    if(getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0)
    {      
        return $mamia;
    }else if(getDigitAtMamoja($number) == 0) //i.e. 780 >> preventing mia saba themanini na sifuri :)
    {
        echo "1";
        return $mamia . " " . $makumi . "" . $mamoja; 
    } echo "2";
    echo "3";
    return $mamia . " " . $makumi . " na " . $mamoja;    

}

function simpleBuildMalaki($number)
{
    $malaki = intval(substr(strval($number),0,1));
    $makumiElfu = intval(substr(strval($number),1,5));
    $announce = malaki($malaki) . " na " . buildMakumiElfu($makumiElfu);
    return strtoupper($announce) . ".mp3+";  
}

function buildMalaki($number) 
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number)); 
    $mamia = mamia(getDigitAtMamia($number));
    $maelfu = maelfu(getDigitAtMaelfu($number)); 
    $malaki = malaki(getDigitAtMalaki($number));

    if(getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0 && getDigitAtMaelfu($number) == 0) //9000 //9100 //9110
    {      
        return $malaki;
    }else if(getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0) //i.e. 7800 >> preventing mia saba themanini na sifuri :)
    {
        return $malaki . " " .   $maelfu; // . " " . $makumi . "" . $mamoja; 
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

    if(getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0 /** && getDigitAtMaelfu($number) == 0  */) //90,000 //9100 //9110
    {      
        return $makumiElfu;
    }else if(getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 ) //i.e. 21,100 >> preventing mia saba themanini na sifuri :)
    {
        return $makumiElfu . " na " .   $mamia; // . " " . $makumi . "" . $mamoja; 
    }else if(getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0 ) //i.e. 21,001 >> preventing mia saba themanini na sifuri :)
    {
        return $makumiElfuReverse . " na " .   $mamoja; // . " " . $makumi . "" . $mamoja;  //announce in reverse
    }
    // else if(getDigitAtMamoja($number) == 0 && getDigitAtMamia($number) == 0 ) //90010 //90015
    // {
    //     return $makumiElfuReverse . " na " . $makumi ; // . " " . $makumi . "" . $mamoja;  //announce in reverse
    // }
    else if( /* getDigitAtMamoja($number) == 0   && */ getDigitAtMamia($number) == 0   ) //90010 //90015
    {
        return (getDigitAtMakumi($number) > 0 && getDigitAtMamoja($number)) > 0 ?  $makumiElfuReverse . " na " . $makumi . " na " . $mamoja :  $makumiElfuReverse . " na " . $makumi ; // . " " . $makumi . "" . $mamoja;  //announce in reverse
    }
    return getDigitAtMamoja($number) > 0 ? $makumiElfu . " " . $mamia . " " . $makumi . " na ". $mamoja : $makumiElfu . " " . $mamia . " " . $makumi . " ". $mamoja ;

}

function buildMaelfu($number)
{
    $mamoja = mamoja(getDigitAtMamoja($number));
    $makumi = makumi(getDigitAtMakumi($number)); 
    $mamia = mamia(getDigitAtMamia($number));
    $maelfu = maelfu(getDigitAtMaelfu($number)); 

    if(getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0 && getDigitAtMamia($number) == 0) //9000 //9100 //9110
    {      
        return $maelfu;
    }else if(getDigitAtMamoja($number) == 0 && getDigitAtMakumi($number) == 0) //i.e. 7800 >> preventing mia saba themanini na sifuri :)
    {
        return $maelfu . " " .   $mamia; // . " " . $makumi . "" . $mamoja; 
    }else if(getDigitAtMamia($number) == 0 && getDigitAtMamoja($number) == 0)
    {
        return $maelfu . " na " . $makumi; //9020 
    }
    return $maelfu . " ". $mamia . " " . $makumi . " na " . $mamoja;    

}

function mamoja($number)
{
    $announce = "";
    switch($number)
    {
        case 1 : $announce = "moja";
        break;
        case 2 : $announce = "mbili";
        break;
        case 3 : $announce = "tatu";
        break;
        case 4 : $announce = "nne";
        break;
        case 5 : $announce = "tano";
        break;
        case 6 : $announce = "sita";
        break;       
        case 7 : $announce = "saba";
        break;
        case 8 : $announce = "nane";
        break;
        case 9 : $announce = "tisa";
        break;                                         

}
return strtoupper($announce) . ".mp3+";   
}


function makumi($number)
{
    $announce = "";
    switch($number)
    {
        case 1 : $announce = "kumi";
        break;
        case 2 : $announce = "ishirini";
        break;
        case 3 : $announce = "thelathini";
        break;
        case 4 : $announce = "arobaini";
        break;
        case 5 : $announce = "hamsini";
        break;
        case 6 : $announce = "sitini";
        break;       
        case 7 : $announce = "sabini";
        break;
        case 8 : $announce = "themanini";
        break;
        case 9 : $announce = "tisini";
        break;                                         

}
return strtoupper($announce) . ".mp3+";  

}

function mamia($number)
{
    $announce = "";
    switch($number)
    {
        case 1 : $announce = "na_mia_moja";
        break;
        case 2 : $announce = "na_mia_mbili";
        break;
        case 3 : $announce = "na_mia_tatu";
        break;
        case 4 : $announce = "na_mia_nne";
        break;
        case 5 : $announce = "na_mia_tano";
        break;
        case 6 : $announce = "na_mia_sita";
        break;       
        case 7 : $announce = "na_mia_saba";
        break;
        case 8 : $announce = "na_mia_nane";
        break;
        case 9 : $announce = "na_mia_tisa";
        break;    
        
       

}

return strtoupper($announce) . ".mp3+";  

}

function mamilioni($number)
{
    $announce = "";
    $length = strlen(strval($number));
    if($length == 1)
    {
        switch($number)
        {
            case 1 : $announce = "Milioni_moja";
            break;
            case 2 : $announce = "Milioni_mbili";
            break;
            case 3 : $announce = "Milioni_tatu";
            break;
            case 4 : $announce = "Milioni_nne";
            break;
            case 5 : $announce = "Milioni_tano";
            break;
            case 6 : $announce = "Milioni_sita";
            break;       
            case 7 : $announce = "Milioni_saba";
            break;
            case 8 : $announce = "Milioni_nane";
            break;
            case 9 : $announce = "Milioni_tisa";
            break;                                         
    
    }
    }else if($length == 2)
    {
        printLine("length is 2");
        $firstDigit = intval(substr(strval($number),0,1));
        $secondDigit = intval(substr(strval($number),1,1));
        $announce = "Milioni_" . buildMakumi($number);
    }else if($length == 3)
    {
        printLine("length is 3");
        $firstDigit = intval(substr(strval($number),0,1));
        $firstDigit = intval(substr(strval($number),0,1));
        $thirdDigit = intval(substr(strval($number),2,1));
        $announce = "Milioni_" . buildMamia($number);
    }


return strtoupper($announce) . ".mp3+";  
}

function malaki($number)
{
    $announce = "";
    switch($number)
    {
        case 1 : $announce = "laki_moja";
        break;
        case 2 : $announce = "laki_mbili";
        break;
        case 3 : $announce = "laki_tatu";
        break;
        case 4 : $announce = "laki_nne";
        break;
        case 5 : $announce = "laki_tano";
        break;
        case 6 : $announce = "laki_sita";
        break;       
        case 7 : $announce = "laki_saba";
        break;
        case 8 : $announce = "laki_nane";
        break;
        case 9 : $announce = "laki tisa";
        break;                                         

}

return strtoupper($announce) . ".mp3+";   
}

function makumiElfuDouble($number)
{
    
    $announce = "";
    $maelfu = getDigitAtMaelfu($number);
    $makumiElfu = getDigitAtMakumiElfu($number);
    
    switch($makumiElfu)
    {             
        case 1 : $announce = ($maelfu > 0) ?  "elfu_kumi" . " na " . mamoja($maelfu) : "elfu_kumi";
        break;
        case 2 : $announce = $maelfu > 0 ?  "elfu_ishirini" . " na " . mamoja($maelfu) : "elfu_ishirini";
        break;
        case 3 : $announce = $maelfu > 0 ?  "elfu_thelathini" . " na " . mamoja($maelfu) : "elfu_thelathini";
        break;
        case 4 : $announce = $maelfu > 0 ?  "elfu_arobaini" . " na " . mamoja($maelfu) : "elfu_arobaini";
        break;
        case 5 : $announce = $maelfu > 0 ?  "elfu_hamsini" . " na " . mamoja($maelfu) : "elfu_hamsini";
        break;
        case 6 : $announce = $maelfu > 0 ?  "elfu_sitini" . " na " . mamoja($maelfu) : "elfu_sitini";
        break;       
        case 7 : $announce = $maelfu > 0 ?  "elfu_sabini" . " na " . mamoja($maelfu) : "elfu_sabini";
        break;
        case 8 : $announce = $maelfu > 0 ?  "elfu_themanini" . " na " . mamoja($maelfu) : "elfu_themanini";
        break;
        case 9 : $announce = $maelfu > 0 ?  "elfu_tisini" . " na " . mamoja($maelfu) : "elfu_tisini";
        break;       
}
    return strtoupper($announce) . ".mp3+";  

}

function makumiElfu($number)
{
    printLine("number is " . $number);
    $announce = "";
    $makumiElfu = getDigitAtMakumiElfu($number);
    switch($makumiElfu)
    {             

        case 1 : $announce = (getDigitAtMaelfu($number) > 0) ?  "elfu_kumi" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_kumi";
        break;
        case 2 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_ishirini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_ishirini";
        break;
        case 3 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_thelathini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_thelathini";
        break;
        case 4 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_arobaini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_arobaini";
        break;
        case 5 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_hamsini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_hamsini";
        break;
        case 6 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_sitini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_sitini";
        break;       
        case 7 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_sabini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_sabini";
        break;
        case 8 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_themanini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_themanini";
        break;
        case 9 : $announce = getDigitAtMaelfu($number) > 0 ?  "elfu_tisini" . " na " . mamoja(getDigitAtMaelfu($number)) : "elfu_tisini";
        break;       
         

}
    return strtoupper($announce) . ".mp3+";  

}

function makumiElfuReverse($number)
{
    $announce = "";

    $maelfu = getDigitAtMaelfu($number);
    $makumiElfu = getDigitAtMakumiElfu($number);

    switch($makumiElfu)
    {
        case 1 : $announce = ($maelfu > 0) ?  "kumi " . " na " . mamoja($maelfu) . " elfu" : "kumi elfu";
        break;
        case 2 : $announce = $maelfu > 0 ?  "ishirini" . " na " . mamoja($maelfu) . " elfu" : "ishirini elfu";
        break;
        case 3 : $announce = $maelfu > 0 ?  "thelathini" . " na " . mamoja($maelfu) . " elfu" : "thelathini elfu";
        break;
        case 4 : $announce = $maelfu > 0 ?  "arobaini" . " na " . mamoja($maelfu) . " elfu" : "arobaini elfu";
        break;
        case 5 : $announce = $maelfu > 0 ?  "hamsini" . " na " . mamoja($maelfu) . " elfu" : "hamsini elfu";
        break;
        case 6 : $announce = $maelfu > 0 ?  "sitini" . " na " . mamoja($maelfu) . " elfu" : "sitini elfu";
        break;       
        case 7 : $announce = $maelfu > 0 ?  "sabini" . " na " . mamoja($maelfu) . " elfu" : "sabini elfu";
        break;
        case 8 : $announce = $maelfu > 0 ?  "themanini" . " na " . mamoja($maelfu) . " elfu" : "themanini elfu";
        break;
        case 9 : $announce = $maelfu > 0 ?  "tisini" . " na " . mamoja($maelfu) . " elfu" : "tisini elfu";
        break;       
         

}

return strtoupper($announce) . ".mp3+";   
}

function maelfu($number)
{
    $announce = "";
    switch($number)
    {
        case 1 : $announce = "elfu_moja";
        break;
        case 2 : $announce = "elfu_mbili";
        break;
        case 3 : $announce = "elfu_tatu";
        break;
        case 4 : $announce = "elfu_nne";
        break;
        case 5 : $announce = "elfu_tano";
        break;
        case 6 : $announce = "elfu_sita";
        break;       
        case 7 : $announce = "elfu_saba";
        break;
        case 8 : $announce = "elfu_nane";
        break;
        case 9 : $announce = "elfu_tisa";
        break;                                         

}

return strtoupper($announce) . ".mp3+";  
}

function testmamoja()
{
    echo "one thousand"; newLine();
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
    return intval(substr($numberString, strlen($number)-2,1));
}

function getDigitAtMamoja($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number)-1,1));
}

function getDigitAtMamia($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number)-3,1)); 
}

function getDigitAtMaelfu($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number)-4,1));
}

function getDigitAtMakumiElfu($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number)-5,1)); 
}

function getDigitAtMalaki($number)
{
    $numberString = strval($number);
    return intval(substr($numberString, strlen($number)-6,1));
}



function announce($number)
{
    echo $number;
    newLine();
}

function announceInline($number)
{
    echo $number;
    echo " ";
}



?>


