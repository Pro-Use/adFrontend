<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>.pac-logo:after{display:none;}</style>
</head>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$MAPS_API_KEY = apache_getenv("MELISSA_KEY");

include 'oauth.php';
if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) ) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $geo = $_POST['geo'];
    $email = $_POST['email'];
    $payload = json_encode($_POST);
    
    $token = getToken();
    
    // Prepare new cURL resource
    $ch = curl_init('http://localhost:44444/arrivals');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
     
    // Set HTTP Header for POST request 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload),
        "authorization: Bearer " . $token
        )
    );
     
    // Submit the POST request
    $result = curl_exec($ch);
     
    // Close cURL session handle
    curl_close($ch);
    echo($result);
}
?>

<body>
    <?php echo $MAPS_API_KEY; ?>
<form  method="post">
  Date:<br>
  <input type="text" name="date" value="1 Jan"><br>
  Last name:<br>
  <input type="text" name="name" value="Rob"><br>
  <br>
  <div id="locationField">
    <input id="autocomplete"
           placeholder="Enter your address"
           type="text"/>
  </div>
  Geo:<br>
  <input id="latlng" type="text" name="geo" value="" disabled="true"><br>
  Email:<br>
  <input type="text" name="email" value=""><br>
  <br>
  <input type="submit" value="Submit">
</form>
    
<script>
    var placeSearch, autocomplete;
    
    function initAutocomplete() {
      autocomplete = new google.maps.places.Autocomplete(
              document.getElementById('autocomplete'), {types: ['geocode']});
      autocomplete.setFields(['geometry']);
      autocomplete.addListener('place_changed', fillInAddress);
    }  

    
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        document.getElementById("latlng").value = lat + "," + lng;
        document.getElementById("latlng").disabled = false;
      }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $MAPS_API_KEY; ?>&libraries=places&callback=initAutocomplete"
   async defer></script>
</body>