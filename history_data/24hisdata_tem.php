<?php
require_once 'db_info.php';
session_start();
date_default_timezone_set('Etc/GMT-8');
$id = $_SESSION["temp"];
require_once('OFC/OFC_Chart.php');

$title = new OFC_Elements_Title( '温度变化曲线图' );
 
$line_dot = new OFC_Charts_Line();

$chart = new OFC_Chart();

$chart->set_title( $title );
//$label = array('','1:00','','3:00','','5:00','','7:00','','9:00','','11:00','','13:00','','15:00','','17:00','','19:0 0','',date('H:00',time()-60*60),'',date('H:00'));
	for($i=47,$j=0;$i>=0;$i--,$j++){
		$time = mktime(date('H',time()), date('i',time())-30*$i, 0, date('m',time()), date('d',time()), date('Y',time()));
		$query = "SELECT max(DataValue) FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=1&&Time>".$time."&&Time<".($time+30*60);
		$result = mysqli_query(get_connect(),$query);
		if(!$result) 
		die($id);
		$row = mysqli_fetch_row($result);
		if($row[0]<80&&$row[0]>-39.6)	
		$tem[$j] = (float)$row[0];	
		else
		$tem[$j] = 0;
		if($j%2==0)
		$label[$j] = date('H',time()-30*60*$i);
		else
		$label[$j] = '';
	}

$x=new OFC_Elements_Axis_X();

$x->set_colour( '#A2ACBA');

$x->set_labels_from_array($label);
$x->set_offset(true);

$x->set_steps(2);

$y=new OFC_Elements_Axis_Y();

$y->set_range(0,40,0.01);

$y->set_steps(5);

$y->set_colour( '#A2ACBA');

$line_dot->set_values( $tem );

$line_dot->set_colour('#000000');

$chart->set_x_axis($x);

$chart->set_y_axis($y);

$chart->add_element( $line_dot );

$chart->set_bg_colour( '#f2f2f2');

$y_legend = new OFC_Elements_Legend_Y("/℃");
$y_legend->set_style( '{font-size: 10px; color: #000000}' );
$chart->set_y_legend($y_legend);

echo $chart->toPrettyString();

?>