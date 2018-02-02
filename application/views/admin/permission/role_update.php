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
	layui.use(['table','form'], function(){
		var layer = layui.layer;
		var form = layui.form;
		$('#qd').click(function() {
			if($("#name").val() == "")
			{
				layer.alert('角色名称请在2-15个字符以内',{icon: 8},function(index)
    	    	{
        	    	layer.close(index);
        	    });
				return false;
			}
			$.post('/admin/permission/do_role_update', $("#form").serializeArray(),function(data){
				if(data == 'ok')
				{
					layer.alert('修改成功!',{icon: 8},function(index)
	    	    	{
	        	    	layer.close(index);
	        	    	window.parent.location.reload();
	        	    });
				}
				else
					layer.alert('修改失败!',{icon: 8},function(index)
	    	    	{
	        	    	layer.close(index);
	        	    	window.parent.location.reload();
	        	    });
			},'text');
		});
	});
});
</script>
</head>
<body>
<div id="content" style="padding-bottom:20px;">
    <form id="form">
    <input name="id" id="id" type="hidden"  value="<?php echo $this->role->id;?>"/>
    <table class="layui-table">
    	<tr class="tr">
        	<td class="left">*&nbsp;角色名称：</td>
        	<td colspan="3"><input name="name" id="name" type="text" class="ctext" value="<?php echo $this->role->name;?>" size="80" /></td>
        </tr>
    	<tr class="tr">
        	<td class="left">*&nbsp;角色位置：</td>
        	<td colspan="3">
				<input type="radio" name="type" value="1" <?php if($this->role->type ==1) echo 'checked="checked"' ;?>  />&nbsp;前台&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="type" value="2" <?php if($this->role->type ==2) echo 'checked="checked"' ;?>/>&nbsp;后台
			</td>
        </tr>
    </table>
    <table class="layui-table">
    	<tr>
    		<td align="right">
    			<input type="button" id="qd" class="layui-btn" value="确定" />
    		</td>
    	</tr>
    </table>
    </form>
</div>
</body>
</html>