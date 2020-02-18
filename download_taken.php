<?php
require_once "lib/autoload.php";

$download = new Download();
$printCsvHeader= $download->PrintCSVHeader( "taken" . date("Y_m_d_His"));
$getTaskData = $download->getTaskData();