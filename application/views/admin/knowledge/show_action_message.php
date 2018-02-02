<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加文章</title>
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
</head>
<script>
$(document).ready(function(){

    layui.use(['layer'], function(){
        var layer = layui.layer;
    });




    $('#checkAll').change(function(){
        if($(this).is(':checked')){
            $('.aa input[type=checkbox]').prop('checked',true);
        }else{
            $('.aa input[type=checkbox]').prop('checked',false);
        }
    });

    $("#delall").click(function(){
        $('.xs1').hide();
        $('.xs2').show();
    });
    //批量删除
    $('#qddelall').click(function(){
                var aa = $(this).closest('body').find('table .aa').find('input:checked');
                if(aa.length < 1){
                    layer.alert('请勾选要分享的文章', {icon: 5,skin: 'layer-ext-moon' });
                    return false;
                }
                var valArr = new Array;
                aa.each(function(i){
                    valArr[i] = $(this).val();
                });
                var vals = valArr.join(',');//转换为逗号隔开的字符串
                //ajax方法传递到后台 进行业务删除；
//                $.post("/admin/knowledge/different/different_add",$("#addt").serialize(),
                $.post("/admin/knowledge/shareknow/action_del", { id:vals },
                    function(data){
                        if(data.status == 1){
                            layer.alert(data.msg,{icon: 6},function(index)
                            {
                                // window.location.reload();//刷新当前页面
                                parent.location.reload();//刷新父窗口对象（用于单开窗口）
                            });
                        }else{
                            layer.alert(data.msg, {icon: 5,skin: 'layer-ext-moon' });
                        }
                    },'json');
                return false;
    });

     //单个删除
     $(".del").click(function(){
                var st = confirm('确定删除吗？');
                if(st == false){ return false;}
                var id = $(this).closest('tr').find('#child').val();
                $.post("/admin/knowledge/shareknow/action_del", { id: id },
                    function(ee){
                        if(ee.status == 1){
                            layer.alert(ee.msg,{icon: 6},function(index)
                            {
                                // window.location.reload();//刷新当前页面
                                parent.location.reload();//刷新父窗口对象（用于单开窗口）
                            });
                        }else{
                            layer.alert(ee.msg, {icon: 5,skin: 'layer-ext-moon' });
                        }

                    },'json');
                return false;
            });


});
</script>
<body>

<div  style="margin-top:10px; margin-left:20px; margin-right:20px;" class='xs1'>
    <button class="layui-btn layui-btn-sm layui-btn-danger xxx" id="delall"><i class="layui-icon"></i>批量删除</button>
</div>

<div  style="margin-top:10px; margin-left:20px; margin-right:20px;display:none;" class='xs2'>
    <button class="layui-btn  layui-btn-normal layui-btn-sm xxx" id="qddelall"><i class="layui-icon"></i>确定要删除?</button>
</div>

<div style="margin-top:10px; margin-left:20px; margin-right:20px;">
<table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="25">
        <col>
        <col width="45">
      </colgroup>
      <thead>
        <tr>
        <th>
        <input type="checkbox" class='aa' id="checkAll" name="id[]" style="width:14px; height:24px; float:left;">
        <!-- <span style="margin-top: 2px;display: block;float: left;margin-left:2px;">选择</span> -->
        </th>
          <!-- <th>操作者</th>
          <th>刪除时间</th> -->
          <th>消息内容</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
      <?php if(!empty($list)): ?>
      <?php foreach($list as $v):  ?>
        <tr class='aa'>
        <td><input type="checkbox" id="child" name="id[]" value="<?php echo $v['id']; ?>" style="width:14px; height:24px;"> </td>
          <!-- <td>贤心</td>
          <td>2016-11-29</td> -->
          <td><?php echo $v['msg'];  ?></td>
          <td class='del'>删除</td>
        </tr>
      <?php endforeach;?>
      <?php else: ?>
            <tr>
                <td colspan=10 style="text-align: center;">
                    <span style="color:red; text-align: center; line-height: 25px;"><i class="layui-icon" style="font-size: 25px; color:red;">&#xe69c;</i>  抱歉!没有您想要的内容!</span>
                </td
            </tr>
        <?php endif; ?>
      </tbody>
    </table>
</div>

</body>
</html>