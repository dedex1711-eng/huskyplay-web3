<?php
// 🔥 CORS LIBERADO
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 🔒 valida URL
if (!isset($_GET['url'])) {
    http_response_code(400);
    exit("URL não fornecida");
}

$url = $_GET['url'];

// 🔥 TIMEOUT
$timeout = 15;

// 🔥 USER AGENTS (rotação)
$userAgents = [
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
    "Mozilla/5.0 (Linux; Android 10)",
    "Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)"
];

$ua = $userAgents[array_rand($userAgents)];

// 🔥 HEADERS SIMULANDO PLAYER REAL
$headers = [
    "Accept: */*",
    "Connection: keep-alive",
];

// 🔁 CURL
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => $timeout,

    // 🔥 IGNORA SSL (ESSENCIAL IPTV)
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,

    CURLOPT_USERAGENT => $ua,
    CURLOPT_HTTPHEADER => $headers,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

// 🔁 ERRO → tenta novamente (fallback simples)
if ($response === false || $httpCode >= 400) {
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgents[array_rand($userAgents)]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
}

curl_close($ch);

// 🔥 retorna tipo correto
if ($contentType) {
    header("Content-Type: $contentType");
}

http_response_code($httpCode);
echo $response;
