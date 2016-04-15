<?php
require_once 'db_info.php';
date_default_timezone_set('Etc/GMT-8');
function getMaxData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin)
{
	$query = "SELECT AddTime,DataValue FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".($time-$SplitNum*$SplitTime*60)."&&AddTime<".$time."&&DataValue>".$DataMin."&&DataValue<".$DataMax." order by AddTime asc";
	// $sql = "call getData(".$id.",".$DataType.",".$time.",".$SplitNum.",".$SplitTime.")";
	$result = mysqli_query(get_connect(),$query);
	if(!$result)
	die("unable to connect database");
	$max=0;
	$rows = mysqli_num_rows($result);
	$j=0;
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
				$max = $tem[$j];	
				$max = $row[1]>$max?$row[1]:$tem[$j];			
				break;
			}else
			{				
				$j++;
			}
		}
		$tem[$j]=(float)$max;
	}
	return $tem;
}
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
					$min = $tem[$j];
					$min = $row[1]<$min?$row[1]:$min;			
					break;
				}else
				{				
					$j++;
				}			
			}
			$tem[$j]=(float)$min;
		}
		return $tem;
}
function getData($time,$SplitTime,$SplitNum,$id,$DataType,$DataMax,$DataMin){
	$query = "SELECT AddTime,DataValue FROM wsn_history_data WHERE NodeID=".$id."&&DataType=".$DataType."&&AddTime>".($time-$SplitNum*$SplitTime*60)."&&AddTime<".$time."&&DataValue>".$DataMin."&&DataValue<".$DataMax." order by AddTime asc";
	$result = mysqli_query(get_connect(),$query);
	if(!$result) 
	die($id);
	$rows = mysqli_num_rows($result);
	$j=0;
	while($j<$SplitNum){
		$tem[$j]=1;	
		$j++;
	}
	return $tem;
}
?>