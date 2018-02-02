<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加文章</title>
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <!--百度ue使用到的js-->
    <script src="/public/ueditor/ueditor.config.js" type="text/javascript"></script>
    <script src="/public/ueditor/ueditor.all.js" type="text/javascript"></script>

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
            var ue = UE.getEditor('editor');//形成编辑器；
//            var layedit = layui.layedit;
//            var index = layedit.build('demo'); //建立编辑器
            //自定义验证规则  前端验证
            form.verify({
                title: function(value){
                    if(value.length < 3){
                        return '同志,文章标题至少3个字符!';
                    }
                },
                column: function(value){
                    if(value.length < 1){
                        return '同学,所属栏目不能为空!';
                    }
                },
                keyword: function(value){
                    if(value.length < 1){
                        return '同胞,关键词不能为空!';
                    }
                },
                describe: function(value){
                    if(value.length < 1){
                        return '同事,文章描述不能为空!';
                    }
                },
                sort: function(value){
                    if(value.length < 1){
                        return '亲人,文章排序不能为空!';
                    }
                }
                //textarea在此无法验证 提交的时候验证吧！
            });

            //监听提交
            form.on('submit(sub)', function(data){

                var content = ue.getContent();//百度ue读取编辑器当中的内容部分；
                //前端对content文章内容进行验证!
                if(content==''){
                    layer.alert('文章内容不能为空!', {icon: 5,skin: 'layer-ext-moon' });
                    return false;
                }
                var dt = data.field;
                $.post("/admin/knowledge/intellectual/intellectual_add",{ title:dt.title,column:dt.column,keyword:dt.keyword,describe:dt.describe,sort:dt.sort,content:content },
                    function(ee){
                        if(ee.status == 1){
                            layer.alert(ee.msg,{icon: 6},function(index)
                            {
                                parent.location.reload();//刷新父窗口对象（用于单开窗口）
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
<style>
    .wahaha  { width:70% !important;}
</style>
<body>
<div class="ty">
    <form class="layui-form" id="addt">

        <div class="layui-form-item">
            <label class="layui-form-label">文章标题 ：</label>
            <div class="layui-input-block">
                <input name="title" lay-verify="title" autocomplete="off" placeholder="请输入分类名称" class="layui-input flmc" type="text">
            </div>


<!--                <label class="layui-form-label">所属栏目 ：</label>-->
<!--                <div class="layui-input-block">-->
<!--                    <input name="column" lay-verify="column" autocomplete="off" placeholder="请输入分类排序" class="layui-input flmc" type="text">-->
<!--                </div>-->


            <div class="layui-form-item">
                <label class="layui-form-label">关键词 ：</label>
                <div class="layui-input-block">
                    <input name="keyword" lay-verify="keyword" autocomplete="off" placeholder="请输入分类排序" class="layui-input flmc" type="text">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">文章描述 ：</label>
                <div class="layui-input-block">
                    <input name="describe" lay-verify="describe" autocomplete="off" placeholder="请输入分类排序" class="layui-input flmc" type="text">
                </div>
            </div>

            <label class="layui-form-label" style="margin-bottom: 13px;">所属栏目 ：</label>
            <div class="layui-input-block" style="z-index: 999999; width: 20%;">
                <select name="column" lay-filter="aihao">
                    <option value=""></option>
                    <?php foreach($col as $k => $v): ?>
                        <option value="<?php echo $v['id']; ?>"><?php echo $v['tname']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">文章内容 ：</label>
                <div class="layui-input-block wahaha">
                    <textarea id="editor" type="text/plain" ></textarea>
                </div>
            </div>



            <div class="layui-form-item">
                <label class="layui-form-label">文章排序 ：</label>
                <div class="layui-input-block">
                    <input name="sort" lay-verify="sort" autocomplete="off" placeholder="请输入排序" class="layui-input flmc" type="text">
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