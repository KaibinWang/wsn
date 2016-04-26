<?php
	require_once 'db_info.php';
	date_default_timezone_set('Etc/GMT-8');
	$id = $_GET["nodeid"];
	$query = "SELECT * FROM wsn_node_data WHERE NodeID=".$id;
	$result = mysqli_query(get_connect(),$query);
	if(!$result) die('Unable Query Table:'.mysql_error());
	        
	$row = mysqli_fetch_row($result);
	$response = Array();
	$response['id'] = $row[0];
	$response['nodetype'] = $row[1];
	$response['nexthop'] = $row[2];
	$response['temperature'] = $row[3];
	$response['humitity'] = $row[4];
	$response['light'] = $row[5];
	$response['sensordata'] = $row[6];
	$response['voltage'] = $row[7];
	$response['last_time'] = date("Y-m-d H:i:s", $row[8]);

	$sql = "SELECT * FROM wsn_node_position WHERE NodeID='".$row[0]."'";
	$res = mysqli_query(get_connect(),$sql);
	if(!$res) die('Unable Query Table:'.mysql_error());
	if($r = mysqli_fetch_row($res)){
		$response['lng'] = $r[1];
		$response['lat'] = $r[2];
	}
	echo json_encode($response);
?>