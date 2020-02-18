<?php
//de huidige systeemdatumtijd
$now = time();
print "De huidige timestamp is $now<br>";

//een timestamp maken voor een opgegeven datumtijd
//H, i, s, m, d, Y
$now = mktime(14,30,0,3,21,2019);
var_dump($now);

//de huidige datum
$strdate = date("l d/m/Y H:i:s", $now);
print "De huidige datum is $strdate<br>";

//de huidige datum
$strdate = date("Y-m-d", $now);
print "De huidige datum is ook $strdate<br>";

//de actuele tijd
$strtime = date("H:i:s", $now);
print "De huidige tijd is $strtime<br>";

//een array maken met alle mogelijke info over de huidige systeemdatumtijd
/*
$mydate = getdate($now);
var_dump($mydate);
*/

//twee weken later
$ts = mktime(14,30,0,3,21+14,2019);
$strdate = date("l d/m/Y H:i:s", $ts);
print "Twee weken later:<br>";
var_dump($strdate);
print "<br>";

//twee weken later
$ts = mktime(14,30,0,6,0,2019);
$strdate = date("l d/m/Y H:i:s", $ts);
print "Laatste dag voorgaande maand:<br>";
var_dump($strdate);
print "<br>";

//morgen?
$morgen = strtotime("+1 day");
$strdate = date("l d/m/Y H:i:s", $morgen);
print "Morgen: $strdate<br>";

//huidige datumtijd
$d = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
print $d->format('Y-m-d H:i:s') . "<br>";

//3 maanden verder
$d->add( new DateInterval('P3M2DT3H30M')); //PYMDTHMS
print $d->format('Y-m-d H:i:s') . "<br>";

//1 dag terug
$d->sub( new DateInterval('P1D'));
print $d->format('Y-m-d H:i:s') . "<br>";

//laatste dag vd maand
$d->modify('last day of this month');
echo $d->format('Y-m-d H:i:s') . "<br>";
