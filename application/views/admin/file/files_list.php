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
	var sel_rowid='';
	var sel_type='';
	var count = 0;
	var move = <?php echo $move; ?>;
	var del = <?php echo $del; ?>;
	var share = <?php echo $share; ?>;
	var rename = <?php echo $rename; ?>;
	var req_id="";
	var timer1;
    $(document).ready(function() {
    	layui.use('table', function(){
    	    table = layui.table;
        	table.on('checkbox(table)', function(obj){
        		var checkStatus = table.checkStatus('tbDemo'); //test即为基础参数id对应的值
  		    	if(checkStatus.data.length > 0)
  		    	{
  	  		    	if(move==1){
  	  	  		    	$("#btn_move").show();
  	  	  		    } else{
  	  	  	  		  	$("#btn_move").hide();
  	  	  	  		}
  	  	  		    if(del==1){
	  	  		    	$("#btn_del").show();
	  	  		    } else{
	  	  	  		  	$("#btn_del").hide();
	  	  	  		}
  	  	  	  		if(share==1){
  	  	  		    	$("#btn_share").show();
  	  	  		    } else{
  	  	  	  		  	$("#btn_share").hide();
  	  	  	  		}
  	  	  	  	  	if(checkStatus.data.length==1 && checkStatus.data[0].file_size=='-'&&rename==1){
    	  	  		    //只选择一个文件夹，显示重命名
  	    				$("#btn_rename").show();
    	  	  		}else{
      	  	  	  		$("#btn_rename").hide();
    	  	  	  	}
    	  	  	  	
  		    		$("#btn_download").show();
  	  		    }
  		    	else
  		    	{
  		    		btnHide();
  	  		    }
  	  		    
      		});
			  $('#refresh').click(function() { window.location.reload();});
    	});
    	$('#upload').click(function() {
    		layer.open({
    			title:'文件上传',
    			area: ['800px', '500px'],
    			type: 2, 
    			cancel: function(){ 
    				reloadData(cid);
    			},
    			content: '/admin/file/files/files_upload/'+ cid //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
      		}); 
    	});
    
    	$("#dept").change(function(){
    		//改变session
    		$.post('/admin/file/files/change_session',"id="+$("#dept").val(),function(data){
				window.location.reload();
			},'text');
    	});
    	
    	$("#dept").find("option[value='<?php echo $_SESSION["default_dept"] ?>']").attr("selected",true);

    	$('#add').click(function() {
    		layer.open({
    			title:'新建目录',
    			area: ['800px', '500px'],
    			type: 2, 
    			content: '/admin/file/files/folder_add_page/'+cid   
      		});
    	});

    	$("#btn_move").click(function(){
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
    			id_type +=data[i].id+"_"+type+",";
        	}
    		layer.open({
    			title:'移动到',
    			area: ['500px', '400px'],
    			type: 2, 
    			content: '/admin/file/files/move_page?sel_rows='+encodeURI(id_type)+'&dirid='+cid ,
    			cancel: function(){ 
    				reloadData(cid);
    				btnHide();
    			},
      		});
       	});

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
    			id_type +=data[i].id+"_"+type+",";
        	}
        	if(id_type.indexOf("folder")>-1){
        		layer.alert('只能选择文件下载！');
        		return;
            }
            req_id = Math.uuid(32);
        	var links='/admin/file/files/do_download?sel_rows=' + encodeURI(id_type)+'&req_id='+req_id;
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

    	$("#btn_del").click(function(){
    		var checkStatus = table.checkStatus('tbDemo');
    		var data = checkStatus.data;
    		var id_type = '';
    		
    		if(data.length>0){
    			for(var i=0;i<data.length;i++){
        			var type = '';
        			if(data[i].file_size=="-"){
        				type = "folder";
                	} else {
                		type = "file";
                    }
        			id_type +=data[i].id+"_"+type+",";
            	}
        	}
            if(confirm("是否确定要删除选择文件？一旦删除，过程不可逆，请慎重！")){
                $.post("/admin/file/files/do_delete","sel_rows="+id_type,function(data){
                	layer.alert(data,{icon: 8},function(index){
                		layer.close(index);
                		reloadData(cid);
                		btnHide();
                    });
                });
            }
       	});

    	$("#btn_share").click(function(){
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
    			id_type +=data[i].id+"_"+type+",";
        	}
    		layer.open({
    			title:'分享',
    			area: ['500px', '500px'],
    			type: 2, 
    			content: '/admin/file/files/share_page?sel_rows='+encodeURI(id_type) ,
    			cancel: function(){ 
    				reloadData(cid);
    				btnHide();
    			},
      		});
       	});

    	$("#btn_rename").click(function(){
    		var checkStatus = table.checkStatus('tbDemo');
    		var data = checkStatus.data[0];
    		var dir_id = '';
    		if(data.file_size=="-"){
    			dir_id = data.id;
        	}
    		layer.open({
    			title:'目录修改',
    			area: ['500px', '500px'],
    			type: 2, 
    			content: '/admin/file/files/folder_update_page?dir_id='+dir_id+'&cid='+cid,
    			cancel: function(){ 
    				reloadData(cid);
    			},
      		});
       	});
    	//隐藏按钮
    	btnHide();
    });

    function btnHide(){
    	$("#btn_move").hide();
    	$("#btn_download").hide();
    	$("#btn_del").hide();
    	$("#btn_share").hide();
    	$("#btn_rename").hide();
    }

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
					area: ['1000px', '530px'],
					content: "<iframe width=100% height=530 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src="+officeweb+"></iframe>"//这里content是一个普通的String
				});

			}else if(excel_type.indexOf(type.toLowerCase())>-1){

				layer.open({
					title:'excel文档',
					type: 1, 
					maxmin: true,
					area: ['1000px', '550px'],
					//content: "<iframe width=100% height=550 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src="+officeweb+"></iframe>"//这里content是一个普通的String
		            content: "<iframe width=100% height=550 name=\"touzizuhe\" id=\"touzizuhe\" frameborder=0 src=\"http://ow365.cn/?i=14593&furl=http://pan.cloudskysec.com:9080/uploads/file/29897246/2f912017d1c35f308d205a2905a908ce.xls\"></iframe>"//这里content是一个普通的String		
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

    function reloadData(id){
        table.reload('tbDemo', {
      	  	url: '/admin/file/files/get_files/'+id
      	});
      	if(cid==0){
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
      	sel_rowid='';
    }

	

    
</script>
<title>我的网盘</title>
</head>
<body>
<div id="content">
	<blockquote class="layui-elem-quote">
       	<a href="javascript:void(0);" class="layui-btn" id="upload" >
			<i class="layui-icon">&#xe67c;</i> 文件上传
		</a>
		<a href="javascript:void(0);" class="layui-btn" id="add">
			<i class="layui-icon">&#xe61f;</i> 新建文件夹
		</a>
		<a class="layui-btn xxx" id="refresh"><i class="layui-icon">&#x1002;</i> 刷新页面</a>
		<a href="javascript:void(0);" class="layui-btn" id="btn_download">
			下载
		</a>
		<a href="javascript:void(0);" class="layui-btn" id="btn_share">
			分享
		</a>
		<a href="javascript:void(0);" class="layui-btn" id="btn_move">
			移动到
		</a>
		<a href="javascript:void(0);" class="layui-btn" id="btn_del">
			删除
		</a>
		<a href="javascript:void(0);" class="layui-btn" id="btn_rename">
			重命名
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
	<div id="dir">
		<span id="all">全部文件</span>
	</div>
	<table id="table" lay-filter="table" class="layui-table" lay-skin="nob" lay-data="{url:'/admin/file/files/get_files', id:'tbDemo'}">
    	<thead>
    	<tr>
        	<th lay-data="{checkbox:true}"></th>
            <th lay-data="{field:'name', width:680,sort:true}">文件名称</th>
            <th lay-data="{field:'file_size', width:180,sort:true}">文件大小</th>
            <th lay-data="{field:'addtime', width:180,sort:true}">增加时间</th>
        </tr>
        </thead>
	</table>
	<ul id="dowebok"></ul>
</div>
</body>
</html>