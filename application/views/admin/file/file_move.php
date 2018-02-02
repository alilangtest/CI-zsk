<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="/public/layui/layui.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.core.min.js"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.excheck.min.js"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.exedit.min.js"></script>
<link rel="stylesheet" href="/public/js/zTree_v3/css/demo.css?v=51" type="text/css">
<link rel="stylesheet" href="/public/js/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script>
var layer = null ;
var zTreeObj;
var setting = {
	data: {
		simpleData: {
			enable: true
		}
	},
	edit:{
		enable: true,
		showRemoveBtn: false,
		showRenameBtn: false,
		drag: {
			isCopy: false,
			isMove: false
		}
	},
	callback: {
		beforeRename:beforeRename
	}
};

$(document).ready(function() {
	layui.use(['table'], function(){
		layer = layui.layer;
	});
	zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
	var nodes = zTreeObj.getNodes();
	zTreeObj.expandNode(nodes[0], true);

	var node = zTreeObj.getNodeByParam('id', 0);//获取id为0的点  
	zTreeObj.selectNode(node);//选择第一个节点  
	$('#add').click(function() {
		addTreeNode();
	});

	$('#submit').click(function() {
		var nodes = zTreeObj.getSelectedNodes();
		$.post('/admin/file/files/do_move','sel_rowids=<?php echo $sel_rowids;?>&tar_pid='+nodes[0].id,function(data){
			layer.alert(data,{icon: 8},function(index)
	    	{
				layer.close(index);
				window.parent.window.reloadData(<?php echo $dirid;?>);
    	    });
		});
	});
});
var zNodes = [
    	{"id":"0", "pId":-1, "name":"全部文件",icon:"/public/images/file/folder.png","chkDisabled":true,},
    	<?php 
    		$str="";
    		foreach ($dirs as $d)
    		{
    			
    			$isParent='true';
    			$str.='{"id":'.$d['id'].', "pId":"'.$d['parentid'].'","chkDisabled":false, "name":"'.$d['name'].'",isParent:'.$isParent.'},';	
    		}
    		$str=trim($str,",");
    		echo $str;
    	?>
];

function addTreeNode() {
	var newNode={ name:"新建文件夹",isParent:true};
	var treeNode = zTreeObj.getSelectedNodes()[0];
	if (treeNode) {
		newNode.checked = treeNode.checked;
		treeNode=zTreeObj.addNodes(treeNode, newNode);
		zTreeObj.editName(treeNode[0]);
	}
}

function beforeRename(treeId, treeNode, newName, isCancel) {
	if(treeNode.name == newName)
		return false;
	
}
</script>
</head>
<body>
<div id="content" style="padding-bottom:20px;">
    <div id="treeDemo" class="ztree" style="margin-left: 12px;height:270px; overflow:auto"></div>

	<div style="margin: 15px 0 0 12px;">
<!-- 		<a href="javascript:void(0);" class="layui-btn" id="add"> -->
<!-- 			<i class="layui-icon">&#xe61f;</i> 新建文件夹 -->
<!-- 		</a> -->
		<div style="float:right;margin-right:20px;"> 
			<a href="javascript:void(0);" class="layui-btn" id="submit">
				确定
			</a>
		</div>
		
	</div>
	
</div>
</body>
</html>