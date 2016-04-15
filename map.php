<!DOCTYPE html>  
<html>  
<head>  
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>获取经纬度</title>  
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  
#container{height:100%}  
</style>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=3m3F7hOr2x9AaPn4tKtZeRGc">
//v1.5版本的引用方式：src="http://api.map.baidu.com/api?v=1.5&ak=您的密钥"
//v1.4版本及以前版本的引用方式：src="http://api.map.baidu.com/api?v=1.4&key=您的密钥&callback=initialize"
</script>
</head>  
 
<body>  
<div id="container"></div> 
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("container");            
	map.centerAndZoom(new BMap.Point(113.40517,23.042166),17);  
 	map.addControl(new BMap.NavigationControl());    
	map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
	map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
	//单击获取点击的经纬度
	map.addEventListener("click",function(e){
		var lng = e.point.lng;
		var lat = e.point.lat;
		//window.open("sava_point.php?lng="+lng+'&lat='+lat,'_self');
		window.open("save_point.php?lng="+lng+'&lat='+lat,'_self');
	});             
</script>
</body>  
</html>