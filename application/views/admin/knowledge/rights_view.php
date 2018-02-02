<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.core.min.js"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.excheck.min.js"></script>
<script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.exedit.min.js"></script>
<script src="/public/layui/layui.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
<link rel="stylesheet" href="/public/js/zTree_v3/css/demo.css?v=15" type="text/css">
<link rel="stylesheet" href="/public/js/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script>
var layer = null ;
var form = null ;
var zTreeObj,rMenu;
var uzTreeObj;
var deptid='';
var userid='';
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
		onClick:zTreeOnClick
// 		beforeRename:beforeRename,
// 		onRightClick: OnRightClick
	}
};
var usetting = {
		check: {
            enable: true
        },
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
			onClick: uzTreeOnClick
		}
	};
var zNodes = [
    	{"id":"a1", "pId":0, "name":"山东云天安全技术有限公司",icon:"/public/images/ztree/home2.png","chkDisabled":true,},
    	<?php
    		$str="";
    		foreach ($depts as $d)
    		{
    			if($d['ding_parentid']=='0'){
    			    continue;
    			}
    			$str.='{"id":"'.$d['ding_dept_id'].'", "pId":"'.$d['ding_parentid'].'","chkDisabled":false, "name":"'.$d['name'].'"},';
    		}
    		$str=trim($str,",");
    		echo $str;
    	?>
];
var uzNodes = [
			{"id":0, "pId":-1, "name":"所有人员",icon:"/public/images/ztree/home2.png","chkDisabled":false,},
            	<?php
            		$str="";
            		foreach ($users as $u)
            		{
            			$str.='{"id":"'.$u['ding_userid'].'","pId":0,"chkDisabled":false, "name":"'.$u['name'].'"},';
            		}
            		$str=trim($str,",");
            		echo $str;
            	?>
        ];
$(document).ready(function() {
	zTreeObj = $.fn.zTree.init($("#tree"), setting, zNodes);
	zTreeObj.expandAll(true);

	uzTreeObj = $.fn.zTree.init($("#utree"), usetting, uzNodes);
	uzTreeObj.expandAll(true);
	layui.use(['layer','form'], function(){
		layer = layui.layer;
	  	form = layui.form;
	});
	$("#operation").hide();
});

function save(){
	var treeObj=$.fn.zTree.getZTreeObj("tree");
    var nodes=treeObj.getSelectedNodes();
    if(nodes.length<1){
    	layer.alert('请选择一个部门！');
    	return;
    }
    var deptid = nodes[0].id;
    var utreeObj=$.fn.zTree.getZTreeObj("utree");
    var unodes=utreeObj.getSelectedNodes();
//     var unodes=utreeObj.getCheckedNodes(true);
    if(unodes.length<1){
    	layer.alert('请至少选择一个用户！');
    	return;
    }
    var userid = unodes[0].id;
    var operids = "";
    $('input:checkbox[name=oper]:checked').each(function(i){
    	operids += $(this).val()+',';
    });
    // console.log(operids);
    // return false;
    //ty表示的是目录 1：知识分类 2：部门知识 3：公司共享 4：回收站
    //var ty = $('input[name="ty"]:checked').val();
    if(operids == ""){
        layer.alert('未设置任何权限分配，毫无意义！', {icon: 5,skin: 'layer-ext-moon' });
        return false;
    } else{
    	$.post("/admin/knowledge/intellectual_rights/do_rights","deptid="+deptid+"&userid="+userid+"&operids="+operids,function(data){
	        if(data.status==0){
	        	layer.alert(data.msg, {icon: 6,skin: 'layer-ext-moon' });
	        }
            if(data.status==1){
                // initUserTree(deptid);
	        	layer.alert(data.msg, {icon: 5,skin: 'layer-ext-moon' });
	        }
		},'json');
    }


}

function zTreeOnClick(event, treeId, treeNode)
{
	deptid = treeNode.id;
	initUserTree(treeNode.id);
	if(userid!=""){
		initCheckbox();
	}
}

function uzTreeOnClick(event, treeId, treeNode)
{
	$("#operation").show();
	userid = treeNode.id;
	if(deptid!=""){
		initCheckbox();
	}
}

function initUserTree(deptid){
	$.post("/admin/knowledge/intellectual_rights/get_users","id="+deptid,function(data){
		var zTree_obj = $.fn.zTree.getZTreeObj("utree");
		zTree_obj.checkAllNodes(false);
		if(data.length>0){
            for(var i=0;i<data.length;i++){
            	var node = zTree_obj.getNodeByParam("id", data[i].ding_userid, null);
    			if(node!=null){
    				zTree_obj.checkNode(node, true, true);
    			}
			}
		}

	},'json');
}

function initCheckbox(){
	if(userid==0){
		layer.alert('不能选择所有人员！');
		return;
	}
	if(deptid==""||userid==""){
		layer.alert('至少选择一个部门和人员！');
		return;
	}
    // $("#operation").hide();

	$.post("/admin/knowledge/intellectual_rights/get_operation","deptid="+deptid+"&userid="+userid,function(data){
		console.log(data);
		$("input[name='oper']").each(function(){
			if($(this).is(":checked"))
				$(this).prop("checked",false);
		});

		if(data.length>0){
            for(var i=0;i<data.length;i++){
            	// $("input:checkbox[value='["+data[i].operation_id+"]']").prop("checked",true);
				$("input:checkbox[value='["+data[i].ty+"]["+data[i].operation_id+"]']").prop("checked",true);
			}
		}
		form.render(); //更新全部
	},'json');
}

