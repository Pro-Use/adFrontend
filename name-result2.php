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
    $context = Context::builder()
        ->place('US')
//        ->priority(Priority::REALTIME)
        ->build();
  
    $serviceFactory = new ServiceFactory('e613e25a6980a345cd9b973e10dd6b42-user1', $context);
    
    $ping = $serviceFactory->systemServices()->ping();
    $pong = $ping->ping();

if ( isset( $_POST['name'] )) {
        $name = $_POST['name'];
 
    }
    ?>
    <br>
    <h1><a href="/name-check2.html">Return ></a></h1>
    <body>

    </body>
</html>
