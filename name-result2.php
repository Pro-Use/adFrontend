<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    require_once('org/nameapi/client/services/ServiceFactory.php');

    use org\nameapi\ontology\input\context\Context;
    use org\nameapi\ontology\input\context\Priority;
    use org\nameapi\client\services\ServiceFactory;
    use org\nameapi\ontology\input\entities\person\NaturalInputPerson;
    use org\nameapi\ontology\input\entities\person\name\InputPersonName;
    
    if ( isset( $_POST['name'] )) {
        $name = $_POST['name'];

        $context = Context::builder()
            ->place('US')
    //        ->priority(Priority::REALTIME)
            ->build();

        $serviceFactory = new ServiceFactory('e613e25a6980a345cd9b973e10dd6b42-user1', $context);

        $ping = $serviceFactory->systemServices()->ping();
        $pong = $ping->ping();


        $inputPerson = NaturalInputPerson::builder()
                ->name(InputPersonName::westernBuilder()
                        ->fullname($name)
                        ->build())
                ->build();

        $personNameParser = $serviceFactory->parserServices()->personNameParser();
        $parseResult = $personNameParser->parse($inputPerson);
        $bestMatch = $parseResult->getBestMatch();
        $likeliness = $bestMatch->getLikeliness() * 100;
        $confidence = $bestMatch->getConfidence() * 100;

        echo("<h1>Name: ".$name."</h1><br><br><h1>Results</h1>");
        echo("<div>Likeliness name is real: " . $likeliness . "% </div>");
        echo("<div>confidence: " . $confidence . "% </div>");
 
    }
    ?>
    <br>
    <h1><a href="/name-check2.html">Return ></a></h1>
    <body>

    </body>
</html>
