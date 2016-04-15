<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<title>无线传感器网络展示平台</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jtopo-0.4.8-min.js"></script> 
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=3m3F7hOr2x9AaPn4tKtZeRGc">
	//v1.5版本的引用方式：src="http://api.map.baidu.com/api?v=1.5&ak=您的密钥"
	//v1.4版本及以前版本的引用方式：src="http://api.map.baidu.com/api?v=1.4&key=您的密钥&callback=initialize"
	</script>


	<script src="http://www.lanrenzhijia.com/ajaxjs/1.7.2/jquery-1.7.2.min.js"></script>
	<script src="js/jquery.movebg.js"></script>

<style>
*{ margin:0; padding:0; list-style:none; text-decoration:none;}
.wraper{ width:100%;}
.nav{ position:relative; width:100%; height:40px; background:#C70757; overflow:hidden}
.nav-item{ position:relative; float:left; width:120px; height:40px; line-height:40px; text-align:center; font-size:14px; z-index:1}
.nav-item a{ display:block; height:40px; color:#fff;}
.nav-item a:hover{
	color: #fff;
	font-size: 18px;
	font-family: Garamond, "Hoefler Text", "Times New Roman", Times, serif;
}
.move-bg{ display:none;position:absolute;left:0;top:0; width:120px; height:40px; background:#4D0B33; z-index:0}
</style>
</head>

<body>
<div id="wrapper">
<!-- Start Header -->
	<div id="header">
		
	  <a href="solutions.php"><h1 style="color:#FFF; padding-top:50px">无线传感器网络展示平台</h1></a>

</div>
<!-- End Header -->
	
	<div class="wraper">
        <div class="nav">
            <ul><!-- Navigation -->
                <li class="nav-item"><a href="index.php">主页</a></li>
                <li class="nav-item"><a href="solutions.php">节点信息</a></li>
                <li class="nav-item"><a href="map.php">部署节点</a></li>
                <li class="nav-item"><a href="#">联系我们</a></li>
            </ul>
            <div class="move-bg"></div>
        </div>
    </div>

	<div class="column" id="content" style="width:44%">
		<h1>节点数据</h1>
		
		<?php 
        	require_once 'db_info.php';
			// include 'xml.php';
			$result = mysqli_query(get_connect(),'SELECT NodeID FROM wsn_node_data');
			if(!$result) die('Unable Query Table:'.mysql_error());
			$rows = mysqli_num_rows($result);	
			echo "<p>总节点个数:".$rows."</p><br>";
            	include '1.php';
			echo "<p>未活动节点</p><br>";
				include '2.php';
			?>
	</div>
    <div class="column" id="sidebar">
    <div id="map" style="width:450px; height:500px"></div>
<canvas id = 'canvas' width = "400" height="500" style="background-color:#EEEEEE;box-shadow:-3px -3px 3px #000, 3px 3px 3px #000; margin-top:100px">
  
</canvas>
</div>

	<div id="footer">
	
		<p>Copyright &copy; <b>LLC</b></p>
		
	</div><!-- End Footer -->


</div><!-- End Wrapper -->
<script type="text/javascript">
function equalHeight(group) {
	tallest = 0;
	group.each(function() {
		thisHeight = $(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.height(tallest);
}
</script>
<script type="text/javascript">
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();	
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");	
	}
	xmlhttp.open("GET","01.xml",false);
	xmlhttp.send();
	xmlDoc=xmlhttp.responseXML;
	var x=xmlDoc.getElementsByTagName("node");

</script>
<script type="text/javascript">
$(document).ready(
function(){
	equalHeight($(".column"));
	var canvas = document.getElementById('canvas');
	var stage = new JTopo.Stage(canvas);
	var scene = new JTopo.Scene(stage);
	var host = new JTopo.Node("1");
	host.setImage('img/node.png'); 
	host.fontColor="0,0,0";
	scene.add(host);
	host.setLocation(100, 150);
	var nodelist = new Array();
	for(i=0;i<x.length;i++){
		var node = new JTopo.Node(x[i].getAttribute('nodeid'));
		node.setImage('img/node.png'); 
		node.fontColor="0,0,0";
		var canvas = document.getElementById('canvas');
		node.setLocation((canvas.width-100) * Math.random(), (canvas.height-100) * Math.random());
		scene.add(node);
		nodelist.push(node);
	}
	var nextlist = new Array();
	for(j=0;j<x.length;j++){
		for(k = 0;k < nodelist.length;k++){
			if(x[j].getAttribute('nexthop')=='1'){
				nextlist.push(host);
				break;
			}
			else if(x[j].getAttribute('nexthop')==nodelist[k].text){
				nextlist.push(nodelist[k]);
				break;
			}
		}
		if(nextlist[j]==null){
			nextlist[j]=0;	
		}
	}
	for(l=0;l<x.length;l++){
		if(nextlist[l]!=0){
			scene.add(new JTopo.Link(nodelist[l],nextlist[l]));	
		}
	}
	stage.play(scene);
}
);
</script>
<script>
$(function(){
	$(".nav").movebg({width:120/*滑块的大小*/,extra:40/*额外反弹的距离*/,speed:300/*滑块移动的速度*/,rebound_speed:400/*滑块反弹的速度*/});
})
</script>
<script type="text/javascript"> 
	var map = new BMap.Map("map");          // 创建地图实例  
	var point = new BMap.Point(113.40517, 23.042166);  // 创建中心点坐标  
	map.centerAndZoom(point, 19);                 // 初始化地图，设置中心点坐标和地图级别
	map.addControl(new BMap.NavigationControl());    
	map.addControl(new BMap.ScaleControl());    
	map.addControl(new BMap.OverviewMapControl());    
	map.addControl(new BMap.MapTypeControl());   
	</script>  
  <script type="text/javascript">
  	for(i=0;i<x.length;i++){
		var point = new BMap.Point(x[i].getAttribute('NodePosition_X'), x[i].getAttribute('NodePosition_Y')); 
	  	var marker = new BMap.Marker(point);// 创建标注
		map.addOverlay(marker);  
		var label = new BMap.Label(x[i].getAttribute('nodeid'),{offset:new BMap.Size(20,-10)});
		marker.setLabel(label);    
	}
  	  
  </script>
</body>

</html>