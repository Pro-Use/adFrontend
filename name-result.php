<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $MELISSA_KEY = apache_getenv("MELISSA_KEY");

    if ( isset( $_POST['name'] )) {
        $name = $_POST['name'];
        $URL = "https://globalname.melissadata.net/V3/WEB/GlobalName/doGlobalName?";
        $query = "t=1&id=" . $MELISSA_KEY . "&opt=''&comp=''&full=" . $name . "&format=json";   
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL,
          $URL . $name
        );
        $result = json_decode(curl_exec($curl));
        echo json_encode($result);
    }
    ?>
    <body>

    </body>
</html>
