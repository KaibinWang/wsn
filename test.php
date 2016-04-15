<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2015-10-06 20:18:57
 * @version $Id$
 */

require_once 'db_info.php';
require 'getHistoryData.php';
echo "before--->".date('H-i-s',time())."<br>";
date_default_timezone_set('Etc/GMT-8');
$time=time();
$id = 3;
$SplitTime=30;
$SplitNum=48;
$DataType=3;
$DateType='week';
switch($DateType){
	case "day":	$SplitTime=30;$SplitNum=48;break;
	case "week":$SplitTime=24*60;$SplitNum=7;break;
	case "month":$SplitTime=24*60;$SplitNum=30;break;
}
$DataMax=100;
$DataMin=0;
// $query1 = "SELECT Time,DataValue FROM wsn_histimedata WHERE NodeID=".$id."&&DataType=".$DataType."&&Time>".($time-$SplitNum*$SplitTime*60)."&&Time<".$time." order by Time asc";
// $sql="call getData(3,2,".$time.",48,30)";
// $result1=mysqli_query(get_connect(),$query1);
// echo "<br>after--->".date('H-i-s',time())."<br>";
// $row1 = mysqli_fetch_all($result1);
// print_r($row1);
// echo "<br>after--->".date('H-i-s',time());
$data= getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
print_r($data);

// $data1= getMinData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin);
// print_r($data1);

echo "<br>after--->".date('H-i-s',time());
?>