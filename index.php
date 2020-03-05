<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src='https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js'></script>

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
    CURLOPT_URL => 'http://localhost:44444/arrivals/webBoard',
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
<script>
  var socket = io.connect({'path': ':44444/'});

  socket.on('connect', function(data) {
    	socket.emit('join', 'Hello World from client');
    	console.log('connected to socket');
  }); 
 
  socket.on('new_names', function(data) {
	console.log(data);
	var board_line = 1;
	data.forEach(function(item) {
	  document.getElementById('board-date-'+board_line).innerHTML = item["date"];
	  document.getElementById('board-name-'+board_line).innerHTML = item["name"];
	  board_line += 1;
	});
	
  });


</script>
</html>
