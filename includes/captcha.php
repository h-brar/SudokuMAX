<?php
$response = $_POST["g-recaptcha-response"];

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        'secret' => '6LeuVH0UAAAAAMoEBcNBHtAAvzql4W0N86_HD0vx',
        'response' => $response
    ],
    CURLOPT_RETURNTRANSFER => true
]);

$output = curl_exec($ch);
curl_close($ch);

$captcha_success=json_decode($output);