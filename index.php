<?php 
echo '<!DOCTYPE html>
<html>
<head>
	<title>About</title>
</head>
<body>
    <ul>
        <li><a  href="index.php">Home</a></a></li>
        <li><a  href="about.php">About</a></a></li>
    </ul>';

include_once('Database.php');
include_once('Visitorcounter.php');

$counter = new Visitorcounter();
$counter->run_counter('visitors');
echo $counter->get_ip();


echo "<br>";
echo "<br>";
echo 'Total visitors: '.$counter->visit_total(); //display total visit of all pages
echo "<br>";
echo 'Total visitors of this page: '.$counter->visit_total($counter->get_pageUrl()); //display total visit of this page
echo "<br>";
echo 'Total visitors of this page this year: '.$counter->visit_thisyear($counter->get_pageUrl()); //display this year visitor of this page
echo "<br>";
echo 'Total visitors of this page this month: '.$counter->visit_thismonth($counter->get_pageUrl()); //display this month visitor visit of this page
echo "<br>";
echo 'Total visitors of this page this week: '.$counter->visit_thisweek($counter->get_pageUrl()); //display this week visitor visit of this page
echo "<br>";
echo 'Total visitors of this page today: '.$counter->visit_today($counter->get_pageUrl()); //display today visitor visit of this page
echo "<br>";
?></body></html>
