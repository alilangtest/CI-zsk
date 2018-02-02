<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>菜单管理</title>
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
</head>
<style>
    .layui-form { font-size:12px;}
    .layui-input { height:30px;line-height:30px;}
    .layui-form-item { margin-left:-34px; margin-top:1px;}
    .layui-field-title { border-top:1px solid red !important;}
    .xxx { height:34px;line-height:34px;}
    .my { width:55px !important; padding:0px !important;}
    .my a { border:none;}
     tr th, .layui-elem-quote { font-size:13px !important;}
     tr td { font-size:12px !important;}
</style>
<script>
$().ready(function(){

  layui.use(['form', 'layedit', 'laydate'], function(){
    var form = layui.form
    ,laydate = layui.laydate;
    //日期
    laydate.render({
      elem: '#date'
    });
    laydate.render({
     elem: '#date1'
   });

   //删除操作
   $(".del").click(function(){
       var st = confirm('确定删除吗？');
       if(st == false){ return false;}
       var id = $(this).closest('tr').find('.gid').html();
       $.post("/admin/knowledge/behavior_log/del_action/", { id: id },
           function(ee){
               layer.alert(ee.msg,{icon: 6},function(index){
                   window.location.reload();//刷新当前页面
               });
           },'json');

   });
   //批量删除
   $("#delall").click(function(){
       var aa = $(this).closest('body').find('table .aa').find('input:checked');
       if(aa.length < 1){
           layer.alert('请勾选要删除的日志', {icon: 5,skin: 'layer-ext-moon' });
           return false;
       }
       console.log(aa);
       var valArr = new Array;
       aa.each(function(i){
           valArr[i] = $(this).val();
       });
       var vals = valArr.join(',');//转换为逗号隔开的字符串
       console.log(vals);
       // alert(vals);
       //ajax方法传递到后台 进行业务删除；
 //                $.post("/admin/knowledge/different/different_add",$("#addt").serialize(),
       $.post("/admin/knowledge/behavior_log/del_action/", { id:vals },
           function(data){
               if(data.status == 1){
                   layer.alert(data.msg,{icon: 6},function(index)
                   {
                       window.location.reload();//刷新当前页面
                   });
               }else{
                   layer.alert(data.msg, {icon: 5,skin: 'layer-ext-moon' });
               }
           },'json');
       return false;
   });

  });



  //全选或全不选
  $("#checkAll").change(function(){
      if(this.checked){
          $('tr :checkbox').prop('checked',true);
      }else{
          $('tr :checkbox').prop('checked',false);
      }
  });
  $('#refresh').click(function() { window.location.reload();});

});
</script>
<body>
<blockquote class="layui-elem-quote layui-text">
  Hi!亲爱的小伙伴,你的一切操作都会被我记录下来,如果不小心删除了什么东东就可以找我,你只需在下边选择或输入时间段,栏目标识,行为即可查看你的行为记录了哦!</a>
</blockquote>

