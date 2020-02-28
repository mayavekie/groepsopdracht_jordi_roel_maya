<?php
require_once "autoload.php";

if ( isset($_POST["submit"]) == "Opladen" )
{
    $PS->ProcessUpload();

    //de afbeeldingen opslaan in het gebruikersprofiel
    $PS->SaveProfile();

    //eventueel een redirect naar de profielpagina
    header("Location: $_application_folder/profiel.php");

}
