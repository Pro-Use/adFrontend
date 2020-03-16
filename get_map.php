<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'oauth.php';
$token = getToken();


$arr_curl = curl_init();
curl_setopt_array($arr_curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost:44444/arrivals/map',
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "authorization: Bearer " . $token),
]);
$arr_geo = json_decode(curl_exec($arr_curl), true);
curl_close($arr_curl);

$dep_curl = curl_init();
curl_setopt_array($dep_curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost:44444/departures/map',
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "authorization: Bearer " . $token),
]);
$dep_geo = json_decode(curl_exec($dep_curl), true);
curl_close($dep_curl);

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

header("Content-type: text/xml");

foreach ($arr_geo as $arr_row) {
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name", $arr_row['name']);
  $newnode->setAttribute("date", $arr_row['date']);
  $latlng = explode(',',  $arr_row['geo']);
  $newnode->setAttribute("lat", $latlng[0]);
  $newnode->setAttribute("lng", $latlng[1]);
  $newnode->setAttribute("type", 'arrival');
}

foreach ($dep_geo as $dep_row) {
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name", $dep_row['name']);
  $newnode->setAttribute("date", $dep_row['date']);
  $latlng = explode(',',  $dep_row['geo']);
  $newnode->setAttribute("lat", $latlng[0]);
  $newnode->setAttribute("lng", $latlng[1]);
  $newnode->setAttribute("type", 'departure');
}

echo $dom->saveXML();
//var_dump($arr_geo);