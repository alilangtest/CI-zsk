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
<script type="text/javascript" src="/public/js/uiid.js"></script>
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
.layui-unselect.layui-form-checkbox{
	top:0px !important;
	margin-top:5px !important;
}
</style>
<script>
	var table=null;
	var pid=0; //上一级目录id
	var cid=0; //当前目录id
	var req_id="";
	var timer1;
    $(document).ready(function() {
    	layui.use('table', function(){
    	    table = layui.table;
    	});
		$('#refresh').click(function() { window.location.reload();});

    	$("#btn_download").click(function(){
    		var checkStatus = table.checkStatus('tbDemo');
    		var data = checkStatus.data;
    		var id_type = '';
    		for(var i=0;i<data.length;i++){
    			var type = '';
    			if(data[i].file_size=="-"){
    				type = "folder";
            	} else {
            		type = "file";
                }
    			id_type +=$($(data[i].name)[1]).data("id")+"_"+type+",";
        	}
        	if(id_type.indexOf("folder")>-1){
        		layer.alert('只能选择文件下载！');
        		return;
            }
            if(id_type==''){
            	layer.alert('请选择要下载的文件！');
        		return;
            }
            req_id = Math.uuid(32);
        	var links='/admin/file/files/do_download?sel_rows=' + encodeURI(id_type) +'&req_id='+req_id;
        	$("#btn_download").attr("href",links);
        	layer.open({
                type: 1,
                title: false, //不显示标题栏,
                closeBtn: false,
                area: '300px;',
                shade: 0.8,
                id: 'LAY_layuipro', //设定一个id，防止重复弹出
                btnAlign: 'c',
                moveType: 1 ,//拖拽模式，0或者1
                content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;" id="i_msg">服务器处理中，请稍等！</div>',
                success: function(layero){
                	timer1=window.setInterval(get_download_status,1000); 
                	$("#btn_download").attr("href",links);
            	}
        	});
       	});

    });

    function get_download_status(){
		$.post("/admin/file/files/get_download_status","req_id="+req_id,function(data){
			$("#i_msg").text(data.msg);
			if(data.status == 2)
			{
				window.clearInterval(timer1);
				layer.close(layer.index);
				layer.alert(data.msg, {icon: 1});
			}	
							
        },'json');
	}

    function reloadData(id,sid){
    	table.reload('tbDemo', {
      	  	url: '/admin/file/files/share_list/'+id+'/'+sid
      	});
        if(id==0){
      		$("#dir").html("<span>全部文件</span>");
        } else {
        	//获取当前目录的父级目录
            $.post('/admin/file/files/get_dirs',"id="+cid,function(data){
            	var data = JSON.parse(data);
            	if(data.length>0){
            		var dir = '<a href="javascript:void(0);" data-type="folder" id="d'+data[data.length-1].parentid
            			+'" onclick="openFolder(this.id);">返回上一级</a><span>|</span><a href="javascript:void(0);" data-type="folder" id="d0" onclick="openFolder(this.id);" >全部文件</a>';
    				for(var i=0;i<data.length;i++){
                    	if(i == data.length-1){
                    		dir +="<span>></span><span>"+data[i].name+"</span>";
                        } else {
                        	dir +="<span>></span><a href='javascript:void(0);' data-type='folder' id='d"+data[i].id+"' onclick='openFolder(this.id);'>"+data[i].name+"</a>";
                        }
                    }
                    $("#dir").html(dir);
                }
            	
    		},'text');
        }
    }

    function openFolder(id)
    {
        var type=$("#"+id).data("type");
        if(type=="folder"){
            //文件夹
        	//当前目录id
        	cid = id.substring(1,id.length);
        	//分享表中的id
        	var sid = $("#"+id).data("sid")
            reloadData(cid,sid);
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
		<a href="javascript:void(0);" class="layui-btn" id="btn_download">
			下载
		</a>
		<button class="layui-btn xxx" id="refresh"><i class="layui-icon">&#x1002;</i> 刷新页面</button>
    </blockquote>
    <div id="dir">
		<span id="all">全部文件</span>
	</div>
	<table id="table" lay-filter="table" class="layui-table" lay-skin="nob" lay-data="{url:'/admin/file/files/share_list', id:'tbDemo'}">
    	<thead>
    	<tr>
        	<th lay-data="{checkbox:true}"></th>
            <th lay-data="{field:'name', width:680,sort:true}">文件名称</th>
            <th lay-data="{field:'file_size', width:180,sort:true}">文件大小</th>
            <th lay-data="{field:'dept_name', width:180,sort:true}">所属部门</th>
            <th lay-data="{field:'to_dept_name', width:180,sort:true}">分享部门</th>
            <th lay-data="{field:'share_validity', width:180,sort:true}">到期时间</th>
        </tr>
        </thead>
	</table>
</div>
</body>
</html>