<form class="layui-form" action="">

  <div class="layui-form-item">

    <div class="layui-inline">
      <label class="layui-form-label">栏目选择 : </label>
      <div class="layui-input-inline">
        <select name="column">
          <option value="">请选择标识</option>
          <optgroup label="云盘系统">
            <option value="部门云盘">部门云盘</option>
            <option value="我的文件">我的文件</option>
            <option value="审核文件">审核文件</option>
            <option value="共享文件">共享文件</option>
            <option value="网盘回收站">网盘回收站</option>
          </optgroup>
          <optgroup label="知识库系统">
            <option value="知识分类">知识分类</option>
            <option value="我的知识">我的知识</option>
            <option value="部门知识">部门知识</option>
            <option value="公司共享">公司共享</option>
            <option value="知识回收站">知识回收站</option>
          </optgroup>
        </select>
      </div>
    </div>
    <br/>
    <div class="layui-inline">
      <label class="layui-form-label">起始时间 : </label>
      <div class="layui-input-inline">
        <input type="text" name="startime" id="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
      </div>
      &nbsp;&nbsp;-- &nbsp;&nbsp;
      <div class="layui-inline" style="width:190px;">
          <input type="text" name="endtime" id="date1" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
      </div>
    </div>
    <br/>
    <div class="layui-form-item" style="margin-left:3px;">
    <label class="layui-form-label">操作行为 : </label>
    <div class="layui-input-block" style="width:200px;">
      <select name="action" lay-filter="aihao">
        <option value=""></option>
        <option value="新增">新增</option>
        <option value="删除">删除</option>
        <option value="修改">修改</option>
        <option value="分享">分享</option>
        <option value="恢复">恢复</option>
        <option value="上传">上传</option>
        <option value="移动">移动</option>
        <option value="审核">审核</option>
      </select>
      </select>
    </div>
  </div>
    <div class="layui-form-item">
    <div class="layui-input-block" style="margin-left:74px;">
      <button class="layui-btn layui-btn-sm" lay-submit="" lay-filter="demo1">立即搜索</button>
      <button type="reset" class="layui-btn layui-btn-sm layui-btn-primary">重置</button>
    </div>
    </div>

  </div>
</form>
<fieldset class="layui-elem-field layui-field-title">
  <legend style="font-size:14px;">日志详情列表</legend>
</fieldset>
<button class="layui-btn layui-btn-sm layui-btn-danger xxx" id="delall" style="float:right;margin-right:22px;margin-bottom:10px;"><i class="layui-icon"></i>批量删除</button>
<button class="layui-btn layui-btn-sm layui-bg-cyan xxx" id="refresh" style="float:right;margin-right:22px;margin-bottom:10px;"><i class="layui-icon">&#x1002;</i> 刷新页面</button>
<a href="/admin/knowledge/behavior_log/behavior_list/" class="layui-btn layui-btn-sm layui-bg-blue xxx" style="float:right;margin-right:15px;margin-bottom:10px;"><i class="layui-icon">&#x1002;</i> 展示全部</a>
<table class="layui-table" lay-even="" lay-skin="nob">
  <colgroup>
    <col width="40">
    <col width="80">
    <col width="100">
    <col width="100">
    <col width="100">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th><input type="checkbox" id="checkAll" name="id[]" style="width:16px; height:16px; float:left;"></th>
      <th>编号</th>
      <th>行为名称</th>
      <th>作用栏目</th>
      <th>执行者</th>
      <th>提醒内容</th>
      <th>执行时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($situation)): ?>
        <?php foreach($situation as $k => $v):  ?>
    <tr class="aa">
      <td><input type="checkbox" id="child" name="id[]" value="<?php echo $v['id']; ?>" style="width:16px; height:16px;"> </td>
      <td class="gid"><?php echo $v['id']?$v['id']:'--' ?></td>
      <td><?php echo $v['name']?$v['name']:'--' ?></td>
      <td><?php echo $v['column']?$v['column']:'--' ?></td>
      <td><?php echo $v['executor']?$v['executor']:'--' ?></td>
      <td><?php echo $v['content']?$v['content']:'--' ?></td>
      <td><?php echo $v['addtime']?date('Y-m-d H:i:s',$v['addtime']):'--' ?></td>
      <td><a lay-event="edit" class="del layui-btn layui-btn-xs layui-btn-danger">删除</a></td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
      <td colspan=9 style="text-align: center;">
          <span style="color:red; text-align: center; line-height: 25px;"><i class="layui-icon" style="font-size: 25px; color:red;">&#xe69c;</i>  抱歉!没有您想要的内容!</span>
      </td
  </tr>
<?php endif; ?>
  </tbody>
</table>
<div class="page"><?php echo $this->pagination->create_links();?>&nbsp;&nbsp;共 <?php echo $total_rows;?> 条记录</div>
</body>
</html>
