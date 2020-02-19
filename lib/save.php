<?php
require_once "autoload.php";

$tablename = $_POST["tablename"];
$formname = $_POST["formname"];
$afterinsert = $_POST["afterinsert"];
$pkey = $_POST["pkey"];

if ( $_POST["savebutton"] == "Save" )
{
    $sql_body = array();

    //key-value pairs samenstellen
    foreach( $_POST as $field => $value )
    {
        if ( in_array($field, array("tablename", "formname", "afterinsert", "pkey", "savebutton", $pkey))) continue;

        $sql_body[]  = " $field = '" . htmlentities($value, ENT_QUOTES) . "' " ;
    }

    if ( $_POST[$pkey] > 0 ) //update
    {
        $sql = "UPDATE $tablename SET " . implode( ", " , $sql_body ) . " WHERE $pkey=" . $_POST[$pkey];
        if ( $Container->getPDOtoExecute($sql) ) $new_url = $_application_folder  . "/$formname.php?id=" . $_POST[$pkey] . "&updateOK=true" ;
    }
    else //insert
    {
        $sql = "INSERT INTO $tablename SET " . implode( ", " , $sql_body );
        if ( $Container->getPDOtoExecute($sql) ) $new_url = $_application_folder . "/$afterinsert?insertOK=true" ;
    }

    //print $sql;
    header("Location: $new_url");
}
?>