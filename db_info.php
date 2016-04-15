<?php
function get_connect(){
	$db_hostname = '192.168.2.58';
	$db_database = 'wsn_database';
	$db_username = 'wsn';
	$db_password = 'wsn';
	$link = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);
	if ($link->connect_error) {  
    	die('Connect Error ('. $link->connect_error.')'. $link->connect_error);  
	}
	return $link;
}
?>