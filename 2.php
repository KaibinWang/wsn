<?php
require_once 'db_info.php';
date_default_timezone_set('Etc/GMT-8');
$query = "SELECT AddTime,NodeID,Voltage FROM wsn_node_data where AddTime<".(time()-24*60*60);
			$result = mysqli_query(get_connect(),$query);
			if(!$result) die('Unable Query Table:'.mysql_error());
			$rows = mysqli_num_rows($result);
echo "<table id='node_list'>";
$colnum=4;
for($i=0;$i<(int)($rows/$colnum)+1;$i++)
{
	echo "<tr >";
	for($j=0;$j<$colnum&($i*$colnum+$j)<$rows;$j++)
	{
			$row = mysqli_fetch_row($result);
			echo "<td height='32'>
			<form action='post.php' method='get'>";
			if(time()-$row[0]<31*60){$color = '#0F6';}
			else if(time()-$row[0]<61*60){$color = 'orange';}
			else{$color = '#F69';}
			echo"
			<button style='background-color:$color'>
			<ul width='20%' height='20' border='1'>
			<li>ID:<input type='hidden' name='id' value='$row[1]'>$row[1]</li>
			<li>电池电压:<div id='vol'>$row[2]</div></li>
			<li>最后更新时间:<div id='time'>".date("Y-m-d H:i:s", $row[0])."</div></li>
			</ul>
			</button>
			</form>
			</td>";
	}	
	echo "</tr>";
}
echo "</table>";

?>