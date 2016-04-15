<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php 
require 'getHistoryData.php';
$SplitTime=30;
$SplitNum=48;
$DataType=1;
$DataMax=80;
$DataMin=-39.6;
$id =2;
$j=0;
	while($j<48){
		$tem[$j]=0;	
		$j++;
	}
	$time= time();
$tem = getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
print_r( $tem);
?>
</body>
</html>