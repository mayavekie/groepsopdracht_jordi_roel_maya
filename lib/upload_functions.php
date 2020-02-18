<?php
////
$target_dir = "../img/";                                                          //de map waar de afbeelding uiteindelijk moet komen; relatief pad tov huidig script
$max_size = 5000000;                                                           //maximum grootte in bytes
$allowed_extensions = [ "jpeg", "jpg", "png", "gif" ];       //toegelaten bestandsextensies

if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" ) //als het juiste form gesubmit werd
{
    //overloop alle bestanden in $_FILES
    foreach ( $_FILES as $f )
    {
        $upfile = array();
        $upfile["name"]                            = basename($f["name"]);
        $upfile["tmp_name"]                    = $f["tmp_name"];
        $upfile["target_path_name"]       = $target_dir . $upfile["name"]; //samenstellen definitieve bestandsnaam (+pad)    //basename
        $upfile["extension"]                      = pathinfo($upfile["name"], PATHINFO_EXTENSION);
        $upfile["getimagesize"]                = getimagesize($upfile["tmp_name"]);                 //getimagesize geeft false als het bestand geen afbeelding is
        $upfile["size"]                                = $f["size"];

        $result = CheckUploadedFile( $upfile, $check_real_image = true, $check_if_exists = false, $check_max_size = true, $check_allowed_extensions = true );

        if ( !$result ) echo "Sorry, your file was not uploaded.<br>";
        else
        {
            //bestand verplaatsen naar definitieve locatie + naam
            if ( move_uploaded_file( $upfile["tmp_name"], $upfile["target_path_name"] ))
            {
                echo "The file " . $upfile["name"] . " has been uploaded as " . $upfile["target_path_name"] . "<br>";
            }
            else
            {
                echo "Sorry, there was an unexpected error uploading file " . $upfile["name"] . "<br>";
            }
        }
    }
}

function CheckUploadedFile( $upfile, $check_real_image = true, $check_if_exists = true, $check_max_size = true, $check_allowed_extensions = true )
{
    global $allowed_extensions, $max_size;

    $returnvalue = true;

    // Check if image file is a actual image or fake image
    if ( $check_real_image AND $upfile["getimagesize"] === false )
    {
        echo "File " . $upfile["name"] . " is not an image.<br>"; $returnvalue = false;
    }

    // Check if file already exists
    if ( $check_if_exists AND file_exists($upfile["target_path_name"]))
    {
        echo "File  " . $upfile["name"] . " already exists.<br>"; $returnvalue = false;
    }

    // Check file size
    if ( $check_max_size AND $upfile["size"] > $max_size )
    {
        echo "File  " . $upfile["name"] . "  is too large.<br>"; $returnvalue = false;
    }

    // Allow only certain file formats
    if ( $check_allowed_extensions )
    {
        if ( ! in_array( $upfile["extension"], $allowed_extensions) )
        {
            echo "Wrong extension. Only " . implode(", ", $allowed_extensions) . " files are allowed.<br>";
            $returnvalue = false;
        }
    }
    return $returnvalue;
}
?>