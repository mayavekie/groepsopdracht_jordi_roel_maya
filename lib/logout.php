<?php
require_once "autoload.php";

//session_start();
//$userLoader = new UserLoader($this->pdo);
//$userLoader->LogLogoutUser();
$container = new Container($configuration);
$userLoader = $container->getUserLoader();
$userLoader->LogLogoutUser();

session_destroy();
unset($_SESSION);

session_start();
session_regenerate_id();
$MS->AddMessage( "U bent afgemeld!" );
header("Location: " . $_application_folder . "/login.php");
?>

/*$container = new Container($configuration);
$cityHandler = $container->getCityHandler();
$cityHandler->LoadCityTemplate("steden");
*/