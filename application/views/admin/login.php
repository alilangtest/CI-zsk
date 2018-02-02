<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="wcodeth=device-wcodeth, initial-scale=1, maximum-scale=1">
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/public/admin/css/admin.css"  media="all">
	<script type="text/javascript">
	$(function() {
		
		var layer =null;
		layui.use('layer', function(){
		  		layer= layui.layer;
		  	});
		
		$('#username').focus();
		$('#login').click(function(event) {
			var username=$('#username').val();
			var password=$('#password').val();
			var code=$('#code').val();
			if (!/^[a-zA-Z0-9_-]{5,20}|[\u4e00-\u9fa5]{2,16}$/.test(username)) {
				layer.alert('请输入正确的用户名',{icon: 8},function(index){$('#username').focus();layer.close(index);});
				return false;
			}
			if (password.length<6) {
				layer.alert('请输入6位数以上的密码',{icon: 8},function(index){$('#password').focus();layer.close(index);});
				return false;
			}
			if (!/^[0-9]{4}$/.test(code)) {
				layer.alert('请输入正确的验证码',{icon: 8},function(index){$('#code').focus();layer.close(index);});
				return false;
			}
			$.post("/admin/login/do_login",$("#form").serialize(),function(data){
				if(data.msg != '')
					layer.alert(data.msg,{icon: 8},function(index){$('#code').focus();layer.close(index);});
				else
					window.location.href=data.url;

			},'json')
		});
//		if(msg != "")
//			layer.alert(msg,{icon: 8});
		
	});
	
	</script>
</head>
<body class="loginbox">
	<form id="form">
    <div class="je-login"></div>
    <div class="je-logincon">
        <div class="logo"></div>
        <p class="logtext">欢迎使用云天网盘&知识库系统</p>
        <p class="je-pb10"><input class="userinp" type="text" name="username" id="username" maxlength="20" value="" placeholder="请输入用户名"></p>
        <p class="je-pb10"><input class="userinp" type="password" name="password" id="password" maxlength="20" value="" placeholder="请输入密码"></p>
        <p class="je-pb10">
        	<input class="userinp" type="text" name="code" id="code" maxlength="4" placeholder="验证码" value="" style="width: 260px;margin-right: 12px;">
        	<img src="/admin/login/auth_code" border="0" id="verify" alt="点击刷新" onclick="this.src='/admin/login/auth_code/' + Math.random();"/>
        </p>
        <p class="je-pt10"><input class="userbtn" type="button"  id='login' value="确 认 登 录" ></p>
        <p class="je-pt10" style="    margin: 60px auto; margin-left: 93px;"><font>Powered by 山东云天安全-研发部</font></p>
    </div>
   </form>

</body>
</html>