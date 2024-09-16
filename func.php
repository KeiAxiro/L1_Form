<?php

$warna = [
    [
        'color' => '#FFFFFF',  // Putih
        'bgcolor' => '#000000' // Hitam
    ],
    [
        'color' => '#000000',  // Hitam
        'bgcolor' => '#FFFF00' // Kuning
    ],
    [
        'color' => '#000000',  // Hitam
        'bgcolor' => '#00FF00' // Hijau terang
    ],
    [
        'color' => '#FFFFFF',  // Putih
        'bgcolor' => '#0000FF' // Biru
    ],
    [
        'color' => '#FFFFFF',  // Putih
        'bgcolor' => '#FF00FF' // Magenta
    ],
    [
        'color' => '#000000',  // Hitam
        'bgcolor' => '#00FFFF' // Cyan
    ],
    [
        'color' => '#FFFFFF',  // Putih
        'bgcolor' => '#FF6600' // Oranye terang
    ],
    [
        'color' => '#000000',  // Hitam
        'bgcolor' => '#CCCCCC' // Abu-abu terang
    ],
    [
        'color' => '#FFFFFF',  // Putih
        'bgcolor' => '#800080' // Ungu
    ]
];


function intArrayToStr($input)
{
    $dataStr = null;
    for ($i = 0; $i < sizeof($input); $i++) {
        if ($i < sizeof($input) - 1) {
            $dataStr .= "$input[$i],";
        } else {
            $dataStr .= "$input[$i]";
        }
    }
    return $dataStr;
}

function validateAndConvertToIntegerArray($input)
{

    $input = trim($input);

    if (empty($input)) {
        return "Input tidak boleh kosong.";
    }

    if (!preg_match('/^\d+(,\d+)*$/', $input)) {
        return "\color{Red}\\text{Input tidak valid. Hanya angka yang dipisahkan dengan koma yang diizinkan.}";
    }

    $stringArray = explode(',', $input);

    $integerArray = array_map('intval', $stringArray);

    return $integerArray;
}

function findModusTunggal($data)
{

    $f = array_count_values($data);
    $maxF = max($f);

    $modus = array_keys($f, $maxF);

    return $modus;
}

function hitungModus($data)
{

    $modus_i = [];
    $maxF = 0;


    for ($i = 0; $i < count($data); $i++) {
        $frekuensi = $data[$i]['ft'];

        if ($frekuensi > $maxF) {
            $maxF = $frekuensi;

            $modus_i = [$data[$i]['ft']];
        } elseif ($frekuensi == $maxF) {
            $modus_i[] = $data[$i]['ft'];
        }
    }

    return $modus_i;
}
