<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2016-04-29 16:57:31
 * @version $Id$
 */

require_once 'db_info.php';
require 'getHistoryData.php';
$id = $_GET["nodeid"];
$DataType=$_GET["datatype"];
$year = $_GET["year"];
$month = $_GET["month"];
$day = $_GET["day"];
$DataMin=0;
//转换数据类型
switch($DataType){
	case "hum":$DataType=2;break;
	case "tem":$DataType=1;break;
	case "lig":$DataType=3;break;
	case "vol":$DataType=5;break;
}
switch($DataType){
	case 2:$title = "湿度变化曲线：单位/%";$unit = "%";$DataMax=100;break;
	case 1:$title = "温度变化曲线：单位/℃";$unit = "℃";$DataMax=50;break;
	case 3:$title = "光照变化曲线：单位/cd";$unit = "cd";$DataMax=10000;break;
	case 5:$title = "电压变化曲线：单位/V";$unit = "V";$DataMax=4;break;
}
$data = getDataByDay($year,$month,$day,$id,$DataType,$DataMax,$DataMin);
$tim = array();
for($i = 0;$i<24;$i++){
	array_push($tim,$i.":00");
}
$response = array();
$response['title'] = $title;
$response['unit'] = $unit;
$response['time'] = $tim;
$response['data'] = $data;
echo json_encode($response);
?>