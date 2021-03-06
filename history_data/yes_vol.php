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

$x=new OFC_Elements_Axis_X();

$x->set_offset(false);

$label = array('','1:00','','3:00','','5:00','','7:00','','9:00','','11:00','','13:00','','15:00','','17:00','','19:00','','21:00','','23:00');
$x->set_labels_from_array($label);
$x->set_offset(true);

$x->set_steps(2);

$x->set_colour( '#A2ACBA');

for($i=0;$i<24;$i++){
		$time = mktime($i, 0, 0, date('m',time()), date('d',time())-1, date('Y',time()));
		$query = "SELECT max(DataValue) FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=3&&Time>".$time."&&Time<".($time+60*60);
		$result = mysqli_query(get_connect(),$query);
		if(!$result) 
		die($id);
		$row = mysqli_fetch_row($result);	
		$vol[$i] = (float)$row[0]>3?0:(float)$row[0];	
	}

$line_dot->set_values( $vol );

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