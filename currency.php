<?php
function convertNumberToSwahili($num) {
    $belowTwenty = ['Sifuri', 'Moja', 'Mbili', 'Tatu', 'Nne', 'Tano', 'Sita', 'Saba', 'Nane', 'Tisa', 'Kumi',
        'Kumi na moja', 'Kumi na mbili', 'Kumi na tatu', 'Kumi na nne', 'Kumi na tano', 'Kumi na sita', 'Kumi na saba', 'Kumi na nane', 'Kumi na tisa'];
    $tens = ['', '', 'Ishirini', 'Thelathini', 'Arobaini', 'Hamsini', 'Sitini', 'Sabini', 'Themanini', 'Tisini'];
    $thousands = ['', 'Elfu', 'Milioni', 'Bilioni'];

    if ($num < 20) {
        return $belowTwenty[$num];
    } elseif ($num < 100) {
        return $tens[(int)($num / 10)] . ($num % 10 ? ' na ' . $belowTwenty[$num % 10] : '');
    } elseif ($num < 1000) {
        return $belowTwenty[(int)($num / 100)] . ' Mia' . ($num % 100 ? ' ' . convertNumberToSwahili($num % 100) : '');
    }
    
    $output = '';
    $index = 0;
    while ($num > 0) {
        $part = $num % 1000;
        if ($part > 0) {
            $output = $thousands[$index] . ' '. convertNumberToSwahili($part) . ' ' . ($output ? ' ' . $output : '');
        }
        $num = (int)($num / 1000);
        $index++;
    }
    
    return trim($output);
}

function convertCurrencyToSwahili($amount) {
    $shilingi = (int)$amount;
    $senti = round(($amount - $shilingi) * 100);
    
    $words = convertNumberToSwahili($shilingi);
    if ($senti > 0) {
        $words .= ' na ' . convertNumberToSwahili($senti) . ' Senti';
    }
    
    return $words;
}

// Mfano wa matumizi:
$amount = 1600;
echo convertCurrencyToSwahili($amount);
?>
