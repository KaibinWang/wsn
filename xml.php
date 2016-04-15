<?php 
require_once 'db_info.php';
date_default_timezone_set('Etc/GMT-8');
$query = "SELECT AddTime,NodeID,NextHop,Voltage FROM wsn_node_data where AddTime>".(time()-60*60);
//一小时前所有节点的信息
	$result = mysqli_query(get_connect(),$query);
	if(!$result) die('Unable Query Table:'.mysql_error());
	$rows = mysqli_num_rows($result);

	$xmlDoc = new DOMDocument(); 
	if(file_exists("01.xml")){
		unlink("01.xml");
	}
	$xmlstr = "<?xml version='1.0' encoding='utf-8' ?><message></message>"; 
	$xmlDoc->loadXML($xmlstr); 
	$xmlDoc->save("01.xml"); 
	$Root = $xmlDoc->documentElement; 
	
	for($i=0;$i<$rows;$i++){
		while ($arr = mysqli_fetch_row($result)){ 
			$node = $xmlDoc->createElement("node"); 
			$time = $xmlDoc->createAttribute('updatetime');
			$time->nodeValue=date("H:i:s",$arr[0]);
			$node->appendChild($time); 
			
			$nodeid = $xmlDoc->createAttribute('nodeid');
			$nodeid->nodeValue=$arr[1];
			$node->appendChild($nodeid); 
			
			$nexthop = $xmlDoc->createAttribute('nexthop');
			$nexthop->nodeValue=$arr[2];
			$node->appendChild($nexthop); 
			
			$Voltage = $xmlDoc->createAttribute('Voltage');
			$Voltage->nodeValue=$arr[3];
			$node->appendChild($Voltage); 

			$sql = "SELECT * FROM wsn_node_position WHERE NodeID='".$arr[1]."'";
			$res = mysqli_query(get_connect(),$sql);
			if(!$res) die('Unable Query Table:'.mysql_error());
			if($r = mysqli_fetch_row($res)){
				$node_X = $xmlDoc->createAttribute('NodePosition_X');
				$node_X->nodeValue=$r[1];
				$node->appendChild($node_X);
				$node_Y = $xmlDoc->createAttribute('NodePosition_Y');
				$node_Y->nodeValue=$r[2];
				$node->appendChild($node_Y);
			}

			$Root->appendChild($node); 
			
			$xmlDoc->save("01.xml"); 
		} 		
	}
?>