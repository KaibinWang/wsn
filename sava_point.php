<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=3m3F7hOr2x9AaPn4tKtZeRGc">
//v1.5版本的引用方式：src="http://api.map.baidu.com/api?v=1.5&ak=您的密钥"
//v1.4版本及以前版本的引用方式：src="http://api.map.baidu.com/api?v=1.4&key=您的密钥&callback=initialize"
</script>
<script type="text/javascript">
	function typeChange(){
		var date = document.getElementByName("node_id");
		var type = date.options[date.selectedIndex].value;
		document.getElementById('node').innerHTML=type;
	}
    </script>
</head>

<body>
    <?php 
	$lng = $_GET['lng'];
	$lat = $_GET['lat'];
	?>
<?php
	require 'db_info.php';
      $qurey = "select NodeID from wsn_node_data";
	  $result = mysqli_query(get_connect(),$qurey);
	  $row_num = mysqli_num_rows($result);
?>
<form action="update_position.php" method="post">
	<select name="node_id" onChange="typeChange()">
      <?php
		for($i=0;$i<$row_num;$i++){
				
				$row = mysqli_fetch_row($result);
				echo '<option value='.$row[0].'>'.$row[0].'</potion>';
		}
	  ?>
    </select>
    <input type="text" name="lng" id="lng" value="<?php echo $lng?>" />
    <input type="text" name="lat" id="lat" value="<?php echo $lat?>" />
    <input type="submit" value="确定"/>
</form>
<div id='container' style="width:auto; height:900px"></div>
   <script type="text/javascript">
    var map = new BMap.Map("container");
	var lng = document.getElementById('lng').value;
	var lat = document.getElementById('lat').value;
	var point = new BMap.Point(lng,lat);    
	map.centerAndZoom(point,18);
	map.addEventListener("click",function(e){
		var lng = e.point.lng;
		var lat = e.point.lat;
		var marker = new BMap.Marker(new BMap.Point(lng,lat));// 创建标注
		map.addOverlay(marker);// 将标注添加到地图
		marker.enableDragging();           // 可拖拽
		document.getElementById('lng').value = e.point.lng;
		document.getElementById('lat').value = e.point.lat;
		marker.addEventListener("dragend",function(e){
			var p = e.target;
			document.getElementById('lng').value = p.getPosition().lng;
			document.getElementById('lat').value = p.getPosition().lat;
		});
	});    
	map.addControl(new BMap.MapTypeControl());  
 	map.addControl(new BMap.NavigationControl());    
	map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
	map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
</script>
</body>
</html>