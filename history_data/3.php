<?php
require_once 'db_info.php';
session_start();
$id = $_SESSION["temp"];
require_once('OFC/OFC_Chart.php');

$title = new OFC_Elements_Title( '温湿度变化曲线图：'.date("D M d Y") );
 
$line_dot = new OFC_Charts_Line();

$line_dot2 = new OFC_Charts_Line();

date_default_timezone_set('Etc/GMT-8');

for($i=0;$i<20;$i++){
	$time = time()-($i+1)*60;
	$query = "SELECT DataValue FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=1&&Time>".$time."&&Time<".($time+90);
	$result = mysqli_query(get_connect(),$query);
	if(!$result) 
	die($id);
		
	$row = mysqli_fetch_row($result);	
	$tem[$i] = (float)$row[0];
	
	$query1 = "SELECT DataValue FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=0&&Time>".$time."&&Time<".($time+90);
	$result1 = mysqli_query(get_connect(),$query1);
	if(!$result1) 
	die($id);
		
	$row1 = mysqli_fetch_row($result1);	
	$hum[$i] = (float)$row1[0];
}

$line_dot->set_values( $tem );

$line_dot2->set_values( $hum );

$line_dot->set_colour('#000');


$chart = new OFC_Chart();

$chart->set_title( $title );

$x=new OFC_Elements_Axis_X();

$x->set_offset(false);

$x->set_steps(1);

$x->set_colour( '#A2ACBA');

$x->set_range(1,20,1);

$y=new OFC_Elements_Axis_Y();

$y->set_range(0,80,0.01);

$y->set_steps(15);

$y->set_colour( '#A2ACBA');

$chart->set_x_axis($x);

$chart->set_y_axis($y);

$chart->add_element( $line_dot );

$chart->add_element( $line_dot2 );

echo $chart->toPrettyString();

?>