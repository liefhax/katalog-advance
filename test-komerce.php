<?php
$apiKey = "Ck2VcXcL869fbc62ccblbaa0Al34Ud2B";
$url = "https://rajaongkir.komerce.id/api/v1/destination/province";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $apiKey",
        "Accept: application/json"
    ],
    CURLOPT_SSL_VERIFYPEER => false,  // Tambahkan ini
    CURLOPT_SSL_VERIFYHOST => false   // Dan ini
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo "❌ CURL Error: " . curl_error($curl);
    exit;
}

curl_close($curl);

echo "<pre>$response</pre>";
