<?php
require_once "autoload.php";

if ( isset($_POST["submit"]) == "Opladen" )
{
    $images = array();

    //pasfoto, eid_voorzijde en eid_achterzijde overlopen
    foreach ( $_FILES as $inputname => $fileobject )
    {
        $tmp_name = $fileobject["tmp_name"];
        $originele_naam = $fileobject["name"];
        $size = $fileobject["size"];
        $extensie = pathinfo($originele_naam, PATHINFO_EXTENSION);

        $target = "";

        $US->CheckUploadProfile();

        if (  $US->isReturnvalue() )
        {
            switch ( $inputname )
            {
                case "pasfoto":
                    $target = "pasfoto_" . $_SESSION['usr']->getId() . "." . $extensie;
                    $images[] = "usr_pasfoto='" . $target . "'";
                    break;
                case "eidvoor":
                    $target = "eidvoor_" . $_SESSION['usr']->getId() . "." . $extensie;
                    $images[] = "usr_vz_eid='" . $target . "'";
                    break;
                case "eidachter":
                    $target = "eidachter_" . $_SESSION['usr']->getId() . "." . $extensie;
                    $images[] = "usr_az_eid='" . $target . "'";
                    break;
            }

            $target = $US->getTargetDir() . $target;

            //bestand verplaatsen naar definitieve locatie
            $MS->AddMessage("Moving " . $inputname . " to " . $target);

            if ( move_uploaded_file( $tmp_name, $target))
            {
                $MS->AddMessage("Bestand $originele_naam opgeladen");
            }
            else $MS->AddMessage("Sorry, there was an unexpected error uploading file " . $originele_naam);
        }
    }

    //de afbeeldingen opslaan in het gebruikersprofiel
    $US->SaveProfile();

    //eventueel een redirect naar de profielpagina
    header("Location: $_application_folder/profiel.php");

}
?>