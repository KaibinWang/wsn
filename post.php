<?php session_start();?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	
	<title>节点详细信息</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/swfobject.js"></script>	
	<script src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
	<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>


<style>
*{ margin:0; padding:0; list-style:none; text-decoration:none;}
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

    <div class="nav">
        <ul><!-- Navigation -->
            <li class="nav-item"><a href="index.php">主页</a></li>
            <li class="nav-item"><a href="solutions.php">节点信息</a></li>
            <li class="nav-item"><a href="#">关于</a></li>
            <li class="nav-item"><a href="#">联系我们</a></li>
        </ul>
        <div class="move-bg"></div>
    </div>
    
	<div id="content" style=" width:94%; height:auto;"><!-- Start Content -->
		
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
		        节点ID:<?php echo $row[0]?>
		        </li>
		        <li>
		        下一跳节点ID:<?php echo $row[2]?>
		        </li>
		        <li>
		        电压:<?php echo $row[7]?>
		        </li>
	      	</ul>
	    </div>

	    <div id="right_ul" style="width:300px; float:left; padding-bottom:2%">
	        <ul>
		        <li>
		        光照强度:<?php echo $row[5]?>
		        </li>
		        <li>
		        温度:<?php echo $row[3]?>
		        </li>
		        <li>
		        湿度:<?php echo $row[4]?>
		        </li>
		        <li>
		        最后更新时间:<?php echo date("Y-m-d H:i:s", $row[8])?>
		        </li>
	        </ul>
	    </div>

	    <div id="neibornode" style="float:left">
			<table border="1px">
		    <th>邻居节点</th><th>RSSI</th><th>时间</th><th>信号值</th><th>距离</th>
		    <?php 
				$query1 = "SELECT NeighborNodeID,Rssi_value,AddTime FROM wsn_neighbor_relation WHERE NodeID=".$id."&&AddTime>".(time()-31*24*60*60);
		    	$result1 = mysqli_query(get_connect(),$query1);
		    	if(!$result1) die('Unable Query Table:'.mysql_error());
					while($row = mysqli_fetch_row($result1)){
						echo "<tr>";
						
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
			?>
			</table>
	  	</div>

		<div style="text-align:center; float:left; width:100%; clear:both">
		    <select id="date_type">
		      <option value="day">日</option>
		      <option value="week">周</option>
		      <option value="month">月</option>
		    </select>
		    
		    <select id="data_type" >
		    	<option value="hum">湿度</option>
		    	<option value="tem">温度</option>
		    	<option value="lig">光照</option>
		    	<option value="vol">电压</option>
		    </select> 
		   <button>查询</button>
		    <p><font color="#FF0000">红色</font>代表最高，<font color="#0066FF">蓝色</font>代表最低</p>
			<br />
		    <div id='hisdata' style="min-width:700px;height:400px"></div>
		    <br />
		</div>
  	</div><!-- End Content -->

	<div id="footer">	
		<p>Copyright &copy;<b>LLC</b></p>
	</div><!-- End Footer -->
</div><!-- End Wrapper -->

<script type="text/javascript">
// function datatype(datatype){
// 	var data = document.getElementById("data_type");
// 	var type = data.options[data.selectedIndex].value;
// 	if(datatype=="hum"){
// 		swfobject.embedSWF("open-flash-chart.swf", "hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"history_data.php?datetype=day%26datatype=0"});
// 	}else if(datatype=="tem"){
// 		swfobject.embedSWF("open-flash-chart.swf", "hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"history_data.php?datetype=day%26datatype=1"});
// 	}else if(datatype=="lig"){
// 		swfobject.embedSWF("open-flash-chart.swf", "hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"history_data.php?datetype=day%26datatype=3"});
// 	}else if(datatype=="vol"){
// 		swfobject.embedSWF("open-flash-chart.swf", "hisdata", "800", "300", "9.0.0","expressInstall.swf",{"data-file":"history_data.php?datetype=day%26datatype=5"});
// 	}
	
// }
$(function(){
	var datetype = $("#date_type").val();
	var datatype = $("#data_type").val();
	$("button").bind('click',function(){
		datetype = $("#date_type  :selected").val();
		datatype = $("#data_type  :selected").val();
		$.get(
		"history.php",
		{datatype:datatype,datetype:datetype},
		function(response){
			console.log(response['data']);
			$('#hisdata').highcharts({
				title: {
					text: response['title'],
					x: -20 //center
				},
				xAxis:{
					categories:response['time']
				},
		        tooltip: {
	        		valueSuffix: response['unit']
		        },
		        legend: {
		        	layout: 'vertical',
		         	align: 'right',
		        	verticalAlign: 'middle',
		        	borderWidth: 0
		        },
		        series:[{name:'最高',data:response['maxdata']},{name:'最低',data:response['mindata']}]
			});
		},
		"json"
		);
	});
})
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
</body>

</html>
