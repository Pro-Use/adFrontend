<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'oauth.php';
$token = getToken();

$action = filter_input(INPUT_POST, "update");

if ($action == "accept"){

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost:44444/arrivals/'.filter_input(INPUT_POST, "ID"),
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "authorization: Bearer " . $token),
    ]);
    $results = json_decode(curl_exec($curl), true);
    curl_close($curl);

    echo("ID:" . $results['id'] . " Accepted");
    
} elseif ($action == "delete") {
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://localhost:44444/arrivals/'.filter_input(INPUT_POST, "ID"),
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => array(
          "authorization: Bearer " . $token),
    ]);
    $results = json_decode(curl_exec($curl), true);
    curl_close($curl);

    echo("ID:" . $results . " Accepted");
}