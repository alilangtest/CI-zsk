<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="/public/layui/layui.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
<link rel="stylesheet" type="text/css" href="/public/js/uploader/webuploader.css">
<script type="text/javascript" src="/public/js/uploader/webuploader.js"></script>

<style type="text/css">
.progress{width: 700px;}
.btns .uploadBtn:hover {
    background: #00a2d4;
	
}
.btns .uploadBtn{
	border: 1px solid #cfcfcf;
    padding: 0 18px;
    display: inline-block;
    border-radius: 3px;
    margin-left: 10px;
    cursor: pointer;
    font-size: 14px;
    float: left;
	height: 39px;
	background: #00b7ee;
    color: #fff;
    border-color: transparent;
}
#picker{
	float:left;
}
.btns{
	margin-top:10px;
}
</style>
<script>
$(document).ready(function() {
	var layer;
	var element;
	layui.use(['layer','element'], function(){
		layer = layui.layer;
		element = layui.element;
	});
	var $list = $('#thelist');
	var state = 'pending';
	var uploader = WebUploader.create({
	    // swf文件路径
	    swf: '/public/js/uploader/Uploader.swf',
	    // 文件接收服务端。
	    server: '/admin/file/files/do_upload',
	    // 选择文件的按钮。可选。
	    pick: '#picker',
	    chunked: true,
	    sendAsBinary:true,
	    chunkSize:50*1024*1024,  //10M
	    resize: false,
	    formData:{dirid:<?php echo $dirid;?>}
	});
	// 当有文件被添加进队列的时候
	uploader.on( 'fileQueued', function( file ) {
	    $list.append( '<div id="' + file.id + '" class="item">' +
	        '<h4 class="info">' + file.name + '</h4>' +
	        '<p class="state">等待上传...</p>' +
	    '</div>' );
	});
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
	    var $li = $('#'+file.id);
	    var $percent = $li.find('.layui-progress-bar');

	    // 避免重复创建
	    if ( !$percent.length ) {
	        $percent = $('<div class="progress"><div class="layui-progress layui-progress-big" lay-showpercent="true" lay-filter="demo'+file.id+'"><div class="layui-progress-bar layui-bg-green" lay-percent="0%"><span class="layui-progress-text">0%</span></div></div></div>').appendTo( $li ).find('.progress');
	    }

	    $li.find('.state').html('上传中');
	    element.progress('demo'+file.id, Math.round(percentage * 100) + '%');
	});
	
	uploader.on( 'uploadSuccess', function( file ) {
	    $( '#'+file.id ).find('.state').text('已上传');
	});

	uploader.on( 'uploadError', function( file ) {
	    $( '#'+file.id ).find('.state').text('上传出错');
	});

	uploader.on( 'uploadComplete', function( file ) {
        if(uploader.getStats().queueNum==0){
        	layer.alert('文件已经上传成功，正在等待审核，请到我的上传里面查看上传文件！');
        }
	});
	uploader.on( 'all', function( type ) {
        if ( type === 'startUpload' ) {
            state = 'uploading';
        } else if ( type === 'stopUpload' ) {
            state = 'paused';
        } else if ( type === 'uploadFinished' ) {
            state = 'done';
        }
        if ( state === 'uploading' ) {
        	$('#ctlBtn').text('暂停上传');
        } else {
        	$('#ctlBtn').text('开始上传');
        }
    });
	$('#ctlBtn').on( 'click', function() {
        if ( state === 'uploading' ) {
            uploader.stop();
        } else {
            uploader.upload();
        }
		
    });
	uploader.on('uploadSuccess',function(file,response){
		//alert("文件已经上传成功，正在等待审核，请到我的上传里面查看上传文件！");
	});

});
</script>
<title>我的网盘</title>
</head>
<body>
<div style="margin-left:10px;">
	<div id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
        <button id="ctlBtn" class="uploadBtn state-ready">开始上传</button>
    </div>
	</div>
</div>
</body>
</html>