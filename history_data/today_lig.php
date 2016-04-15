<?php
require_once 'db_info.php';
session_start();
$id = $_SESSION["temp"];
$type = $_GET["type"];
require_once('OFC/OFC_Chart.php');

$title = new OFC_Elements_Title( '光照强度变化曲线：' );
 
$line_dot = new OFC_Charts_Line();

date_default_timezone_set('Etc/GMT-8');

$chart = new OFC_Chart();

$chart->set_title( $title );

$x=new OFC_Elements_Axis_X();
$label = array('','1:00','','3:00','','5:00','','7:00','','9:00','','11:00','','13:00','','15:00','','17:00','','19:00','','21:00','','23:00');
$x->set_labels_from_array($label);
$x->set_offset(true);

$x->set_steps(2);


for($i=0;$i<date('H',time());$i++){
		$time = mktime($i, 0, 0, date('m',time()), date('d',time()), date('Y',time()));
		$query = "SELECT max(DataValue) FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=".$type."&&Time>".$time."&&Time<".($time+60*60);
		$result = mysqli_query(get_connect(),$query);
		if(!$result) 
		die($id);
		$row = mysqli_fetch_row($result);
		if($row[0]>0)	
		$lig[$i] = (float)$row[0];	
		else
		$lig[$i] = 0;
	}

$line_dot->set_values( $lig );

$line_dot->set_colour('#ff0000');


$x->set_colour( '#A2ACBA');

$y=new OFC_Elements_Axis_Y();
$time1 = mktime(0, 0, 0, date('m',time()), date('d',time()), date('Y',time()));
$query1 = "SELECT min(DataValue),max(DataValue) FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=2&&Time>".$time1."&&Time<".($time1+24*60*60);
$result1 = mysqli_query(get_connect(),$query1);
$row1 = mysqli_fetch_row($result1);
$y->set_range(0,$row1[1],0.01);

$y->set_steps((int)$row1[1]*0.1);

$y->set_colour( '#A2ACBA');

$chart->set_x_axis($x);

$chart->set_y_axis($y);

$chart->add_element( $line_dot );
$chart->set_bg_colour( '#f2f2f2');

$y_legend = new OFC_Elements_Legend_Y("/ls");
$y_legend->set_style( '{font-size: 10px; color: #000000}' );
$chart->set_y_legend($y_legend);
echo $chart->toPrettyString();

?>