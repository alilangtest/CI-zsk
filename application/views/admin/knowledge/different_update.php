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
                $.post("/admin/knowledge/different/different_update",$("#addt").serialize(),
                    function(ee){
                        if(ee.status == 1){
                            layer.alert(ee.msg,{icon: 6},function(index)
                            {
                                parent.location.reload();//刷新父窗口对象（用于单开窗口）
                            });

                        }else if(ee.status == 0){
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
            <label class="layui-form-label">名  称 ：</label>
            <div class="layui-input-block">
                <input name="id" type="hidden" value="<?php echo $this->diff->id; ?>">
                <input name="tname" lay-verify="title" autocomplete="off" placeholder="请输入分类名称" class="layui-input flmc" type="text" value="<?php echo $this->diff->tname; ?>">
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">排  序 ：</label>
                <div class="layui-input-block">
                    <input name="sort" lay-verify="title" autocomplete="off" placeholder="请输入分类排序" class="layui-input flmc" type="text" value="<?php echo $this->diff->sort; ?>">
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