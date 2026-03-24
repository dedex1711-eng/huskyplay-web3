<?php

// 🔥 CORS COMPLETO (ESSENCIAL)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: *");

// 🔥 Responde preflight (IMPORTANTE)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verifica URL
if (!isset($_GET['url'])) {
    http_response_code(400);
    echo "URL não informada";
    exit;
}

$url = $_GET['url'];

// Validação básica
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo "URL inválida";
    exit;
}

// 🔥 cURL
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_HTTPHEADER => [
        "User-Agent: Mozilla/5.0",
        "Accept: */*",
        "Connection: keep-alive"
    ],
    CURLOPT_TIMEOUT => 15
]);

$response = curl_exec($ch);

// Se der erro
if (curl_errno($ch)) {
    http_response_code(500);
    echo "Erro: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Content-Type correto
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
if ($contentType) {
    header("Content-Type: " . $contentType);
}

curl_close($ch);

echo $response;
