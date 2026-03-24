<?php
header("Access-Control-Allow-Origin: *");

$url = $_GET['url'] ?? '';

if (!$url) die("No URL");

// Inicia cURL
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTPHEADER => [
        "User-Agent: IPTVPlayer/1.0",
        "Referer: http://localhost/",
        "Accept: */*"
    ],
    CURLOPT_TIMEOUT => 15
]);

$data = curl_exec($ch);
$type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

if ($type) {
    header("Content-Type: $type");
}

curl_close($ch);

echo $data;