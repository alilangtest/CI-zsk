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
<style type="text/css">
    .layui-form-label {
        width: 89px;
    }
</style>
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
	}
};

$(document).ready(function() {
	layui.use(['table','form'], function(){
		layer = layui.layer;
		var form = layui.form;
		form.on('radio', function(data){
// 		    console.log(data.elem); //得到radio原始DOM对象
			if(data.value==0){
				$("#treeDemo").hide();
			} else{
				$("#treeDemo").show();
			}
		}); 
	});
	zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
	var nodes = zTreeObj.getNodes();
	zTreeObj.expandNode(nodes[0], true);

	$('#submit').click(function() {
		
		var tar_id='-'; 
		var target = $("input[name='target']:checked").val();
		if(target==1){
			var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
			var nodes = treeObj.getSelectedNodes();
			if(nodes==null||nodes.length < 1){
				layer.alert("请选择恢复的目标文件夹！");
				return;
			}
			tar_id = nodes[0].id;
		}
		$.post('/admin/file/recycle/do_recovery','tar_id='+tar_id+'&id_type=<?php echo $id_type;?>',function(data){
			if(data=='ok'){
				layer.alert("恢复成功！",{icon: 8},function(index)
		    	{
					layer.close(index);
	    	    });
			} else{
				layer.alert(data);
			}
			
		});
	});
	
	$("#treeDemo").hide();
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
</script>
</head>
<body>
<div id="content" style="padding-bottom:10px;">
    <form class="layui-form" action="">
		<div class="layui-form-item">
            <label class="layui-form-label">目标文件夹：</label>
            <div class="layui-input-block">
                <input type="radio" name="target" value="0" title="原文件夹" checked>
                <input type="radio" name="target" value="1" title="其他文件夹">
            </div>
       	</div>
	</form>
	<div id="treeDemo" class="ztree" style="margin: 0 0 10px 12px;height:200px; overflow:auto"></div>
	<div style="margin: 15px 0 0 12px;">
		<div style="float:right;margin-right:20px;"> 
			<a href="javascript:void(0);" class="layui-btn" id="submit">
				确定
			</a>
		</div>
	</div>
</div>
</body>
</html>