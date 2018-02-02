<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="/public/layui/layui.js" type="text/javascript"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
<link rel="stylesheet" type="text/css" href="/public/js/uploader/webuploader.css">
<script type="text/javascript" src="/public/js/uploader/webuploader.js"></script>
<script src="/public/js/jquery.media.js"></script>
<style type="text/css">
select {
    height:36px;
}
.layui-table-body .layui-table tbody tr td:nth-child(2) div img{
	width: 26px;
	height:26px;
}
.layui-table-body .layui-table tbody tr td:nth-child(2) div a{
	margin-left: 10px;
}
.layui-layer.layui-layer-page .layui-layer-content div {
	border:0px !important;
	margin:0px !important;
	max-width:100% !important;
	padding:30px 30px !important;
}
.layui-unselect.layui-form-checkbox{
	top:0px !important;
	margin-top:5px !important;
}
</style>
<script>
	var table=null;
    $(document).ready(function() {
    	layui.use('table', function(){
    	    table = layui.table;
    	    table.on('checkbox(table)', function(obj){
        		var checkStatus = table.checkStatus('tbDemo'); //test即为基础参数id对应的值
  		    	if(checkStatus.data.length > 0)
  		    	{
  		    		$("#btn_del").show();
  	  		    }
  		    	else
  		    	{
  		    		$("#btn_del").hide();
  	  		    }
      		});
			$('#refresh').click(function() { window.location.reload();});
    	});
    
    	$("#dept").change(function(){
    		//改变session
    		$.post('/admin/file/files/change_session',"id="+$("#dept").val(),function(data){
				window.location.reload();
			},'text');
    	});
    	$("#dept").find("option[value='<?php echo $_SESSION["default_dept"] ?>']").attr("selected",true);

    	$("#btn_del").click(function(){
    		var checkStatus = table.checkStatus('tbDemo');
    		var data = checkStatus.data;
    		var ids = '';
    		for(var i=0;i<data.length;i++){
        		if(data[i].status=="通过"){
        			layer.alert('审核通过的文件不能删除，请重新选择！');
            		return;
            	}
    			ids +=data[i].id+",";
        	}
        	if(ids==''){
        		layer.alert('请选择要删除的文件');
        		return;
            }
        	$.post('/admin/file/my_uploads/do_delete',"ids="+ids,function(data){
        		layer.alert(data,function(index){
        			layer.close(index);
        			reloadData();
            		$("#btn_del").hide();
            	});
        		
    		},'text');
       	});

    	$("#btn_query").click(function(){
    		reloadData();
       	});
       	
    	$("#btn_del").hide();
    });

    function reloadData(){
        table.reload('tbDemo', {
      	  	url: '/admin/file/my_uploads/get_files',
        	where: {
            	name:$("#name").val(),
            	status:$("#status").val()
            }
      	});
    }

    function openFolder(id)
    {
    	var type=$("#"+id).data("type");
        if(type=="folder"){
            //文件夹
        	//当前目录id
        	cid = id.substring(1,id.length);
            reloadData(cid);
        } else{
            var img_type = "gif|jpg|jpeg|png|bmp|";
            var pdf_type = "pdf";
            var video_type = "mp4";
            var path=$("#"+id).data("path");
			var txt_type = "txt";
			var officeweb = "http://ow365.cn/?i=14593&furl=http://pan.cloudskysec.com:9080"+path;
			var word_type = "docx";
			var excel_type = "xls";
			var ppt_type = "pptx";
            if(img_type.indexOf(type.toLowerCase())>-1){
            	layer.open({
            		title:'图片',
          		  	type: 1, 
            		area: ['1000px', '550px'],
          		  	content: '<img src="'+path+'" style="width:100%; height:100%;" />' //这里content是一个普通的String
          		});
            } else if(pdf_type.indexOf(type.toLowerCase())>-1){
            	layer.open({
            		title:'pdf',
          		  	type: 1, 
            		area: ['1000px', '550px'],
          		  	content: '<a id="detail" style="width:100%; height:100%;" href="'+path+'"></a>' //这里content是一个普通的String
          		});
            	$('#detail').media({width:780, height:700});
            } else if(video_type.indexOf(type.toLowerCase())>-1){
            	layer.open({
            		title:'视频',
          		  	type: 1, 
            		area: ['1000px', '550px'],
          		  	content: '<video src="'+path+'" controls="controls" style="width:100%; height:100%;"></video>' //这里content是一个普通的String
          		});
            }else if(txt_type.indexOf(type.toLowerCase())>-1){
				layer.open({
					title:'文本文档',
					type: 1, 
					area: ['1000px', '550px'],
					maxmin: true,
					content: "<iframe width=100% height=550 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src="+officeweb+"></iframe>"//这里content是一个普通的String
				});

			}else if(word_type.indexOf(type.toLowerCase())>-1){

				layer.open({
					title:'word文档',
					type: 1, 
					maxmin: true,
					area: ['1000px', '550px'],
					content: "<iframe width=100% height=550 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src="+officeweb+"></iframe>"//这里content是一个普通的String
				});

			}else if(excel_type.indexOf(type.toLowerCase())>-1){

			layer.open({
				title:'excel文档',
				type: 1, 
				maxmin: true,
				area: ['1000px', '500px'],
				//content: "<iframe width=100% height=550 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src="+officeweb+"></iframe>"//这里content是一个普通的String
				content: "<iframe width=100% height=500 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src="+officeweb+"></iframe>"//这里content是一个普通的String		
			});

			}else if(ppt_type.indexOf(type.toLowerCase())>-1){

				layer.open({
					title:'幻灯片文档',
					type: 1, 
					maxmin: true,
					area: ['1000px', '550px'],
					//content: "<iframe width=100% height=550 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src="+officeweb+"></iframe>"//这里content是一个普通的String
					content: "<iframe width=100% height=550 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src=\"http://ow365.cn/?i=14593&furl=http://pan.cloudskysec.com:9080/uploads/file/29897246/21446c97af1b692e553f0c8a63a46736.pptx\"></iframe>"//这里content是一个普通的String		
				});

			}else {
            	layer.alert('目前不支持该格式文件的预览！');
            }
            //return;
        }
    }
