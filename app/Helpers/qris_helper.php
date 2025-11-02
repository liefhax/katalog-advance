<?php
// app/Helpers/qris_helper.php

/**
 * Fungsi ini mengambil string QRIS statis dan nominal,
 * lalu meng-generate string payload QRIS dinamis.
 *
 * @param string $staticQris (String QRIS statis lengkap kamu)
 * @param int|string $amount (Jumlah nominal yang harus dibayar)
 * @return string (String payload QRIS dinamis baru)
 * @throws \Exception Jika string QRIS statis tidak valid
 */
function generate_dynamic_qris($staticQris, $amount)
{
    // 1. Validasi string dasar
    if (empty($staticQris) || strlen($staticQris) < 10) {
        throw new \Exception("String QRIS Statis kosong atau terlalu pendek.");
    }
    
    // 2. Hapus checksum lama (4 karakter terakhir)
    $qris = substr($staticQris, 0, -4);

    // 3. Ubah tipe QR dari 11 (Statis) ke 12 (Dinamis)
    $step1 = str_replace("010211", "010212", $qris);

    // 4. Pisahkan string di tag 58 (Country Code 'ID')
    // INI YANG KITA PERBAIKI
    $delimiter = "5802ID";
    $step2 = explode($delimiter, $step1);

    // 5. Cek apakah pemisahan berhasil
    if (count($step2) < 2) {
        // Jika gagal, lempar error yang jelas
        throw new \Exception("String QRIS Statis tidak valid. Kode '5802ID' tidak ditemukan. Pastikan string di .env sudah benar.");
    }

    // 6. Buat tag 54 (Transaction Amount)
    $qty = (string)$amount; // pastikan string
    $uang = "54" . sprintf("%02d", strlen($qty)) . $qty;

    // 7. Sisipkan tag 54 sebelum tag 58
    $uang .= $delimiter; // Pakai delimiter, jangan '5802ID' hardcode

    // 8. Gabungkan kembali stringnya
    // $step2[0] = bagian awal
    // $uang = tag 54 + tag 58
    // $step2[1] = bagian akhir
    $fix = trim($step2[0]) . $uang . trim($step2[1]);

    // 9. Hitung & tambahkan checksum CRC16 yang baru
    $fix .= convert_crc16_qris($fix);

    return $fix;
}

/**
 * Fungsi kalkulator Checksum CRC16-CCITT-FALSE
 */
function convert_crc16_qris($str)
{
    function charCodeAt($str, $i) {
        return ord(substr($str, $i, 1));
    }

    $crc = 0xFFFF;
    $strlen = strlen($str);
    for ($c = 0; $c < $strlen; $c++) {
        $crc ^= charCodeAt($str, $c) << 8;
        for ($i = 0; $i < 8; $i++) {
            if ($crc & 0x8000) {
                $crc = ($crc << 1) ^ 0x1021;
            } else {
                $crc = $crc << 1;
            }
        }
    }
    $hex = $crc & 0xFFFF;
    $hex = strtoupper(dechex($hex));
    
    // Pastikan 4 digit
    if (strlen($hex) == 1) $hex = "000" . $hex;
    if (strlen($hex) == 2) $hex = "00" . $hex;
    if (strlen($hex) == 3) $hex = "0" . $hex;
    
    return $hex;
}