<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>菜单管理</title>
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <script>
        $(document).ready(function(){
            layui.use(['layer'], function(){
                //查看操作
                $('.look').click(function(){
                    var layer = layui.layer;
                    // var aa = $('.sfgq').html();
                    //var aa = $('.sfgq').parent('tr').find('.sfgq').html();
                    var aa  = $(this).closest('tr').find('.sfgq').html();
                    if(aa == "已经过期!"){
                       console.log('此文章已经过期!请自行删除!');
                       layer.alert('此文章已经过期!请自行删除!', {icon: 5,skin: 'layer-ext-moon' });
                       return false;
                    }
                    var id = $(this).closest('tr').find('.gid').html();
                    
                    layer.open({
                        type: 2,
                        title:"文章详情",
                        area: ['800px', '550px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '/admin/knowledge/shareknow/single_info/'+id,
                    });
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

            //批量删除
            $("#delall").click(function(){
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
                $.post("/admin/knowledge/shareknow/del_share", { id:vals },
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
            //单个删除
            $(".del").click(function(){
                var st = confirm('确定删除吗？');
                if(st == false){ return false;}
                var id = $(this).closest('tr').find('#child').val();
                $.post("/admin/knowledge/shareknow/del_share", { id: id },
                    function(ee){
                        if(ee.status == 1){
                            layer.alert(ee.msg,{icon: 6},function(index)
                            {
                                window.location.reload();//刷新当前页面
                            });
                        }else{
                            layer.alert(ee.msg, {icon: 5,skin: 'layer-ext-moon' });
                        }

                    },'json');
                return false;

            });

            $("#dept").change(function(){
                //改变session
                $.post('/admin/file/files/change_session',"id="+$("#dept").val(),function(data){
                    window.location.reload();
                },'text');
                return false;
    	    });
    	
    	    $("#dept").find("option[value='<?php echo $_SESSION["default_dept"] ?>']").attr("selected",true);
            $('#refresh').click(function() { window.location.reload();});

            $("#message").click(function(){
                // $(this).find('span').replaceWith('<span></span>');
                layer.open({
                        type: 2,
                        title:"消息列表",
                        area: ['800px', '550px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content: '/admin/knowledge/shareknow/show_action_message/',
                    });
                    return false;
            });

           
    	



        });
    </script>
</head>
<style>
.hsl  { height:35px; font-size:13px; line-height:35px;width:102%;}
.xxx { height:34px;line-height:34px;}
.aa td { font-size:13px !important;}
#dept { font-size:13px;}
</style>
<body>
<blockquote class="layui-elem-quote">
    <form style="float:left;" method="get" action="/admin/knowledge/shareknow/share_list/" >
        <div class="layui-input-inline">
            <input type="text" name="kw" value=""  lay-verify="required" placeholder="请输入标题/分类/发布人" autocomplete="off" class="layui-input hsl">
        </div>&nbsp;
        <button class="layui-btn layui-btn-normal layui-btn-sm xxx"><i class="layui-icon"></i> 搜索</button>
        <button class="layui-btn layui-btn-sm layui-btn-danger xxx" id="delall"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn layui-btn-sm layui-bg-cyan xxx" id="refresh"><i class="layui-icon">&#x1002;</i> 刷新页面</button>
        <button class="layui-btn layui-btn-sm xxx" id="message">
            查看消息
            <!-- <span class="layui-badge-dot"></span> -->
        </button>
        <div style="float:right; margin-left:480px;">
            <label class="layui-form-label">所属部门：</label>
            <select style="height:37px;border: solid 1px #ccc;" id="dept">
            <?php foreach($list as $v): ?>
            <option value="<?php echo $v['ding_dept_id']; ?>"><?php echo $v['name'];?></option>
            <?php endforeach;?>
            </select>
        </div>
        
    </form>
    <div style="clear: both"></div>
</blockquote>
<div>
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" id="checkAll" name="id[]" style="width:16px; height:16px; float:left;"><span style="margin-top: -2px;display: block;float: left; margin-left: 10px;">请选择</span> </th>
            <th>文章编号</th>
            <th>文章名称</th>
            <th>文章分类</th>
            <th>文章來源</th>
            <th>发布人</th>
            <th>发布人部门</th>
            <th>发布时间</th>
            <th>到期时间</th>
            <th>查看</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($situation)): ?>
            <?php foreach($situation as $k => $v):  ?>
                <tr class="aa">
                    <td><input type="checkbox" id="child" name="id[]" value="<?php echo $v['sid']?$v['sid']:'-' ?>" style="width:16px; height:16px;"> </td>
                    <td class="gid"><?php echo $v['id']?$v['id']:'--' ?></td>
                    <td><?php echo $v['title']?$v['title']:'--' ?></td>
                    <td><?php echo $v['tname']?$v['tname']:'--' ?></td>
                    <td><?php if($v['dpt'] == -1) echo "个人分享"; if($v['dpt'] == 1) echo "部门分享"; ?></td>
                    <td><?php echo $v['name']?$v['name']:'--' ?></td>
                    <td><?php echo $v['dname']?$v['dname']:'--' ?></td>
                    <td><?php echo $v['addtime']?date('Y-m-d H:i:s',$v['addtime']):'--' ?></td>
                    <td><?php
                        if($v['share_validity'] == '2000000000') {
                            echo "<span  class='sfgq' style='color:#5FB878;'>永久有效</span>";
                        } else {
                            $t = strtotime($v['share_validity']);
                            $gq = $t-time();
                            if($gq<0){
                                echo "<span  class='sfgq' style='color:#FF5722;'>已经过期!</span>";
                            }else{
                                echo "<span  class='sfgq' style='color:#FFB800;'>".ceil($gq/86400)."天</span>";
                            }

                        }
                            ?>
                    </td>
                    <td>
                        <!-- <a href="javascript:void(0);" class="look"><i class="layui-icon" style="font-size: 30px; color: #1E9FFF;">&#xe705;</i> </a>
                        <a href="javascript:void(0);" class="del"><i class="layui-icon" style="font-size: 30px; color: #1E9FFF;"></i> </a> -->
                        <a lay-event="edit" class="look layui-btn layui-btn-xs">查看</a>
                        <a lay-event="edit" class="del layui-btn layui-btn-xs layui-btn-danger">删除</a>
                       
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan=10 style="text-align: center;">
                    <span style="color:red; text-align: center; line-height: 25px;"><i class="layui-icon" style="font-size: 25px; color:red;">&#xe69c;</i>  抱歉!没有您想要的内容!</span>
                </td
            </tr>
        <?php endif; ?>

        </tbody>
    </table>
    <div class="page"><?php echo $this->pagination->create_links();?>&nbsp;&nbsp;共 <?php echo $total_rows;?> 条记录</div>

</body>
</html>