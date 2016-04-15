<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
require 'db_info.php';
$id = $_POST['node_id'];
$lng = $_POST['lng'];
$lat = $_POST['lat'];
$query = "update wsn_node_data set NodePosition_X='".$lng."',NodePosition_Y='".$lat."'where NodeID=".$id;
    $result = mysqli_query(get_connect(),$query);
    if(!$result) die('Unable Query Table:'.mysql_error());
    
?>
<a href="index.php">返回首页</a>
</body>
</html>