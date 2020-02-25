<?php
require_once "autoload.php";

if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" )
{
    $US->ProcesFiles();
    header("Location: $_application_folder/file_upload.php");
}


