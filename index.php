<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<title>无线传感器网络展示平台</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jtopo-0.4.8-min.js"></script> 
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=3m3F7hOr2x9AaPn4tKtZeRGc"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/library/CurveLine/1.5/src/CurveLine.min.js"></script>

<style>
*{ margin:0; padding:0; list-style:none; text-decoration:none;}.wraper{ width:100%;}
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

	<div class="column" id="content" style="width:94%">
	    <?php 
				require 'xml.php';
		?>
		<div id="map" style="width:920px; height:500px;margin:auto;"></div>
        <button onClick="addline()">添加路径</button>
        <button onClick="removeline()">移除路径</button>
  		<br>
<h2 align="center">网络结构拓扑图</h2>
<canvas id = 'canvas' width = "920" height="500" style="background-color:#EEEEEE;border:1px solid#444;"></canvas>
	</div>
	<div id="footer">
	
		<p>Copyright &copy; <b>LLC</b></p>
		
	</div>

</div><!-- End Wrapper -->

<script type="text/javascript">//设置等高
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
<script type="text/javascript">//读取节点信息
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
	//画拓扑图
	var canvas = document.getElementById('canvas');
	var stage = new JTopo.Stage(canvas);
	var scene = new JTopo.Scene(stage);
	var host = new JTopo.Node("1");
	host.setImage('img/node.png'); 
	host.fontColor="0,0,0";
	scene.add(host);
	host.setLocation((canvas.width-100)/2, (canvas.height-100)/2);
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
<script src="http://www.lanrenzhijia.com/ajaxjs/1.7.2/jquery-1.7.2.min.js"></script>
<script src="js/jquery.movebg.js"></script>
<script>
//导航栏动画
$(function(){
	$(".nav").movebg({width:120/*滑块的大小*/,extra:40/*额外反弹的距离*/,speed:300/*滑块移动的速度*/,rebound_speed:400/*滑块反弹的速度*/});
})
</script>

<script type="text/javascript"> 
var map = new BMap.Map("map",{mapType:BMAP_HYBRID_MAP});          // 创建地图实例  
var point = new BMap.Point(113.40517, 23.042166);  // 创建中心点坐标  
map.centerAndZoom(point, 19);                 // 初始化地图，设置中心点坐标和地图级别
map.addControl(new BMap.NavigationControl());    
//map.addControl(new BMap.ScaleControl());    
//map.addControl(new BMap.OverviewMapControl());    
map.addControl(new BMap.MapTypeControl()); 
</script>  
<script type="text/javascript">
//添加汇聚节点标记
var host = new BMap.Point(113.40517,23.042153);
var host_marker = new BMap.Marker(host);
map.addOverlay(host_marker);
addClickHandler('1',"1号汇聚节点",host_marker);

var polylines = new Array();
//添加所有节点标记
	for(i=0;i<x.length;i++){
	var point = new BMap.Point(x[i].getAttribute('NodePosition_X'), x[i].getAttribute('NodePosition_Y')); 
  	var marker = new BMap.Marker(point);// 创建标注
	var label = new BMap.Label(x[i].getAttribute('nodeid'),{offset:new BMap.Size(20,-10)});
	marker.setLabel(label);
	//marker.setIcon(new BMap.Icon("img/node.png",new BMap.Size(10,10)));
	var id = x[i].getAttribute('nodeid');
	var content = "节点："+x[i].getAttribute('nodeid')+"<br>电压："+x[i].getAttribute('Voltage')+"<br>下一跳节点："+x[i].getAttribute('nexthop')+"<br>最后更新时间："+x[i].getAttribute('updatetime');
	addClickHandler(id,content,marker);
	map.addOverlay(marker);
	
	//添加路径
	//var first = new BMap.Point(x[i].getAttribute('NodePosition_X'), x[i].getAttribute('NodePosition_Y'));
	var nexthop = x[i].getAttribute('nexthop');
	for(j=0;j<x.length;j++){
		if(x[i].getAttribute('nexthop')==1){
			var last = new BMap.Point(113.40517,23.042153);		
		}
		else if(x[j].getAttribute('nodeid')==nexthop){
			var last =new BMap.Point(x[j].getAttribute('NodePosition_X'), x[j].getAttribute('NodePosition_Y'));	
		}	
	}	
	var polyline = new BMap.Polyline([point,last],{strokeColor:"blue", strokeWeight:2, strokeOpacity:0.5});
	polylines.push(polyline);
}

var opts = {
			width : 200,     // 信息窗口宽度
			height: 100,     // 信息窗口高度
			title : "节点信息" , // 信息窗口标题
			enableMessage:false,//设置允许信息窗发送短息
		   };
function addClickHandler(id,content,marker){
	marker.addEventListener("mouseover",function(e){
		openInfo(content,e)}
	);
	marker.addEventListener("click",function(e){
		window.open("post.php?id="+id,'_self');}
	);
}
function openInfo(content,e){
	var p = e.target;
	var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
	var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
	map.openInfoWindow(infoWindow,point); //开启信息窗口
}

//添加路径的方法
function addline(){
	for(k=0;k<polylines.length;k++){
		map.addOverlay(polylines[k]); //添加到地图中}
	}
}
function removeline(){
	for(k=0;k<polylines.length;k++){
		map.removeOverlay(polylines[k]); //添加到地图中}
	}
}
</script>
</body>

</html>