<?php

/**
 * Menghitung modus dari data frekuensi
 *
 * @param array $data Array 2D asosiatif dengan 'nt' dan 'ft'
 * @return array Nilai modus yang ditemukan
 */
function hitungModus($data)
{
    $modus_i = [];
    $maxF = 0;

    // Loop untuk menemukan frekuensi maksimum dan nilai modus
    for ($i = 0; $i < count($data); $i++) {
        $frekuensi = $data[$i]['ft'];
        $nilai = $data[$i]['nt']; // Mengambil nilai dari data

        // Update frekuensi maksimum
        if ($frekuensi > $maxF) {
            $maxF = $frekuensi;
            // Reset modus_i karena kita menemukan frekuensi yang lebih tinggi
            $modus_i = [$nilai];
        } elseif ($frekuensi == $maxF) {
            // Tambahkan nilai ke array modus jika frekuensi sama dengan maksimum
            $modus_i[] = $nilai;
        }
    }

    return $modus_i;
}

// Contoh penggunaan fungsi
$data = [
    ['nt' => 1, 'ft' => 2],
    ['nt' => 2, 'ft' => 4],
    ['nt' => 3, 'ft' => 5],
    ['nt' => 4, 'ft' => 5] // Modus ganda, frekuensi 5
];

$modus = hitungModus($data);

// Tampilkan hasil
echo "Modus dari data tabel adalah: " . implode(', ', $modus);
