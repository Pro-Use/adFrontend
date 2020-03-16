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
    CURLOPT_URL => 'http://localhost:44444/arrivals/moderation',
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
foreach ($results as $result) { ?>
    <div id="board-line-<?php echo($board_line);?>">
        <span><?php echo($result["date"]);?></span>
        <span><?php echo($result["name"]);?></span>
        <form method="post" action="update.php">
            <input type="hidden" value="<?php echo($result["ID"]);?>"
            <input type="radio" id="accept" name="update" value="accept">
            <label for="accept">Accept</label>
            <input type="radio" id="delete" name="update" value="delete">
            <label for="delete">Delete</label>
            <input type="submit" value="Update">
        </form>
    </div>
   <?php $board_line += 1;
} 

?>
</body>
</html>
