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
var layer;
var zTreeObj,rMenu;
var ztree_tId ='';
var setting = {
		async: {
			enable: true,
			type: "post",
			url: "/admin/org/get_son",
			autoParam: ["id"],
			contentType: "application/x-www-form-urlencoded",
			dataFilter: filter,
			dataType: "text",
			otherParam: []
		},
		check: {
			enable: true,
			chkStyle: "checkbox"
		},
		data: {
			simpleData: {
				enable: true
			}
		},
		callback: {
			onClick: zTreeOnClick
		}
};
function filter(treeId, parentNode, childNodes) {
	if (!childNodes) return null;
	for (var i=0, l=childNodes.length; i<l; i++) {
		childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
	}
	return childNodes;
}
function zTreeOnClick(event, treeId, treeNode)
{

	
}
var zNodes = [
            	{"id":"0", "pId":-1, "name":"系统菜单",icon:"/public/images/ztree/home2.png","chkDisabled":true,},
            	<?php 
            		$str="";
            		foreach ($menus as $d)
            		{
            			$check="";
            			if(strpos($role_menus_ids,$d['id']) > 0)
            				$check=",checked:true";
            			$isParent='true';
            			if($d['level'] == 2)
            				$isParent='false';
            			$str.='{"id":'.$d['id'].', "pId":"'.$d['parentid'].'","chkDisabled":false, "name":"'.$d['name'].'",isParent:'.$isParent.$check.'},';	
            		}
            		$str=trim($str,",");
            		echo $str;
            	?>
            ];
$(document).ready(function() {
	layui.use(['table'], function(){
		layer = layui.layer;
	});
	zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
	var nodes = zTreeObj.getNodes();
	zTreeObj.expandAll(true);
	var $client = $('#client');
	$('#qd').click(function() {
		var nodes = zTreeObj.getCheckedNodes(true);
		var ids="";
		for (var i=0, l=nodes.length; i<l; i++) 
		{
			ids+=nodes[i].id+",";
		}
		$.post('/admin/permission/do_role_menu_update', "role_id=<?php echo $this->role->id;?>&menu_ids="+ids,function(data){
			if(data == 'ok')
				layer.alert('修改成功',{icon: 8},function(index)
    	    	{
        	    	layer.close(index);
        	    	window.location.reload();
        	    });
			else
				layer.alert('修改失败',{icon: 8},function(index)
    	    	{
        	    	layer.close(index);
        	    	window.location.reload();
        	    });
		},'text');
	});
});
</script>
</head>
<body>
<div id="content" style="padding-bottom:20px;">
    
    <input name="id" id="id" type="hidden"  value="<?php echo $this->role->id;?>"/>
    <table class="layui-table">
    	<tr class="tr">
        	<th class="left">角色名称：</th>
        	<td colspan="3"><?php echo $this->role->name;?></td>
        	<th class="left">角色位置：</th>
        	<td colspan="3"><?php echo $this->role->type == 2?"后台":"前台";?></td>
        </tr>
    </table>
    <ul id="treeDemo" class="ztree" style="float: left;margin-left: 12px;"></ul>
    <div style="width:100px;  margin-top:507px;margin-left:50px; border:0px;float: left;">
    	<input type="button" id="qd" class="layui-btn" value="确定修改"  />
    </div>
</div>
</body>
</html>