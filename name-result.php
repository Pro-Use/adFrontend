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
    
    $CODES = array("NS01"=>"Name parsing was successful.",
                    "NS02"=>"An error was detected. Please check for a name error code.",
                    "NS03"=>"The spelling in the first name field was corrected.",
                    "NS04"=>"The spelling in the second first name field was corrected.",
                    "NS05"=>"FirstName1 was found in our census table of names. Very likely to be a real first name.",
                    "NS06"=>"LastName1 was found in our census table of names. Very likely to be a real last name.",
                    "NS07"=>"FirstName2 was found in our census table of names. Very likely to be a real first name.",
                    "NS08"=>"LastName2 was found in our census table of names. Very likely to be a real last name.",
                    "NS99"=>"The company name was standardized.",
                    "NE01"=>"Two names were detected but the FullName string was not in a recognized format.",
                    "NE02"=>"Multiple first names were detected and could not be accurately genderized.",
                    "NE03"=>"A vulgarity was detected in the name.",
                    "NE04"=>"The name contained words found on the list of nuisance names, such as Mickey Mouse.",
                    "NE05"=>"The name contained words normally found in a company name.",
                    "NE06"=>"The name contained a non-alphabetic character.",
                    "NE08"=>"Unicode characters detected on input. We do not support Unicode at this time; the input is returned as-is.",
                    "NE99"=>"Company name standardization was attempted, but did not produce a different result.",
            );

    if ( isset( $_POST['name'] )) {
        $name = $_POST['name'];
        $q_name = str_replace(" ", "%20", $name);
        $URL = "https://globalname.melissadata.net/V3/WEB/GlobalName/doGlobalName?";
        $query = "t=1&id=" . $MELISSA_KEY . "&opt=''&comp=''&full=" . $name . "&format=json";   
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL,
          $URL . $query
        );
        $result = json_decode(curl_exec($curl), true);
        $results = $result["Records"][0]["Results"];
        $codes = explode(",", $results);
        echo("Name: ".$name."<br><br><h1>Results</h1>");
        foreach ($codes as $code) {
            if (substr($code, 0,2) == "NS") {
                echo("<div>SUCCESS: " . $CODES[$code]);
            } elseif (substr($code, 0,2) == "NE") {
                echo("<div>ERROR: " . $CODES[$code]);
            }
        }
    }
    ?>
    <body>

    </body>
</html>