var i=0;
//用按钮查询节点
function search(){
	var treeObj=$.fn.zTree.getZTreeObj("utree");
    var keywords=$("#keyword").val();
    var nodes = treeObj.getNodesByParamFuzzy("name", keywords, null);
    if (nodes.length>0) {
        if(i >= nodes.length){
           i = 0 ;
        }
        treeObj.selectNode(nodes[i]);
       	i++;
    }
}

function change(){
	i=0;
}
</script>
<style type="text/css">
    .layui-form-label { width:82px !important; text-align:left;}
    .content_left{width: 300px;height: 700px;margin-top:10px;float:left; border: 1px solid #ccc;}
	.content_right{width: 300px;height: 700px;margin-top:10px;float:left;margin-left:20px; border: 1px solid #ccc;background-color: #f0f6e4;}
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
<div id="content">
	<div class="content_left">
		<ul id="tree" class="ztree"></ul>
	</div>
	<div class="content_right">
		<div>
			<input id="keyword" type="text" style="height:25px;width:230px;margin:3px 0 0 5px;" placeholder="请输入...">
            <input type="button" onclick="search();" class="layui-btn layui-btn-sm" value="搜索"  />
        </div>
    	<ul id="utree" class="ztree" style="height:650px;" ></ul>
    </div>
	<div id="operation" style="float:left;width:420px;" >
		<div>
			<form class="layui-form" lay-filter="cbForm"  action="">
            	<div class="layui-form-item" pane="" style="clear:both;" >
                    <label class="layui-form-label" style="width:50px;" >知识分类：</label>
                    <div class="layui-input-block" style="margin-left:10px;">
						<input type="checkbox"  name="oper" value="[1][1]"  lay-skin="primary" title="新增">
                        <input type="checkbox"  name="oper" value="[1][2]"  lay-skin="primary" title="删除">
                        <input type="checkbox"  name="oper" value="[1][3]"  lay-skin="primary" title="修改">
                        <!-- <input type="checkbox"  name="oper" value="[1][4]"  lay-skin="primary" title="分享">
                        <input type="checkbox"  name="oper" value="[1][5]"  lay-skin="primary" title="恢复"> -->
                    </div>
                </div>

                <div class="layui-form-item" pane="" style="clear:both;" >
                    <label class="layui-form-label" style="width:50px;" >部门知识：</label>
                    <div class="layui-input-block" style="margin-left:10px;">
					<input type="checkbox"  name="oper" value="[2][1]"  lay-skin="primary" title="新增">
					<input type="checkbox"  name="oper" value="[2][2]"  lay-skin="primary" title="删除">
					<input type="checkbox"  name="oper" value="[2][3]"  lay-skin="primary" title="修改">
					<input type="checkbox"  name="oper" value="[2][4]"  lay-skin="primary" title="分享">
					<!-- <input type="checkbox"  name="oper" value="[2][5]"  lay-skin="primary" title="恢复"> -->
                    </div>
                </div>

                <div class="layui-form-item" pane="" style="clear:both;" >
                    <label class="layui-form-label" style="width:50px;" >公司分享：</label>
                    <div class="layui-input-block" style="margin-left:10px;">
					<!-- <input type="checkbox"  name="oper" value="[3][1]"  lay-skin="primary" title="新增"> -->
					<input type="checkbox"  name="oper" value="[3][2]"  lay-skin="primary" title="删除">
					<!-- <input type="checkbox"  name="oper" value="[3][3]"  lay-skin="primary" title="修改"> -->
					<!-- <input type="checkbox"  name="oper" value="[3][4]"  lay-skin="primary" title="分享"> -->
					<!-- <input type="checkbox"  name="oper" value="[3][5]"  lay-skin="primary" title="恢复"> -->
					<input type="checkbox"  name="oper" value="[3][6]"  lay-skin="primary" title="删除消息">
                    </div>
                </div>

                <div class="layui-form-item" pane="" style="clear:both;" >
                    <label class="layui-form-label" style="width:50px;" >回收站：</label>
                    <div class="layui-input-block" style="margin-left:10px;">
					<!-- <input type="checkbox"  name="oper" value="[4][1]"  lay-skin="primary" title="新增"> -->
					<input type="checkbox"  name="oper" value="[4][2]"  lay-skin="primary" title="删除">
					<!-- <input type="checkbox"  name="oper" value="[4][3]"  lay-skin="primary" title="修改">
					<input type="checkbox"  name="oper" value="[4][4]"  lay-skin="primary" title="分享"> -->
					<input type="checkbox"  name="oper" value="[4][5]"  lay-skin="primary" title="恢复">
                    </div>
                </div>

								<div class="layui-form-item" pane="" style="clear:both;" >
										<label class="layui-form-label" style="width:50px;" >行为日志：</label>
										<div class="layui-input-block" style="margin-left:10px;">
												<input type="checkbox"  name="oper" value="[5][1]"  lay-skin="primary" title="删除">
										</div>
								</div>

            </form>
		</div>
		<div style="clear:both;">
        	<input type="button" onclick="save();" class="layui-btn layui-btn-sm" value="保存"  style="margin:5px 0 0 15px;" />
        </div>
	</div>
</div>
</body>
</html>
