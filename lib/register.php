<?php
$register_form = true;
require_once "autoload.php";

$formname = $_POST["formname"];
$tablename = $_POST["tablename"];
$pkey = $_POST["pkey"];

if ( $formname == "registration_form" AND $_POST['registerbutton'] == "Register" )
{
    $container = new Container($configuration);
    $userLoader = $container->getUserLoader();
    $userLoader->ValidatePostedUserData();
    $userLoader->RegisterUser();
}
?>