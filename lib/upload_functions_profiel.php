<?php
require_once "autoload.php";

if ( isset($_POST["submit"]) == "Opladen" )
{
    //$target_dir = de map waar de afbeeldingen uiteindelijk moet komen
    $target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
    $max_size = 5000000;                                                           //maximum grootte in bytes

    $images = array();

    //pasfoto, eid_voorzijde en eid_achterzijde overlopen
    foreach ( $_FILES as $inputname => $fileobject )   //overloop alle bestanden in $_FILES
    {
        $tmp_name= $fileobject["tmp_name"];
        $originele_naam = $fileobject["name"];
        $size = $fileobject["size"];
        $extensie = pathinfo($originele_naam, PATHINFO_EXTENSION);

        $target = "";

        //CONTROLES
        $max_size = 20000000; //maximum grootte in bytes
        $allowed_extensions = [ "jpeg", "jpg", "png", "gif" ]; //toegelaten bestandsextensies
        $cancel = false;

        //grootte
        if ( $size > $max_size )
        {
            print "Bestand " . $originele_naam . " is te groot (" . $size . " bytes). Maximum $max_size bytes!<br>";
            $cancel = true;
        }

        //toegelaten extensies
        if ( ! in_array( pathinfo($originele_naam, PATHINFO_EXTENSION), $allowed_extensions ))
        {
            print "Bestand " . $originele_naam . ": verkeerde bestandsextensie!<br>";
            $cancel = true;
        }

        //is het bestand wel echt een afbeelding?
        if ( getimagesize($tmp_name) === false)
        {
            print "Bestand " . $originele_naam . " is niet echt een afbeelding!<br>";
            $cancel = true;
        }

        //bestaat het bestand al?
        /* Deze controle is overbodig volgens de opgave
        if ( file_exists($target) )
        {
            print "Bestand " . $originele_naam . "bestaat al!<br>";
            $cancel = true;
        }
        */

        if ( ! $cancel )
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

            $target = $target_dir . $target;

            //bestand verplaatsen naar definitieve locatie
            print "Moving " . $inputname . " to " . $target . "<br>";

            if ( move_uploaded_file( $tmp_name, $target))
            {
                print "Bestand $originele_naam opgeladen<br>";
            }
            else print "Sorry, there was an unexpected error uploading file " . $originele_naam . "<br>";
        }
    }

    //de afbeeldingen opslaan in het gebruikersprofiel
    $sql = "update users SET " . implode("," , $images) . " where usr_id=" . $_SESSION['usr']->getId();
    ExecuteSQL($sql);

    //eventueel een redirect naar de profielpagina
    //header("Location: $_application_folder/profiel.php");

}
?>