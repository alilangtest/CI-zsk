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
    .content {font-family:"微软雅黑"; font-size:12px; padding-left:10px; padding-top:10px; padding-right:10px; margin-top:20px;margin-right:10px;}
</style>

<body>
<div class='content'>
        <p style="text-align:center; font-size:16px;"><?php echo $arr['title'];  ?></p>
        <p style="text-align:right; margin-right:10px; margin-top:14px;margin-bottom:14px;">发布时间 : <?php echo date('Y-m-d H:i:s',$arr['addtime']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发布人 : <?php echo $arr['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;到期时间 : <?php
                    if($arr['share_validity'] == '2000000000') {
                        echo "<span style='color:#5FB878;'>永久有效</span>";
                    } else {
                        $t = strtotime($arr['share_validity']);
                        $gq = $t-time();
                        if($gq<0){
                            echo "<span style='color:red;'>已经过期!</span>";
                        }else{
                            $tian = ceil($gq/86400)."天";
                            echo "<span style='color:#FFB800;'>$tian</span>";
                        }

                    }
                    ?></p>
        <p><?php echo $arr['content']; ?></p>
        <p style="color:red;">可进行点赞 评论等功能  期待完善!</p>
</div>



</body>
</html>
