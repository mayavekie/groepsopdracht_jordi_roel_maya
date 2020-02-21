<?php
require_once "autoload.php";

if ( isset($_POST["submit"]) AND $_POST["submit"] == "Opladen" )
{
    //overloop alle bestanden in $_FILES
    foreach ( $_FILES as $f )
    {
        $upfile = array();
        $upfile["name"]             = basename($f["name"]);
        $upfile["tmp_name"]         = $f["tmp_name"];
        $upfile["target_path_name"] = $US->getTargetDir() . $upfile["name"];
        $upfile["extension"]        = pathinfo($upfile["name"], PATHINFO_EXTENSION);
        $upfile["getimagesize"]     = getimagesize($upfile["tmp_name"]);
        $upfile["size"]             = $f["size"];

        $result = $US->CheckUploadedFile( $upfile );
        $US->ResponseToUpload($result, $upfile);
    }

    header("Location: $_application_folder/file_upload.php");
}


