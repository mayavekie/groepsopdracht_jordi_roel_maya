<?php
require_once "lib/autoload.php";

$container = new Container($configuration);
$download = $container->getDownload();
$printCsvHeader= $download->PrintCSVHeader( "taken" . date("Y_m_d_His"));
$getTaskData = $download->getTaskData();