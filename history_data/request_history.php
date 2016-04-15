<?php
	session_start();
	require 'db_info.php';
	if($_POST['histime']==""){
		$histime = 0;
	}else{
		$histime = $_REQUEST['histime'];	
	}
	
    $nowtime = time();
	date_default_timezone_set('Etc/GMT-8');
	//$time = $nowtime - $histime*24*60*60;
	$time = mktime(0, 0, 0, date('m',time()), date('d',time())-$histime, date('Y',time()));
	//echo $time."<br>";
	$lefttime = $time;
	//echo $lefttime."<br>";
	$righttime = $time+24*60*60;
	//echo $righttime;
	$id = $_SESSION["temp"];
	?>
	<?php 
	//湿度
		$query="select Time,DataValue from wsn_histimedata where DataValue = (select max(DataValue) from wsn_histimedata where NodeID=".$id." and DataType=0 and Time>".$lefttime." and Time<".$righttime.") and Time>".$lefttime." and Time<".$righttime;
		$result=mysqli_query(get_connect(),$query);
		if(!$result) die('Unable Query Table:'.mysql_error());
		$rows=mysqli_num_rows($result);
		echo "<ul>";
		for($i=0;$i<$rows;$i++){
			$row=mysqli_fetch_row($result);
			echo "<li>";
			echo "时间:".date("Y-m-d H:i:s", $row[0])."&nbsp;";
			echo "湿度:".$row[1]."&nbsp;";
			echo "</li>";
		}
		echo "</ul>";
	?>
    <?php 
	//温度
		$query="select Time,DataValue from wsn_histimedata where DataValue = (select max(DataValue) from wsn_histimedata where NodeID=".$id." and DataType=1 and Time>".$lefttime." and Time<".$righttime.") and Time>".$lefttime." and Time<".$righttime;
		$result=mysqli_query(get_connect(),$query);
		if(!$result) die('Unable Query Table:'.mysql_error());
		$rows=mysqli_num_rows($result);
		
		echo "<ul>";
		for($i=0;$i<$rows;$i++){
			$row=mysqli_fetch_row($result);
			echo "<li>";
			echo "时间:".date("Y-m-d H:i:s",$row[0])."&nbsp;";
			echo "温度:".$row[1]."&nbsp;";
			echo "</li>";
		}
		echo "</ul>";
	?>
    <?php 
	//光照
		$query="select Time,DataValue from wsn_histimedata where DataValue = (select max(DataValue) from wsn_histimedata where NodeID=".$id." and DataType=2 and Time>".$lefttime." and Time<".$righttime.") and Time>".$lefttime." and Time<".$righttime;
		$result=mysqli_query(get_connect(),$query);
		if(!$result) die('Unable Query Table:'.mysql_error());
		$rows=mysqli_num_rows($result);
		
		echo "<ul>";
		for($i=0;$i<$rows;$i++){
			$row=mysqli_fetch_row($result);
			echo "<li>";
			echo "时间:".date("Y-m-d H:i:s",$row[0])."&nbsp;";
			echo "光照:".$row[1]."&nbsp;";
			echo "</li>";
		}
		echo "</ul>"
?>