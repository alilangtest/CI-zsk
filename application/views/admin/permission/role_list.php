<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="/public/layui/layui.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css?v=1"  media="all">
<script>
$(document).ready(function() {
	layui.use(['table','laytpl'], function(){
		var table = layui.table;
		table.on('tool(table)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
			var data = obj.data; //获得当前行数据
			var layEvent = obj.event; //获得 lay-event 对应的值
			var tr = obj.tr; //获得当前行 tr 的DOM对象
			if(layEvent === 'rights')//管理权限
			{
				layer.open({
					title:'管理权限',
					area: ['1000px', '700px'],
					type: 2, 
					content: '/admin/permission/role_right/'+data.id //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
		  		}); 
			}
			else if(layEvent === 'del')//删除
			{ 
				layer.confirm('真的要删除么，此操作不可逆。', function(index){
					$.post('/admin/permission/do_role_delete',"id="+data.id,function(data){
						if(data == 'ok')
						{
							layer.alert('删除成功',{icon: 8},function(index)
			    	    	{
			        	    	layer.close(index);
			        	    });
						}
						else
							layer.alert('删除失败',{icon: 8},function(index)
			    	    	{
			        	    	layer.close(index);
			        	    });
					},'text');
				    obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
				    layer.close(index);
				    //向服务端发送删除指令
				});
			} 
			else if(layEvent === 'edit')//编辑
			{ 
				layer.open({
					title:'修改角色',
					area: ['1000px', '700px'],
					type: 2, 
					content: '/admin/permission/role_update/'+data.id //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
		  		});
				//同步更新缓存对应的值
			  	obj.update({
			    	username: '123'
			    	,title: 'xxx'
			  	});
			}
		});
	});
	$('#refresh').click(function() {
    	window.location.reload();
	});
	$('#all').click(function() {
    	window.location.href='/admin/permission';
	});
    $('#add').click(function() {
		layer.open({
			title:'新增角色',
			area: ['800px', '500px'],
			type: 2, 
			content: '/admin/permission/role_add' //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
  		}); 
	});




	
	//修改客户信息
	$('#content #table .tr .edit').click(function(event) {
		event.preventDefault();
		var id=$(this).attr('href');
		if (id=='' || isNaN(id)) {
			wintq('ID参数不正确',3,1000,1,'');
			return false;
		}else {
			popload('查看/修改角色信息',860,500,'/admin/permission/role_update/'+id);
			addDiv($('#iframe_pop'));
			popclose();
		}
	});

	$('#keyword').blur(function() {
		if($(this).val() == '')
		{
			$(this).val('请输入关键词');
		}
	});
	$('#keyword').focus(function() {
		if($(this).val() == '请输入关键词')
		{
			$(this).val('');
		}
	});
	
});
</script>
</head>
<body>
<div id="content">
	<blockquote class="layui-elem-quote">
       	<a href="javascript:void(0);" class="layui-btn layui-btn-sm" id="refresh">
			<i class="layui-icon">&#x1002;</i> 刷新页面
		</a>
       	<a href="javascript:void(0);" class="layui-btn layui-btn-sm" id="all">
			<i class="layui-icon">&#xe63c;</i> 全部信息
		</a>
       	
       	<a href="javascript:void(0);" class="layui-btn layui-btn-sm" id="add">
			<i class="layui-icon">&#xe61f;</i> 新增
		</a>
<!--		<a href="javascript:;" class="layui-btn layui-btn-sm" id="search">-->
<!--			<i class="layui-icon">&#xe640;</i> 删除-->
<!--		</a>-->
<!-- 		<a href="javascript:;" class="layui-btn layui-btn-sm" id="search"> -->
<!-- 			<i class="layui-icon">&#xe615;</i> 搜索 -->
<!-- 		</a> -->
    </blockquote>
    <table id="table" lay-filter="table" class="layui-table" lay-data="{url:'/admin/permission/get_role', page:true, id:'test',limits:[15,20,30,50], limit:15}">
    	<thead>
    	<tr>
<!--    		<th lay-data="{checkbox:true}"></th>-->
        	<th lay-data="{field:'id', width:80, sort: true}">编号</th>
            <th lay-data="{field:'name', width:180}">角色名称</th>
            <th lay-data="{field:'type', width:180}">角色位置</th>
            <th lay-data="{field:'addtime', width:180}">增加时间</th>
            <th lay-data="{fixed: 'right', width:250, align:'left', toolbar: '#barDemo'}">操作</th>
        </tr>
        </thead></table>
</div>
<script type="text/html" id="barDemo">
	{{#  if(d.id > 2){ }}
		<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="rights">权限</a>  
		<a class="layui-btn layui-btn-xs" lay-event="del">删除</a>
	{{#  }else{ }}
		无
	{{#  } }}
</script>
</body>
</html>