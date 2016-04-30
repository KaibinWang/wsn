<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2015-10-06 20:18:57
 * @version $Id$
 */

require_once 'db_info.php';
require 'getHistoryData.php';
echo "before--->".date('H-i-s',time())."<br>";
date_default_timezone_set('Etc/GMT-8');
$time=time();
$id = 181;
$DataType=1;
$DataMax=100;
$DataMin=0;
$year = 2016;
$month = 2;
$day = 2;
$data = getDataByMonth($year,$month,$id,$DataType,$DataMax,$DataMin);
foreach ($data as $key => $value) {
	# code...
	print($value."<br>");
}

echo "<br>after--->".date('H-i-s',time());
?>