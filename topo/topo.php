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
xmlhttp.open("GET","topo.xml",false);
xmlhttp.send();
xmlDoc=xmlhttp.responseXML;

var x=xmlDoc.getElementsByTagName("link");


</script>
<script type="text/javascript">
function node(name,x,y){
	var node = new JTopo.Node(name);
	node.setLocation(name);
}
$(document).ready(
function(){
	var canvas = document.getElementById('canvas');
	var stage = new JTopo.Stage(canvas);
	var scene = new JTopo.Scene(stage);
	var nodelist = new Array();
	linknum = 39;
	//创建节点
	for(i=1;i<=linknum;i++){
		var node = new JTopo.Node(i);
		nodelist.push(node);
	}

	//判断节点是否连接
	var selectnode = new Array();
	for(j=0;j<nodelist.length;j++){
		for(k=0;k<x.length;k++){
			if(x[k].getAttribute('firstnode')==nodelist[j].text){
				selectnode[x[k].getAttribute('firstnode')-1]=1;
				selectnode[x[k].getAttribute('lastnode')-1]=1;
			}	
		}	
	}
	//画出节点位置
	for(i=0;i<linknum;i++){
		/*if(selectnode[i]==0){
			nodelist[i].setImage('no.png');
			nodelist[i].setLocation( (canvas.width-450) * Math.random(), (canvas.height-100) * Math.random());
		}else{
			nodelist[i].setImage('node.png');
			nodelist[i].setLocation( (canvas.width-100) * Math.random(), (canvas.height-100) * Math.random());
		}*/

		nodelist[i].setLocation(10+(i%20)*50,10+(i/20)*100);
		nodelist[i].setImage('node.png');
		nodelist[i].fontColor="0,0,0";
		scene.add(nodelist[i]);
	}
	//画出节点间的连线
	var state1 = xmlDoc.getElementsByTagName("link_state1");

/*	for(l=0;l<x.length;l++){
		var nodelink = new JTopo.Link(nodelist[x[l].getAttribute('firstnode')-1],nodelist[x[l].getAttribute('lastnode')-1]);
		nodelink.text = x[l].getAttribute('impedance');
		nodelink.fontColor="0,0,0";
		scene.add(nodelink);
	}*/
	for(l = 0;l<state1.length;l++){
		if(state1[l].getAttribute('state')==1){
			var nodelink = new JTopo.Link(nodelist[x[l].getAttribute('firstnode')-1],nodelist[x[l].getAttribute('lastnode')-1]);
		}
/*		else{
			var nodelink = new JTopo.Link(nodelist[x[l].getAttribute('firstnode')-1],nodelist[x[l].getAttribute('lastnode')-1]);
			nodelink.dashedPattern = 5;
		}*/
		scene.add(nodelink);
	}

	var state2 = xmlDoc.getElementsByTagName("link_state2");
	
	stage.play(scene);	
}
);
</script>

</head>
<body>
<canvas id = 'canvas' width = "1388" height="900" style="background-color:#EEEEEE;border:1px solid#444;">

</canvas>
</body>
</html>