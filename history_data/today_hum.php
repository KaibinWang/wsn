<?php
require_once 'db_info.php';
session_start();
$id = $_SESSION["temp"];
require_once('OFC/OFC_Chart.php');

$title = new OFC_Elements_Title( '湿度变化曲线：' );
 
$line_dot = new OFC_Charts_Line();


$chart = new OFC_Chart();

$chart->set_title( $title );

require 'getHistoryData.php';
date_default_timezone_set('Etc/GMT-8');

$time = time();//当前时间
$SplitTime=30;
$SplitNum=48;
$DataType=0;
$DataMax=100;
$DataMin=0;
$hum1= getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
for($i=0;$i<$SplitNum;$i++)
	$hum[$i] = $hum1[$i];


$x=new OFC_Elements_Axis_X();
for($k=0;$k<=$SplitNum;$k++){
	if($k%4==0){
		$tim[$k] = date('H:i',($time-$SplitTime*$SplitNum*60+$k*$SplitTime*60)); 	
	}
	else{
		$tim[$k] = "";	
	}	
}
//$label = array('','1:00','','3:00','','5:00','','7:00','','9:00','','11:00','','13:00','','15:00','','17:00','','19:00','','21:00','','23:00');
$x->set_labels_from_array($tim);
$x->set_offset(true);

$x->set_steps(2);

$x->set_colour( '#A2ACBA');

$line_dot->set_values( $hum );

$y=new OFC_Elements_Axis_Y();

$y->set_range(0,100,0.01);

$y->set_steps(10);

$y->set_colour( '#A2ACBA');

$chart->set_x_axis($x);

$chart->set_y_axis($y);

$chart->add_element( $line_dot );

$chart->set_bg_colour( '#f2f2f2');


$y_legend = new OFC_Elements_Legend_Y('百分比/%');
$y_legend->set_style( '{font-size: 10px; color: #000000}' );
$chart->set_y_legend($y_legend);

echo $chart->toPrettyString();

?>