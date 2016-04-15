<?php
require_once 'db_info.php';
session_start();
$id = $_SESSION["temp"];
require_once('OFC/OFC_Chart.php');

$title = new OFC_Elements_Title( '电压变化曲线：' );
 
$line_dot = new OFC_Charts_Line();

date_default_timezone_set('Etc/GMT-8');

$chart = new OFC_Chart();

$chart->set_title( $title );

$time = time();//当前时间

require 'getHistoryData.php';
$SplitTime=30;
$SplitNum=48;
$DataType=3;
$DataMax=4;
$DataMin=0;
$vol1= getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
for($i=0;$i<$SplitNum;$i++)
	$vol[$i] = $vol1[$i];


$x=new OFC_Elements_Axis_X();
for($k=0;$k<=$SplitNum;$k++){
	if($k%4==0){
		$tim[$k] = date('H:i',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
	}
	else{
		$tim[$k] = "";	
	}	
}
$x->set_labels_from_array($tim);
$x->set_offset(true);

$x->set_steps(2);

$x->set_colour( '#A2ACBA');


$line_dot->set_values( $vol );

$y=new OFC_Elements_Axis_Y();

$y->set_range($DataMin,$DataMax,0.01);

$y->set_steps(0.5);

$y->set_colour( '#A2ACBA');

$chart->set_x_axis($x);

$chart->set_y_axis($y);

$chart->add_element( $line_dot );

$chart->set_bg_colour( '#f2f2f2');
$y_legend = new OFC_Elements_Legend_Y("/V");
$y_legend->set_style( '{font-size: 10px; color: #000000}' );
$chart->set_y_legend($y_legend);
echo $chart->toPrettyString();

?>