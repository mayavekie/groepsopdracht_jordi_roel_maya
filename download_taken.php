<?php
require_once "lib/autoload.php";

$download = $Container->getDownload();
$download->PrintCSVHeader( "taken" . date("Y_m_d_His"));
$download->getTaskData();