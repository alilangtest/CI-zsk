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
                // $('.look').click(function(){
                //     var id = $(this).closest('tr').find('.gid').html();
                //     var layer = layui.layer;
                //     layer.open({
                //         type: 2,
                //         title:"文章详情",
                //         area: ['800px', '550px'],
                //         fixed: false, //不固定
                //         maxmin: true,
                //         content: '/admin/knowledge/shareknow/single_info/'+id,
                //     });
                // });
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
                    valArr[i] = $(this).attr('ly');
                });
                var ly = valArr.join(',');//转换为逗号隔开的字符串

                var vlArr = new Array;
                aa.each(function(i){
                    vlArr[i] = $(this).attr('yid');//转换为逗号隔开的字符串
                });
                var yid = vlArr.join(',');
                
                //ajax方法传递到后台 进行业务删除；
//                $.post("/admin/knowledge/different/different_add",$("#addt").serialize(),
                $.post("/admin/knowledge/recycle/del_hs", { ly:ly,yid:yid },
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
                // var id = $(this).closest('tr').find('#child').val();//要删除的记录id;
                var ly = $(this).closest('tr').find("input:hidden[name='ly']").val();
                var yid = $(this).closest('tr').find("input:hidden[name='yid']").val();
                $.post("/admin/knowledge/recycle/del_hs", { ly: ly,yid:yid },
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

            //单个恢复操作
            $(".re").click(function(){
                var st = confirm('确定恢复吗？');
                if(st == false){ return false;}
                var ly = $(this).closest('tr').find("input:hidden[name='ly']").val();
                var yid = $(this).closest('tr').find("input:hidden[name='yid']").val();
            
                $.post("/admin/knowledge/recycle/reinstate", { ly: ly,yid:yid },
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
            //批量恢复操作
            $('#reinstate').click(function(){
                var aa = $(this).closest('body').find('table .aa').find('input:checked');
                if(aa.length < 1){
                    layer.alert('请勾选要恢复的文章', {icon: 5,skin: 'layer-ext-moon' });
                    return false;
                }
                var valArr = new Array;
                aa.each(function(i){
                    valArr[i] = $(this).attr('ly');
                });
                var ly = valArr.join(',');//转换为逗号隔开的字符串

                var vlArr = new Array;
                aa.each(function(i){
                    vlArr[i] = $(this).attr('yid');//转换为逗号隔开的字符串
                });
                var yid = vlArr.join(',');
                
                //ajax方法传递到后台 进行业务删除；
//                $.post("/admin/knowledge/different/different_add",$("#addt").serialize(),
                $.post("/admin/knowledge/recycle/reinstate", { ly:ly,yid:yid },
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

            $("#dept").change(function(){
                //改变session
                $.post('/admin/file/files/change_session',"id="+$("#dept").val(),function(data){
                    window.location.reload();
                },'text');
    	    });
    	
    	    $("#dept").find("option[value='<?php echo $_SESSION["default_dept"] ?>']").attr("selected",true);
            $('#refresh').click(function() { window.location.reload();});


        });
    </script>
</head>
<style>
.hsl  { height:35px; font-size:13px; line-height:35px;width:102%;}
.xxx { height:34px;line-height:34px;}
.aa td { font-size:13px !important;}
#dept { font-size:13px;}
.aa { font-family:"微软雅黑";}
</style>
<body>
<blockquote class="layui-elem-quote">
    <!-- <form style="float:left;" method="get" action="/admin/knowledge/Shareknow/share_list/" >
        <div class="layui-input-inline">
            <input type="text" name="kw" value="<?php if(isset($keyword) && $keyword != '') echo $keyword;else echo '请输入关键词'; ?>"  lay-verify="required" placeholder="请输入文章标题" autocomplete="off" class="layui-input">
        </div>
    </form>  -->
        <!-- <button class="layui-btn layui-btn-normal">文章搜索</button> -->
        <!-- <button class="layui-btn" id="delall">批量删除</button> -->
        <button class="layui-btn layui-btn-sm layui-btn-danger xxx" id="delall"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn layui-btn-sm layui-btn-warm xxx"layui-bg-black" " id="reinstate"><i class="layui-icon">&#xe63d;</i>批量恢复</button>
        <button class="layui-btn layui-btn-sm layui-bg-cyan xxx" id="refresh"><i class="layui-icon">&#x1002;</i> 刷新页面</button>
    <div style="float:right; margin-right:20px;">
        <label class="layui-form-label">所属部门：</label>
        <select style="height:37px;border: solid 1px #ccc;" id="dept">
            <?php foreach($list as $v): ?>
            <option value="<?php echo $v['ding_dept_id']; ?>"><?php echo $v['name'];?></option>
            <?php endforeach;?>
        </select>
    </div>

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
            <th><input type="checkbox" id="checkAll" name="id[]" style="width:16px; height:16px; float:left;"> <span style="margin-top: -2px;display: block;float: left; margin-left: 10px;">请选择</span> </th>
            <th>文章编号</th>
            <th>文章名称</th>
            <th>文章分类</th>
            <th>来源</th>
            <th>发布人</th>
            <th>发布人部门</th>
            <th>发布时间</th>
            <th>查看</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($situation)): ?>
            <?php foreach($situation as $k => $v):  ?>
                <tr class="aa">
                    <td><input type="checkbox" id="child" name="id[]" ly="<?php echo $v['ly']; ?>" yid=<?php echo $v['yid']; ?> value="<?php echo $v['id']?$v['id']:'-' ?>" style="width:16px; height:16px;"> </td>
                    <!--$v['ly'] 1：部門刪除的 -1：個人刪除的 2：公司分享刪除的-->
                    <input type='hidden' name='ly' value="<?php echo $v['ly']; ?>"/>
                    <!--$v['yid'] 表示的是該條紀錄在articles和article_share表当中的主键id  根据它来进行物理删除操作-->
                    <input type='hidden' name='yid' value="<?php echo $v['yid']; ?>"/>

                    <td class="gid"><?php echo $v['id']?$v['id']:'--' ?></td>
                    <td><?php echo $v['title']?$v['title']:'--' ?></td> 
                    <td><?php echo $v['tname']?$v['tname']:'--' ?></td>
                    <td><?php if($v['ly'] == 1) echo "<span style='color:#5FB878;font-weight:bolder;'>部门知识</span>"; if($v['ly'] == -1) echo "<span style='color:#1E9FFF;font-weight:bolder;'>个人知识</span>"; if($v['ly'] == 2) echo "<span style='color:#2F4056;font-weight:bolder;'>公司分享<span>"; ?></td>
                    <td><?php echo $v['name']?$v['name']:'--' ?></td>
                    <td><?php echo $v['dname']?$v['dname']:'--' ?></td>
                    <td><?php echo $v['addtime']?date('Y-m-d H:i:s',$v['addtime']):'--' ?></td>
                
                    <td>
                        <!-- <a href="javascript:void(0);" class="look"><i class="layui-icon" style="font-size: 30px; color: #1E9FFF;">&#xe705;</i> </a> -->
                        <!-- &#xe65c; -->
                        <!-- <a href="javascript:void(0);" class="del"><i class="layui-icon" style="font-size: 30px; color: #1E9FFF;">&#xe640;</i> </a> -->
                        <a lay-event="edit" class="del layui-btn layui-btn-xs layui-btn-danger">删除</a>
                        <!-- <a href="javascript:void(0);" class="re"><i class="layui-icon" style="font-size: 28px; color: #1E9FFF;">&#xe64f;</i> </a> -->
                        <a lay-event="edit" class="re layui-btn layui-btn-xs layui-btn-warm">恢复</a>
                    </td>
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