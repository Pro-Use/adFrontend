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
$doc = domxml_new_doc("1.0");
$node = $doc->create_element("markers");
$parnode = $doc->append_child($node);

header("Content-type: text/xml");

foreach ($arr_geo as $row) {
  $node = $doc->create_element("marker");
  $newnode = $parnode->append_child($node);

  $newnode->set_attribute("id", $row['ID']);
  $newnode->set_attribute("name", $row['name']);
  $newnode->set_attribute("date", $row['date']);
  $latlng = explode(',',  $row['geo']);
  $newnode->set_attribute("lat", $latlng[0]);
  $newnode->set_attribute("lng", $latlng[1]);
  $newnode->set_attribute("type", $row['arrival']);
}

$xmlfile = $doc->dump_mem();
echo $xmlfile;