</script>
<title>我的网盘</title>
</head>
<body>
<div id="content">
	<blockquote class="layui-elem-quote">
		<form class="layui-form" action="" style="float:left;">
			<div style="width:200px;margin:0 20px 0 -50px;float:left;">
                <label class="layui-form-label">状态：</label>
                <div class="layui-input-block">
                    <select name="status" id="status">
                    	<option value="" selected>所有</option>
                        <option value="1">未审核</option>
                        <option value="2">通过</option>
                        <option value="3">未通过</option>
                    </select>
                </div>
            </div>
    		<input type="text" name="name" id="name" required lay-verify="required" placeholder="请输入文件名称" autocomplete="off" class="layui-input layui-btn-sm" style="width:200px;">
		</form>
		<a href="javascript:void(0);" class="layui-btn" id="btn_query">
			查询
		</a>
		<a class="layui-btn xxx" id="refresh"><i class="layui-icon">&#x1002;</i> 刷新页面</a>
		<a href="javascript:void(0);" class="layui-btn" id="btn_del">
			删除
		</a>
		<div style="float:right;margin-right:20px;">
			<div class="layui-form-item">
                <label class="layui-form-label">当前部门：</label>
                <div class="layui-input-block">
                	<select id="dept">
                    <?php foreach($list as $i):?>
                    	<option value="<?php echo $i['ding_dept_id'] ?>" ><?php echo $i['name'] ?></option>
                    <?php endforeach;?>
                	</select>
                </div>
            </div>
		</div>
    </blockquote>
	<table id="table" lay-filter="table" class="layui-table" lay-skin="nob" lay-data="{url:'/admin/file/my_uploads/get_files?name=null&status=null', id:'tbDemo',page:true,limits:[15,20,30,50], limit:15}">
    	<thead>
    	<tr>
        	<th lay-data="{checkbox:true}"></th>
            <th lay-data="{field:'name', width:680,sort:true}">文件名称</th>
            <th lay-data="{field:'file_size', width:180,sort:true}">文件大小</th>
            <th lay-data="{field:'status', width:180,sort:true}">状态</th>
            <th lay-data="{field:'addtime', width:180,sort:true}">上传时间</th>
        </tr>
        </thead>
	</table>
</div>
</body>
</html>