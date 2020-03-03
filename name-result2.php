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
    $context = Context::builder()
        ->place('US')
        ->priority(Priority::REALTIME)
        ->build();
  
    $serviceFactory = new ServiceFactory('e613e25a6980a345cd9b973e10dd6b42-user1', $context);
    
    $ping = $serviceFactory->systemServices()->ping();
    $pong = $ping->ping();
    
    use org\nameapi\ontology\input\entities\person\NaturalInputPerson;
    use org\nameapi\ontology\input\entities\person\name\InputPersonName;

    $inputPerson = NaturalInputPerson::builder()
            ->name(InputPersonName::westernBuilder()
                    ->fullname("John F. Kennedy")
                    ->build())
            ->build();
    
    $personNameParser = $serviceFactory->parserServices()->personNameParser();
    $parseResult = $personNameParser->parse($inputPerson);
    $json_string = json_encode($data, $parseResult);
    echo($json_string);

if ( isset( $_POST['name'] )) {
        $name = $_POST['name'];
 
    }
    ?>
    <br>
    <h1><a href="/name-check2.html">Return ></a></h1>
    <body>

    </body>
</html>
