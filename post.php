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
<link rel="stylesheet" type="text/css" href="css/spinner.css">
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
	    
		<div id="left_ul" style="float:left; width:300px;padding-bottom: 2%">
	        <ul>
		        <li>
		        节点ID:<span id="id"></span>
		        </li>
		        <li>
		        节点类型:<span id="type"></span>
		        </li>
		        <li>
		        下一跳节点ID:<span id="next"></span>
		        </li>
		        <li>
		        电压:<span id="vol"></span>
		        </li>
	      	</ul>
	    </div>

	    <div id="right_ul" style="width:300px; float:left;padding-bottom: 2%">
	        <ul>
		        <li>
		        光照强度:<span id="lig"></span>
		        </li>
		        <li>
		        温度:<span id="tem"></span>
		        </li>
		        <li>
		        湿度:<span id="hum"></span>
		        </li>
		        <li>
		        最后更新时间:<span id="last_time"></span>
		        </li>
	        </ul>
	    </div>
	    <div class="spinner" style="float:left;">
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
			<br />
		    <div id='hisdata' style="min-width:700px;height:400px"></div>
		    <br />
		</div>
  	</div><!-- End Content -->

	<div id="footer">	
		<p>Copyright &copy;<b>LLC</b></p>
	</div><!-- End Footer -->
</div><!-- End Wrapper -->
<!--loader-->
    <div id="loader" class="loader" style="visibility:hidden">
		<div class="loader-inner">
			<div class="loader-line-wrap">
				<div class="loader-line"></div>
			</div>
			<div class="loader-line-wrap">
				<div class="loader-line"></div>
			</div>
			<div class="loader-line-wrap">
				<div class="loader-line"></div>
			</div>
			<div class="loader-line-wrap">
				<div class="loader-line"></div>
			</div>
			<div class="loader-line-wrap">
				<div class="loader-line"></div>
			</div>
		</div>
	</div>
    
<script type="text/javascript">	
var datetype = $("#date_type").val();
var datatype = $("#data_type").val();
var loader = document.getElementById("loader");
var showload = function(){
	loader.style.visibility = "visible";
}
var hideload = function(){
	loader.style.visibility = "hidden";
}
var getline = function(callback){
	$.get(
		"history.php",
		{nodeid:<?php echo $_GET['id'] ?>,datatype:datatype,datetype:datetype},
		function(response){
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
	if(typeof(callback)==="function"){
		callback();
	}
}
var infomation = function(){
	var url = "node_info.php";
	var data = {"nodeid":<?php echo $_GET['id'] ?>};
	var success = function(response){
		var response = JSON.parse(response);
		$("#id").html(response['id']);
		$("#type").html(response['nodetype']);
		$("#next").html(response['nexthop']);
		$("#tem").html(response['temperature']);
		$("#hum").html(response['humitity']);
		$("#lig").html(response['light']);
		$("#vol").html(response['voltage']);
		$("#last_time").html(response['last_time']);
	};
	$.get(url, data, success);
	setInterval(function(){$.get(url, data, success)},60000);
}
$(function(){
	getline(showload);
	infomation();
	$("button").on('click',function(){
		datetype = $("#date_type  :selected").val();
		datatype = $("#data_type  :selected").val();
		getline(showload);
	});
	$(".loader").ajaxStop(hideload);
})

</script>

</body>

</html>
