<?php
require_once 'db_info.php';
date_default_timezone_set('Etc/GMT-8');
//获取最近时间的最高值
function getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin)
{
	$query = "SELECT AddTime,DataValue FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".($time-$SplitNum*$SplitTime*60)."&&AddTime<".$time."&&DataValue>".$DataMin."&&DataValue<".$DataMax." order by AddTime asc";
	$result = mysqli_query(get_connect(),$query);
	if(!$result)
	die("unable to connect database");
	$max=0;
	$rows = mysqli_num_rows($result);
	$j=0;
	$tem = array();
	while($j<$SplitNum){
		$tem[$j]=0;	
		$j++;
	}
	for($i=0;$i<$rows;$i++){
		$row = mysqli_fetch_row($result);
		$j =0;//从第一段开始适配
		while($j<$SplitNum){
			if($row[0]>($time-$SplitNum*$SplitTime*60+$SplitTime*60*$j)&&$row[0]<($time-$SplitNum*$SplitTime*60+$SplitTime*60*($j+1)))
			{		
				$max = $row[1]>$tem[$j]?$row[1]:$tem[$j];
				break;
			}else
			{				
				$j++;
			}
		}
		$tem[$j]=(float)$max;
	}
	$j=0;
	while($j<$SplitNum){
		if($tem[$j]==0){
			$tem[$j] = null;
		}
		$j++;
	}
	return $tem;
}
//获取最近时间的最低值
function getMinData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin){
	$query = "SELECT AddTime,DataValue FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".($time-$SplitNum*$SplitTime*60)."&&AddTime<".$time."&&DataValue>".$DataMin."&&DataValue<".$DataMax." order by AddTime asc";
		$result = mysqli_query(get_connect(),$query);
		if(!$result) 
		die($id);
		$min=$DataMax;
		$rows = mysqli_num_rows($result);
		$j=0;
		while($j<$SplitNum){
			$tem[$j]=$DataMax;	
			$j++;
		}
		$rowarray = mysqli_fetch_all($result);
		for($i=0;$i<$rows;$i++){
			$row = $rowarray[$i];
			$j =0;//从第一段开始适配
			while($j<$SplitNum){
				if($row[0]>($time-$SplitNum*$SplitTime*60+$SplitTime*60*$j)&&$row[0]<($time-$SplitNum*$SplitTime*60+$SplitTime*60*($j+1)))
				{			
					$min = $row[1]<$tem[$j]?$row[1]:$tem[$j];		
					break;
				}else
				{				
					$j++;
				}			
			}
			$tem[$j]=(float)$min;
		}
		$j=0;
		while($j<$SplitNum){
			if($tem[$j]==$DataMax){
				$tem[$j] = null;
			}
			$j++;
		}
		return $tem;
}
//获取一天24小时的平均值
function getDataByDay($year,$month,$day,$id,$DataType,$DataMax,$DataMin){
	$time = mktime(0,0,0,$month,$day,$year);
	$query = "SELECT AddTime,DataValue FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".$time."&&AddTime<".($time+24*60*60)."&&DataValue>".$DataMin."&&DataValue<".$DataMax." order by AddTime asc";
	$result = mysqli_query(get_connect(),$query);
	if(!$result) 
	die($id."error");
	$rows = mysqli_num_rows($result);
	$j=0;
	while($j<24){
		$tem[$j]=array();	
		$j++;
	}
	for($i=0;$i<$rows;$i++){
		$row = mysqli_fetch_row($result);
		for($j=0;$j<24;$j++){
			if($row[0]>($time+$j*60*60)&&$row[0]<($time+($j+1)*60*60)){
				array_push($tem[$j],$row[1]);
			}
		}
	}
	$data = array();
	foreach($tem as $one){
		if(count($one)!=0){
			$num = round(array_sum($one)/count($one),2);
		}else{
			$num = null;
		}
		array_push($data,$num);
	}
	return $data;
}
//获取某一个月每一天的最大值
function getDataByMonth($year,$month,$id,$DataType,$DataMax,$DataMin){
	$time = mktime(0,0,0,$month,0,$year);
	$day = date("t",$time);
	$query = "SELECT AddTime,DataValue FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".$time."&&AddTime<".($time+$day*24*60*60)."&&DataValue>".$DataMin."&&DataValue<".$DataMax." order by AddTime asc";
	$result = mysqli_query(get_connect(),$query);
	if(!$result) 
	die($id."error");
	$rows = mysqli_num_rows($result);
	$j=0;
	while($j<$day){
		$tem[$j]=array();	
		$j++;
	}
	for($i=0;$i<$rows;$i++){
		$row = mysqli_fetch_row($result);
		for($j=0;$j<$day;$j++){
			if($row[0]>($time+$j*24*60*60)&&$row[0]<($time+($j+1)*24*60*60)){
				array_push($tem[$j],$row[1]);
			}
		}
	}
	$data = array();
	foreach($tem as $one){
		if(count($one)>200){
			$num = round(max($one),2);
		}else{
			$num = null;
		}
		array_push($data,$num);
	}
	return $data;
}
?>