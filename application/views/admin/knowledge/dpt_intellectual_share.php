<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.core.min.js"></script>
    <script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.excheck.min.js"></script>
    <script type="text/javascript" src="/public/js/zTree_v3/js/jquery.ztree.exedit.min.js"></script>
    <link rel="stylesheet" href="/public/js/zTree_v3/css/demo.css?v=51" type="text/css">
    <link rel="stylesheet" href="/public/js/zTree_v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script>
        var layer = null ;
        var laydate = null;
        var zTreeObj;
        var setting = {
            check: {
                enable: true,
                chkboxType: { "Y": "s", "N": "s" }
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            edit:{
                enable: true,
                showRemoveBtn: false,
                showRenameBtn: false,
                drag: {
                    isCopy: false,
                    isMove: false
                }
            },
            callback: {

            }
        };

        $(document).ready(function() {
            layui.use(['table','laydate','form'], function(){
                layer = layui.layer;
                laydate = layui.laydate;
                var form = layui.form;
                laydate.render({
                    elem: '#dateTime',
                    type: 'datetime'
                });

                form.on('radio', function(data){
                    if(data.value==-1){
                        $("#dateTimeDiv").hide();
                    } else if(data.value==1){
                        $("#dateTimeDiv").show();
                    }
                });
            });
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            var nodes = zTreeObj.getNodes();
            zTreeObj.expandAll(true);
            $('#submit').click(function() {
                var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
                var nodes = treeObj.getCheckedNodes(true);
                if(nodes==null||nodes.length < 1){
                    layer.alert("请选择分享的部门！");
                    return;
                }
                var deptids = "";
                for(var i=0;i<nodes.length;i++){
                    deptids += nodes[i].id+',';
                }
                var validate = $("input[name='validate']:checked").val();
                var dateTime = $("#dateTime").val();
                if(validate==1 && (dateTime==null||dateTime=="")){
                    layer.alert("请选择分享到期时间！");
                    return;
                }
                $.post('/admin/knowledge/dpt_intellectual/do_share','article_ids=<?php echo $artcle_ids;?>&deptids='+deptids+"&validate="+validate+"&dateTime="+dateTime,function(data){
//                    layer.alert(data,{icon: 8},function(index)
//                    {
//                        layer.close(index);
//                    });
                    if(data.status == 1){
                        layer.alert(data.msg,{icon: 6},function(index)
                        {
                            parent.location.reload();//刷新父窗口对象（用于单开窗口）
                        });
                    }else if(data.status == 0){
                        layer.alert(data.msg, {icon: 5,skin: 'layer-ext-moon' });
                    }

                },'json');
            });
            $("#dateTimeDiv").hide();
        });
        var zNodes = [
            {"id":"a1", "pId":0, "name":"山东云天安全技术有限公司",icon:"/public/images/ztree/home2.png","chkDisabled":false,},
            <?php
            $str="";
            foreach ($depts as $d)
            {
                if($d['ding_parentid']=='0'){
                    continue;
                }
                $str.='{"id":'.$d['ding_dept_id'].', "pId":"'.$d['ding_parentid'].'","chkDisabled":false, "name":"'.$d['name'].'"},';
            }
            $str=trim($str,",");
            echo $str;
            ?>
        ];

    </script>
</head>
<body>
<div id="content" style="padding-bottom:20px;">
    <div id="treeDemo" class="ztree" style="margin: 0 0 10px 12px;height:270px; overflow:auto"></div>

    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">有效期：</label>
            <div class="layui-input-block">
                <input type="radio" name="validate" value="-1" title="永久有效" checked>
                <input type="radio" name="validate" value="1" title="临时有效">
            </div>
        </div>
        <div id="dateTimeDiv" class="layui-inline">
            <label class="layui-form-label">到期时间：</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="dateTime" placeholder="yyyy-MM-dd HH:mm:ss">
            </div>
        </div>
    </form>
    <div style="margin: 15px 0 0 12px;">
        <div style="float:right;margin-right:20px;">
            <a href="javascript:void(0);" class="layui-btn" id="submit">
                确定
            </a>
        </div>

    </div>

</div>
</body>
</html>