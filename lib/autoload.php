<?php
//ini_set("error_reporting", E_ALL);
//ini_set("display_errors", 1);
//ini_set("display_startup_errors", 1);

$_application_folder = "/groepswerken/groepswerk_di";
$_root_folder = $_SERVER['DOCUMENT_ROOT'] . "$_application_folder";

//load Models
require_once $_root_folder . "/Model/City.php";
require_once $_root_folder . "/Model/User.php";
require_once $_root_folder . "/Model/Profile.php";

//load Services
require_once $_root_folder . "/Service/CityHandler.php";
require_once $_root_folder . "/Service/MessageService.php";
require_once $_root_folder . "/Service/Container.php";
require_once $_root_folder . "/Service/PageLoader.php";
require_once $_root_folder . "/Service/Download.php";
require_once $_root_folder . "/Service/UserLoader.php";
require_once $_root_folder . "/Service/UploadService.php";

session_start();
$_SESSION["head_printed"] = false;

require_once $_root_folder . "/lib/passwd.php";

$Container = new Container($configuration);
$US = $Container->getUploadService();
$PL = $Container->getPageLoader();
$MS = $Container->getMessageService();

//redirect naar NO ACCESS pagina als de gebruiker niet ingelogd is en niet naar
//de loginpagina gaat
if ( ! isset($_SESSION['usr']) AND ! $login_form AND ! $register_form AND ! $no_access)
{
    header("Location: " . $_application_folder . "/no_access.php");
}


