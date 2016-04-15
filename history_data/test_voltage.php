<?php
require_once 'db_info.php';
session_start();
$id = $_SESSION["temp"];
require_once('OFC/OFC_Chart.php');

$title = new OFC_Elements_Title( '电压变化曲线：'.date("D M d Y") );
 
$line_dot = new OFC_Charts_Line();

date_default_timezone_set('Etc/GMT-8');

$chart = new OFC_Chart();

$chart->set_title( $title );

$x=new OFC_Elements_Axis_X();

$x->set_offset(false);

$x->set_steps(1);

$x->set_colour( '#A2ACBA');

for($i=720,$j=0;$i>0;$i-=10,$j++){
	
		$time = mktime(date('H',time()),date('i',time())-$i, 0, date('m',time()), date('d',time()), date('Y',time()));
		$query = "SELECT max(DataValue) FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=3&&Time>".$time."&&Time<".($time+60*10);
		$result = mysqli_query(get_connect(),$query);
		if(!$result) 
		die($id);
		$row = mysqli_fetch_row($result);	

		$vol[$j] = (float)$row[0]>3?0:(float)$row[0];	
	}
$x->set_range(72,1,3);

$line_dot->set_values( $vol );
//$x->set_range(1,20,1);

$y=new OFC_Elements_Axis_Y();

$y->set_range(0,3.0,0.01);

$y->set_steps(0.5);

$y->set_colour( '#A2ACBA');

$chart->set_x_axis($x);

$chart->set_y_axis($y);

$chart->add_element( $line_dot );

$chart->set_bg_colour( '#f2f2f2');

echo $chart->toPrettyString();

?>