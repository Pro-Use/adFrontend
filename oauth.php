<?php

function getToken() {
    $CLIENT_ID = apache_getenv("CLIENT_ID");
    $CLIENT_SECRET = apache_getenv("CLIENT_SECRET");
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://arr-dep.eu.auth0.com/oauth/token",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\"client_id\":\"".$CLIENT_ID."\",\"client_secret\":\"".$CLIENT_SECRET."\",\"audience\":\"arrivals-departures\",\"grant_type\":\"client_credentials\"}",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/json"
      ),
    ));

    $result = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
      return null;
    } else {
      $response = json_decode($result, true);
      $token = $response['access_token'];
      return $token;
    }
}



