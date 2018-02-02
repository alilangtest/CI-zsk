<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="/public/layui/layui.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
<script>
$(document).ready(function() {
	var layer,form;
	layui.use(['table','form'], function(){
		layer = layui.layer;
		form = layui.form;
		form.on('submit(formDemo)', function(data){
			$.post('/admin/permission/do_role_add', data.field,function(data){
				if(data == 'ok')
				{
					layer.alert('增加成功',{icon: 8},function(index)
	    	    	{
	        	    	layer.close(index);
	        	    	parent.window.location.reload();
	        	    });
				}
				else
					layer.alert('增加失败',{icon: 8},function(index)
	    	    	{
	        	    	layer.close(index);
	        	    	parent.window.location.reload();
	        	    });
			},'text');
			return false; 
		});
	});	
});
</script>
</head>
<body>
<div id="content" style="padding-bottom:20px;">
    <form id="form" class="layui-form" method="post">
    <table id="client" class="layui-table" style="width: 80%;margin: 0 auto;">
    	<tr>
    		<th>
    			<label class="layui-form-label">*&nbsp;角色名称：</label>
    		</th>
    		<td>
    			<input type="text" name="name" id="name" required  lay-verify="required" placeholder="请输入角色名称" autocomplete="off" class="layui-input">
    		</td>
    	</tr>
        <tr>
    		<th>
    			<label class="layui-form-label">*&nbsp;角色位置：</label>
    		</th>
    		<td>
    			 <input type="radio" name="type" value="1" title="前台">
		      <input type="radio" name="type" value="2" title="后台" checked>
    		</td>
    	</tr>
    	<tr>
    		<td colspan="2" align="center">
    			<button class="layui-btn submit" lay-submit lay-filter="formDemo">立即提交</button>
		      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    		</td>
    	</tr>
    </table>
    </form>
</div>
</body>
</html>