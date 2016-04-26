<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2016-04-22 12:05:09
 * @version $Id$
 */

    require_once 'db_info.php';
    date_default_timezone_set('Etc/GMT-8');

    $type = $_GET["type"];
    switch ($type) {
    	case '1':
    		$allnode = mysqli_query(get_connect(),"SELECT NodeID FROM wsn_node_data where AddTime<".(time()-2*60*60));
    		break;
    	case '2':
    	//查询活动节点
    		$allnode = mysqli_query(get_connect(),"SELECT NodeID FROM wsn_node_data where AddTime>".(time()-2*60*60));
    		break;
    	default:
    		$allnode = mysqli_query(get_connect(),"SELECT NodeID FROM wsn_node_data");
    		break;
    }
    if(!$allnode) die('Unable Query Table:'.mysql_error());
    $allrows = mysqli_num_rows($allnode);
    $node_list = array();
    $key = 0;
    for($i=0;$i<$allrows;$i++){
    	$node = mysqli_fetch_row($allnode);
    	$node_list[$i] = $node[0];
    }
    echo json_encode($node_list);


?>