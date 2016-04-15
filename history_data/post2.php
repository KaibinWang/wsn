<?php session_start();?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	
	<title>节点详细信息</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script type="text/javascript" src="js/jquery.js"></script>

	<script type="text/javascript" src="js/swfobject.js"></script>	
	<script type="text/javascript">
	function typeChange(){
		var date = document.getElementById("date_type");
		var type = date.options[date.selectedIndex].value;
		if(type=="today"){
		swfobject.embedSWF("open-flash-chart.swf", "tem_hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"today_tem.php"});
		swfobject.embedSWF("open-flash-chart.swf", "lig_hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"today_lig.php"});
		swfobject.embedSWF("open-flash-chart.swf", "hum_hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"today_hum.php"});
		swfobject.embedSWF("open-flash-chart.swf", "vol_hisdata", "800", "200", "9.0.0","expressInstall.swf",{"data-file":"test_voltage.php"});
		}
		else if(type=="yesterday"){
		swfobject.embedSWF("open-flash-chart.swf", "tem_hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"yes_tem.php"});
		swfobject.embedSWF("open-flash-chart.swf", "lig_hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"yes_lig.php"});
		swfobject.embedSWF("open-flash-chart.swf", "hum_hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"yes_hum.php"});
		swfobject.embedSWF("open-flash-chart.swf", "vol_hisdata", "800", "200", "9.0.0","expressInstall.swf",{"data-file":"yes_vol.php"});
		}
	}
    </script>

	<script type="text/javascript">
	swfobject.embedSWF("open-flash-chart.swf", "lig_hisdata", "450", "300", "9.0.0","expressInstall.swf",{"data-file":"today_lig.php"});
	swfobject.embedSWF("open-flash-chart.swf", "hum_hisdata", "450", "300", "9.0.0","expressInstall.swf",{"data-file":"today_hum.php"});
	swfobject.embedSWF("open-flash-chart.swf", "tem_hisdata", "450", "300", "9.0.0","expressInstall.swf",{"data-file":"today_tem.php"});
	swfobject.embedSWF("open-flash-chart.swf", "vol_hisdata", "900", "300", "9.0.0","expressInstall.swf",{"data-file":"test_voltage.php"});
	</script>
    
    <script type="text/javascript"> 
	function show(str){
		var xmlhttp;
		if(window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("POST","request_history.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		var poststr = "histime="+str;
		xmlhttp.send(poststr);
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			document.getElementById("txtHint").innerHTML=xmlhttp.responseText;	
		}
	}
</script>
<script src="http://www.lanrenzhijia.com/ajaxjs/1.7.2/jquery-1.7.2.min.js"></script>
<script src="js/jquery.movebg.js"></script>
<script>
$(function(){
	$(".nav").movebg({width:120/*滑块的大小*/,extra:40/*额外反弹的距离*/,speed:300/*滑块移动的速度*/,rebound_speed:400/*滑块反弹的速度*/});
})
</script>

<style>
*{ margin:0; padding:0; list-style:none; text-decoration:none;}
/* 代码整理：懒人之家 www.lanrenzhijia.com */
/* 正文 */
.wraper{ width:inherit;margin:0 auto}
.nav{ position:relative; width:100%; height:40px; background:#C70757; overflow:hidden}
.nav-item{ position:relative; float:left; width:120px; height:40px; line-height:40px; text-align:center; font-size:14px; z-index:1}
.nav-item a{ display:block; height:40px; color:#fff;}
.nav-item a:hover{
	color: #fff;
	font-size: 18px;
}
.move-bg{ display:none;position:absolute;left:0;top:0; width:120px; height:40px; background:#4D0B33; z-index:0}
</style>		
</head>

<body>
<div id="wrapper">


	<div id="header"><!-- Start Header -->
		
	  <a href="solutions.php"><h1 style="color:#FFF; padding-top:50px">无线传感器网络展示平台</h1></a>
	
	</div><!-- End Header -->
    <div class="wraper">
        <div class="nav">
            <ul><!-- Navigation -->
                <li class="nav-item"><a href="index.php">主页</a></li>
                <li class="nav-item"><a href="solutions.php">节点信息</a></li>
                <li class="nav-item"><a href="#">关于</a></li>
                <li class="nav-item"><a href="#">联系我们</a></li>
            </ul>
            <div class="move-bg"></div>
        </div>
    </div>
    
	<div id="content" style=" width:94%; height:auto; float: left;"><!-- Start Content -->
		
  	<h1>节点详细信息</h1>
		
	<?php
    require_once 'db_info.php';
    date_default_timezone_set('Etc/GMT-8');
	$id = $_GET['id'];
    $query = "SELECT * FROM wsn_node_data WHERE NodeID=".$id;
    $result = mysqli_query(get_connect(),$query);
    if(!$result) die('Unable Query Table:'.mysql_error());
            
    $row = mysqli_fetch_row($result);
    
    $_SESSION["temp"]=$id;
    ?>
    
    <div id="left_ul" style="float:left; width:300px; padding-bottom:2%">
        <ul>
        <li>
        节点ID:<?php echo $row[1]?>
        </li>
        <li>
        X:<?php echo $row[2]?>
        </li>
        <li>
        Y:<?php echo $row[3]?>
        </li>
        <li>
        下一跳节点ID:<?php echo $row[4]?>
        </li>
        <li>
        电压:<?php echo $row[6]?>
        </li>
        <li>
        其他:<?php echo $row[12]?>
        </li>
      </ul>
    </div>

    <div id="right_ul" style="width:300px; float:left; padding-bottom:2%">
        <ul>
        
        <li>
        光照强度:<?php echo $row[7]?>
        </li>
        <li>
        温度:<?php echo $row[8]?>
        </li>
        <li>
        湿度:<?php echo $row[9]?>
        </li>
        <li>
        CO2:<?php echo $row[10]?>
        </li>
        <li>
        粉尘:<?php echo $row[11]?>
        </li>
        <li>
        最后更新时间:<?php echo date("Y-m-d H:i:s", $row[0])?>
        </li>
        </ul>
    </div>

    <div id="neibornode" style="float:left">
      <table border="1px">
    <th>邻居节点</th><th>RSSI</th><th>时间</th><th>信号值</th><th>距离</th>
    <?php 
/*		$query1 = "SELECT NeighborNodeID,Rssi_value,Time FROM wsn_neighbornode WHERE NodeID=".$id."&&Time>".(time()-60*60);
    	$result1 = mysqli_query(get_connect(),$query1);
    	if(!$result1) die('Unable Query Table:'.mysql_error());
        $row_num = mysqli_num_rows($result1);
		for($i=0;$i<$row_num;$i++){
				echo "<tr>";
				$row = mysqli_fetch_row($result1);
				$r = $row[1];
				
				if($r>128){$rssi=($r-256)-45;}else{$rssi=$r-45;}
				if($rssi<0){$distance=round(pow(10,(-$rssi-55)/pow(10,1.35)),4);}else{$distance=round(pow(10,($rssi-55)/pow(10,1.35)),4);}	
					echo "<td>".$row[0]."</td>";
					echo "<td>".$r."</td>";
					echo "<td>".date("H:i:s", $row[2])."</td>";
					echo "<td>&nbsp;&nbsp;".$rssi."</td>";
					echo "<td>&nbsp;&nbsp;".$distance."</td>";
				echo "</tr>";	
			}
		echo "<tr>";*/
	?>
    </table>
  </div>
<div style="text-align:center; float:left; width:100%; clear:both">
	<br />
    <div id='tem_hisdata'></div>
    <div id='lig_hisdata'></div>
    <br />
    <div id='hum_hisdata'></div>
	<div id='vol_hisdata'></div>
    <br />
    <select id="date_type" onChange="typeChange()">
      <option value="today">今天</option>
        <option value="yesterday">昨天</option>
    </select>
</div>
  </div><!-- End Content -->

	<div id="footer">
	
		<p>Copyright &copy;<b>LLC</b></p>
		
	</div><!-- End Footer -->


</div><!-- End Wrapper -->
</body>

</html>
