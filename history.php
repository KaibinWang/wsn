<?php 
session_start();

require_once('OFC/OFC_Chart.php');
require_once 'db_info.php';
require 'getHistoryData.php';
$id = $_SESSION["temp"];
$SplitTime=30;
$SplitNum=48;
$DataType=$_GET["datatype"];
switch($DataType){
	case "hum":$DataType=2;break;
	case "tem":$DataType=1;break;
	case "lig":$DataType=3;break;
	case "vol":$DataType=5;break;
}
$DateType=$_GET["datetype"];
switch($DateType){
	case "day":	$SplitTime=30;$SplitNum=48;break;
	case "week":$SplitTime=24*60;$SplitNum=7;break;
	case "month":$SplitTime=24*60;$SplitNum=30;break;
}
date_default_timezone_set('Etc/GMT-8');

$time = time();//当前时间
$tim = Array();//X轴数组
$query1 = "SELECT max(DataValue) FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".($time-$SplitNum*$SplitTime*60)."&&AddTime<".$time;
$result1 = mysqli_query(get_connect(),$query1);
if(!$result1)die("unable to connect");
$row1 = mysqli_fetch_row($result1);

$DataMin=0;
$DataMax=$row1[0];
switch($DataType){
	case 2:$title = "湿度变化曲线：单位/%";$unit = "%";$DataMax=100;break;
	case 1:$title = "温度变化曲线：单位/℃";$unit = "℃";$DataMax=50;break;
	case 3:$title = "光照变化曲线：单位/cd";$unit = "cd";break;
	case 5:$title = "电压变化曲线：单位/V";$unit = "V";$DataMax=4;break;
}
switch($DateType){
	case "day":	
	for($k=0;$k<=$SplitNum;$k++){
		// if($k%4==0){
			$tim[$k] = date('H:i',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
		// }
		// else{
			// $tim[$k] = "";	
		// }	
	}
	break;
	case "week":
	for($k=0;$k<$SplitNum;$k++){
		$tim[$k] = date('m-d',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
	}
	break;
	case "month":
	for($k=0;$k<=$SplitNum;$k++){
		// if($k%2==0){
			$tim[$k] = date('m-d',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
		// }
		// else{
			// $tim[$k] = "";	
		// }	
	}
	break;
}
$maxdata=getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
$mindata= getMinData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
$response = Array();
$response['title'] = $title;
$response['unit'] = $unit;
$response['time'] = $tim;
$response['maxdata'] = $maxdata;
$response['mindata'] = $mindata;
// echo json_encode($tim);
echo json_encode($response);
 ?>