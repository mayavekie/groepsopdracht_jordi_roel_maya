<?php
require_once "autoload.php";

if ( $_POST["savebutton"] == "Save" )
{
    $cityHandler = $Container->getCityHandler();
    $cityHandler->LoadIntoCity();
    $cityHandler->LoopThroughFieldAndValue();
    $cityHandler->SaveCityToDatabase();
    $new_url = $cityHandler->GetNewUrlFromCity();

    header("Location: " . $cityHandler->GetNewUrlFromCity());
}
