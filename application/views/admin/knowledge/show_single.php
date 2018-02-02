<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .content {font-family:"微软雅黑"; font-size:12px; padding-left:10px; padding-top:10px; padding-right:10px; margin-top:20px;margin-right:10px;}
</style>
<body>
    <div class='content'>
        <p style="text-align:center; font-size:16px;"><?php echo $list[0]['title']; ?></p>
        <p style="text-align:right; margin-right:10px;">发布时间 : <?php echo date('Y年m月d日',$list[0]['addtime']); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发布人 : <?php echo $list[0]['username']; ?></p>
        <p><?php echo $list[0]['content']; ?></p>
        <p style="color:red;">可进行点赞 评论等功能  期待完善!</p>
    </div>
</body>
</html>