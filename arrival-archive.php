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


$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost:44444/arrivals',
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

$board_line = 1;
foreach ($results as $result) {
    echo ('<div id="board-line-' .$board_line. '">
        <span id="board-date-' .$board_line. '">' .$result["date"]. '</span>
        <span id="board-name-' .$board_line. '">' . $result["name"]. '</span>
    </div>');
    $board_line += 1;
} 

?>
</body>
</html>
