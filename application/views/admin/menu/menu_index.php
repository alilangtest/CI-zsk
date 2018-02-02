<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>菜单管理</title>
<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.core.min.js"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.excheck.min.js"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.exedit.min.js"></script>
<script src="/public/layui/layui.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
<link rel="stylesheet" href="/public/js/zTree_v3/css/demo.css?v=15" type="text/css">
<link rel="stylesheet" href="/public/js/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">

<script type="text/javascript">

	var layer = null ;
	var zTreeObj,rMenu;
    var setting = {
		data: {
			simpleData: {
				enable: true
			}
		},
		edit:{
			enable: true,
			removeTitle: "删除节点",
			renameTitle: "编辑名称",
			showRemoveBtn: false,
			showRenameBtn: false,
			drag: {
				isCopy: false,
				isMove: false
			}
		},
		callback: {
			onClick:zTreeOnClick,
			beforeRename:beforeRename,
			onRightClick: OnRightClick
		}
    };
    var zNodes = [
        	{"id":"0", "pId":-1, "name":"系统菜单",icon:"/public/images/ztree/home2.png","chkDisabled":true,},
        	<?php 
        		$str="";
        		foreach ($menus as $d)
        		{
        			
        			$isParent='true';
        			if($d['level'] == 2)
        				$isParent='false';
        			$str.='{"id":'.$d['id'].', "pId":"'.$d['parentid'].'","chkDisabled":false, "name":"'.$d['name'].'",isParent:'.$isParent.',level:'.$d['level'].'},';	
        		}
        		$str=trim($str,",");
        		echo $str;
        	?>
    ];
    
    $(document).ready(function() {
    	
    	rMenu = $("#rMenu");
    	zTreeObj = $.fn.zTree.init($("#tree"), setting, zNodes);
    	zTreeObj.expandAll(true);
    	layui.use(['layer'], function(){
			layer = layui.layer;
		});
    });
    
    function zTreeOnClick(event, treeId, treeNode)
    {
    	$("#name").val(treeNode.name);
    	$("#id").val(treeNode.id);
		$.post("/admin/menu/get_menu_detail","id="+treeNode.id,function(data){
			$("#url").val(data.url);
			$("#icon").val(data.icon);
			$("#sort").val(data.sort);
			$("#content_right").show();
		},'json');
    }

    function OnRightClick(event, treeId, treeNode) {
    	if (!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
    		zTreeObj.cancelSelectedNode();
    	} else if (treeNode) {
    		zTreeObj.selectNode(treeNode);
    		if(treeNode.level==2){
    			showRMenu("leaf",event.clientX-10, event.clientY);
        	} else{
        		showRMenu("node",event.clientX-10, event.clientY);
            }
    		
    	}
    }

    function showRMenu(type, x, y) {
    	$("#rMenu ul").show();
    	if(type=="node"){
    		$("#m_add").show();
        } else{
        	$("#m_add").hide();
        }
    	$("#m_edit").show();
    	rMenu.css({"top":y+"px", "left":x+"px", "visibility":"visible"});
    	$("body").bind("mousedown", onBodyMouseDown);
    }

    function onBodyMouseDown(event){
    	if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length>0)) {
    		rMenu.css({"visibility" : "hidden"});
    	}
    }

    function addTreeNode(is_box) {
    	hideRMenu();
    	var newNode={ name:"新节点",isParent:true};
    	var treeNode = zTreeObj.getSelectedNodes()[0];
    	if (treeNode) {
    		newNode.checked = treeNode.checked;
    		treeNode=zTreeObj.addNodes(treeNode, newNode);
    		zTreeObj.editName(treeNode[0]);
    	}
    }

    function editTreeNode() {
    	hideRMenu();
    	var checkedNode=zTreeObj.getSelectedNodes()[0];
    	zTreeObj.editName(checkedNode);
    }

    function hideRMenu() {
    	if (rMenu) rMenu.css({"visibility": "hidden"});
    	$("body").unbind("mousedown", onBodyMouseDown);
    }

    function beforeRename(treeId, treeNode, newName, isCancel) {
    	if(treeNode.name == newName)
    		return true;
    	var url="/admin/menu/do_update_insert";
    	var parentNode=treeNode.getParentNode();
    	
    	$.post(url,'id='+treeNode.id+"&name="+newName+"&pid="+parentNode.id,function(data){
    		if(data > 0)
    		{
    			layer.alert('操作成功',{icon: 8},function(index)
    	    	{
        	    	layer.close(index);
        	    	window.location.reload();
        	    });
    			
    		}	
    		else	
    		{
    			layer.alert('操作失败',{icon: 8},function(index)
    	    	{
        	    	layer.close(index);
        	    	window.location.reload();
        	    });
    		}
    	},'text');
    }
    
    function save()
    {
    	$.post("/admin/menu/save_menu",$("#input_form").serialize(),function(data){
    		if(data == "ok")
    		{
    			layer.alert('操作成功',{icon: 8},function(index)
    	    	{
        	    	layer.close(index);
        	    	window.location.reload();
        	    });
    		}
    	},'text');
    }

    function do_del()
    {
    	layer.confirm('确认要删除该菜单吗？删除后不可恢复！', {icon: 3, title:'提示'}, function(index){
    		$.post("/admin/menu/del_menu","id="+$("#id").val(),function(data){
        		layer.alert(data,{icon: 8},function(index)
    	    	{
        	    	layer.close(index);
        	    	window.location.reload();
        	    });
        	},'text');
  		});
    }
