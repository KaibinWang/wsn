<?php
session_start();

require_once('OFC/OFC_Chart.php');
require_once 'db_info.php';
require 'getHistoryData.php';
$id = $_SESSION["temp"];
$SplitTime=30;
$SplitNum=48;
$DataType=$_GET["datatype"];
$DateType=$_GET["datetype"];
switch($DateType){
	case "day":	$SplitTime=30;$SplitNum=48;break;
	case "week":$SplitTime=24*60;$SplitNum=7;break;
	case "month":$SplitTime=24*60;$SplitNum=30;break;
}
date_default_timezone_set('Etc/GMT-8');

$time = time();//当前时间

$query1 = "SELECT max(DataValue) FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".($time-$SplitNum*$SplitTime*60)."&&AddTime<".$time;
$result1 = mysqli_query(get_connect(),$query1);
$row1 = mysqli_fetch_row($result1);

$DataMin=0;
$DataMax=$row1[0];
switch($DataType){
	case 0:$title = new OFC_Elements_Title( '湿度变化曲线：单位/%' );$DataMax=100;break;
	case 1:$title = new OFC_Elements_Title( '温度变化曲线：单位/℃' );$DataMax=50;break;
	case 2:$title = new OFC_Elements_Title( '光照变化曲线：单位/cd' );break;
	case 3:$title = new OFC_Elements_Title( '电压变化曲线：单位/V' );$DataMax=4;break;
}

 
$line_dot = new OFC_Charts_Line();
$line_dot1 = new OFC_Charts_Line();
$chart = new OFC_Chart();

$chart->set_title( $title );

$data= getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
/*$data1= getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
for($i=0;$i<$SplitNum;$i++)
	$data[$i] = $data1[$i];*/
// $data1= getMinData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
$x=new OFC_Elements_Axis_X();
switch($DateType){
	case "day":	
	for($k=0;$k<=$SplitNum;$k++){
		if($k%4==0){
			$tim[$k] = date('H:i',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
		}
		else{
			$tim[$k] = "";	
		}	
	}
	$x->set_steps(4);
	break;
	case "week":
	for($k=0;$k<$SplitNum;$k++){
		$tim[$k] = date('m-d',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
	}
	$x->set_steps(1);
	break;
	case "month":
	for($k=0;$k<=$SplitNum;$k++){
		if($k%2==0){
			$tim[$k] = date('m-d',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
		}
		else{
			$tim[$k] = "";	
		}	
	}
	$x->set_steps(2);
	break;
}

$x->set_labels_from_array($tim);

$x->set_offset(true);

$x->set_colour( '#A2ACBA');

$line_dot->set_values( $data );
// $line_dot1->set_values( $data1 );
$line_dot->set_colour('ff0000');
$y=new OFC_Elements_Axis_Y();

$y->set_range($DataMin,$DataMax,0.01);

$y->set_steps(($DataMax-$DataMin)*0.1);

$y->set_colour( '#A2ACBA');

$chart->set_x_axis($x);

$chart->set_y_axis($y);

$chart->add_element( $line_dot );
// $chart->add_element( $line_dot1 );
$chart->set_bg_colour( '#f2f2f2');
//$y_legend = new OFC_Elements_Legend_Y("/V");
//$y_legend->set_style( '{font-size: 10px; color: #000000}' );
//$chart->set_y_legend($y_legend);
echo $chart->toPrettyString();

?>