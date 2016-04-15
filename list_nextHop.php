<html>
<head>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jtopo-0.4.8-min.js"></script> 
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
	var canvas = document.getElementById('canvas');
	var stage = new JTopo.Stage(canvas);
	var scene = new JTopo.Scene(stage);
	var host = new JTopo.Node("1");
	host.setImage('node.png'); 
	host.fontColor="0,0,0";
	scene.add(host);
	host.setLocation(100, 100);
	host.layout = {type:'tree',width:300,height:200};
	var nodelist = new Array();
	for(i=0;i<x.length;i++){
		var node = new JTopo.Node(x[i].getAttribute('nodeid'));
		node.setImage('node.png'); 
		node.fontColor="0,0,0";
		var canvas = document.getElementById('canvas');
		node.setLocation( (canvas.width-100) * Math.random(), (canvas.height-100) * Math.random());
		node.layout = {type:'tree',width:100,height:100};
		scene.add(node);
		nodelist.push(node);
	}
	for(y in nodelist){
		switch(nodelist[y].text){
		case('2'):nodelist[y].setLocation(100+100,100+100);break;
		case('3'):nodelist[y].setLocation(100+100,100+200);break;
		case('4'):nodelist[y].setLocation(100+100,100+300);break;
		case('5'):nodelist[y].setLocation(100+100,100);break;
		case('6'):nodelist[y].setLocation(100+300,100-100);break;
		case('7'):nodelist[y].setLocation(100-50,100-100);break;
		case('8'):nodelist[y].setLocation(100-50,100+100);break;
		case('9'):nodelist[y].setLocation(100+300,100+100);break;
		case('10'):nodelist[y].setLocation(100+300,100+200);break;
		case('11'):nodelist[y].setLocation(100+300,100+300);break;
		case('12'):nodelist[y].setLocation(100+100,100-100);break;
		case('13'):nodelist[y].setLocation(100-100,100+100);break;
		case('14'):nodelist[y].setLocation(100-50,100);break;
		}	
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
	}
	for(l=0;l<x.length;l++){
		scene.add(new JTopo.Link(nodelist[l],nextlist[l]));	
	}
	JTopo.layout.layoutNode(scene, host, true);
	stage.play(scene);	
}
);
</script>
</head>
<body>
<canvas id = 'canvas' width = "900" height="500" style="background-color:#EEEEEE;border:1px solid#444;">

</canvas>
</body>
</html>