</script>
<style type="text/css">
input, textarea, select {
    font-size: 12px;
    text-indent: 4px;
    color: #111;
}
	.content_left{width: 300px;height: 700px;margin-top:10px;float:left; border: 1px solid #ccc;}
	.content_right{width: 600px;height: 700px;margin-top:10px;margin-left:20px; float:left; border: 1px solid #ccc;background-color: #f0f6e4;display: none;}
	div#rMenu {position:absolute; visibility:hidden; top:0; background-color: #555;text-align: left;padding: 2px;}
	div#rMenu ul li{
		margin: 1px 0;
		padding: 0 5px;
		cursor: pointer;
		list-style: none outside none;
		background-color: #DFDFDF;
		display: none;
	}
    #content .ctext {
        width: 400px;
    }
    #content #table { width:99%; height:auto; margin-top:15px; border-collapse:collapse; border:none; }
#content #table tr { height:28px; line-height:28px; }
#content #table tr th { text-align:center; background:#333; border:solid 1px #333; color:#fff }
#content #table .tr { height:30px; line-height:30px; background:#fff; }
#content #table .tr td a { text-decoration:none; color:#333; }
#content #table .tr td a:hover { text-decoration:underline; color:#090}
#content #table .tr2 { background:#f1f1f1 }
#content #table .tr:hover { background:#e1f4ff; }
#content #table .tr td { text-align:left; text-indent:5px; border:none; }
#content #table .tr .add { position:relative; top:3px; cursor:pointer; margin-left:8px; }

/*多颜色描述样式*/
#content #table .tr td .de1 { color:#390}
#content #table .tr td .de2 { color:#c30000}

#content #table .tr .tc { text-align:center; text-indent:0; }
#content #table .tr .tc a { text-decoration:none; color:#333; }
#content #table .tr .tc a:hover { color:#f00; text-decoration:underline;  }
#content #table .tr .tc img { padding:0px 6px; }
#content #table .tr .tl { text-align:left; text-indent:8px; }
#content #table .tr .tl img { padding:0px 6px; position:relative; top:4px; }
#content #table .tr .fixed_w { width:100px; }
#content #table .tr .fixed_w .oper { padding:0px 6px; color:#060; }
#content #table .tr font { color:#f00 }

/*表格样式1*/
#content #client { width:800px; height:auto; margin:0 auto;  margin-top:15px; border-collapse:collapse; border:solid 1px #ccc; }
#content #client .tr { line-height:38px; background:#fff; }
#content #client .tr2 { background:#f1f1f1 }
#content #client .tr td { text-align:left; text-indent:8px; border:solid 1px #ccc; }
#content #client .tr td.left { width:130px; background:#eee; text-align:right; text-indent:0; padding-right:4px; }
#content #client .tr td.center { width:130px; background:#eee; text-align:center; text-indent:0; padding-right:4px; }
#content #client .tr font { margin-left:15px; color:#666; }
    
#content .ctext {
    width: 400px;
    height: 24px;
    line-height: 24px;
    background: url(/public/images/textbg.jpg) repeat-x left top;
    border: solid 1px #ccc;
    font-family: "宋体";
}

ul.ztree {
    height: 680px;
}
</style>
</head>
<body>
<div id="content" style="width: 930px;">
	<div class="content_left">
		<ul id="tree" class="ztree"></ul>
	</div>
	<div class="content_right" id="content_right">
	<form id="input_form">
    	<table id="client" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0" style="width: 580px;">
    		
    		<tr class="tr">
            	<td class="left">*&nbsp;名称：</td>
            	<td colspan="3" ><input name="name" id="name" maxlength="50" type="text" class="ctext" /></td>
            </tr>
        	<tr class="tr">
            	<td class="left">*&nbsp;url：</td>
            	<td colspan="3"><input name="url" id="url" maxlength="100" type="text" class="ctext" /></td>
            </tr>
        	<tr class="tr">
            	<td class="left">*&nbsp;菜单图标：</td>
            	<td colspan="3" ><input name="icon" id="icon" maxlength="100" type="text" class="ctext" /></td>
            </tr>
            <tr class="tr">
            	<td class="left">*&nbsp;排序：</td>
            	<td colspan="3" ><input name="sort" id="sort" maxlength="100" type="text" class="ctext" /></td>
            </tr>
        </table>
        <table style="width:580px; height:auto; margin:0 auto;  margin-top:0px; border-collapse:collapse; border:0px">
        	<tr>
        		<td align="right">
        			<input type="hidden" name="id" id="id" />
        			<input type="button" onclick="save();" class="layui-btn" value="保存"  style="margin:20px 0 0 30px;" />
        		    <input type="button" onclick="do_del();" class="layui-btn layui-btn-danger" value="删除" style="margin:20px 0 0 30px;" /> 			
        		</td>
        	</tr>
        </table>
    </form>
	</div>
	
</div>
<div id="rMenu">
	<ul>
		<li id="m_add" onclick="addTreeNode(0);">增加下级</li>
		<li id="m_edit" onclick="editTreeNode(true);">编辑名字</li>
	</ul>
</div>
</body>
</html>