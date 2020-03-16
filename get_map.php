<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'oauth.php';
$token = getToken();


$curl = curl_init();
curl_setopt_array($curl, [
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
$arr_geo = json_decode(curl_exec($curl), true);
curl_close($curl);

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

header("Content-type: text/xml");

foreach ($arr_geo as $row) {
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);

  $newnode->setAttribute("id", $row['ID']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("date", $row['date']);
  $latlng = explode(',',  $row['geo']);
  $newnode->setAttribute("lat", $latlng[0]);
  $newnode->setAttribute("lng", $latlng[1]);
  $newnode->setAttribute("type", $row['arrival']);
}

echo $dom->saveXML();

