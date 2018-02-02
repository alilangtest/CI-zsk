<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加分类</title>
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
</head>
<style>
    .ty { margin-top: 10px; margin-left: 10px; }
    .flmc { width:400px !important; margin-bottom: 10px; }
</style>
<script>
    $(document).ready(function(){
        layui.use(['layer', 'form'], function(){
            var form = layui.form;
            var layer= layui.layer;
            //监听提交
            form.on('submit(sub)', function(data){
                $.post("/admin/home/change_pass",$("#addt").serialize(),
                    function(ee){
                        if(ee.status == 1){
                            layer.alert('密码修改成功',{icon: 6},function(index)
                            {
                                // parent.location.reload();//刷新父窗口对象（用于单开窗口）
                                top.window.location.href='/admin/login/index';
                            });

                        }else{
                            layer.alert(ee.msg, {icon: 5,skin: 'layer-ext-moon' });
                        }
                    }, "json");
                return false;
            });

        });
    });
</script>
<body>
<div class="ty">
    <form class="layui-form" id="addt">

            <div class="layui-form-item">
            <label class="layui-form-label">旧密码 ：</label>
            <div class="layui-input-block">
                <input name="oldpass" lay-verify="title" autocomplete="off" placeholder="请输入旧密码" class="layui-input flmc" type="password">
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">新密码 ：</label>
                <div class="layui-input-block">
                    <input name="newpassword" lay-verify="title" autocomplete="off" placeholder="请输入新密码" class="layui-input flmc" type="password">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">确认密码 ：</label>
                <div class="layui-input-block">
                    <input name="repassword" lay-verify="title" autocomplete="off" placeholder="请输入确认密码" class="layui-input flmc" type="password">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="sub">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
    </form>
</div>

</body>
</html>