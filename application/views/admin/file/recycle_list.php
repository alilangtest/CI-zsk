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
</style>
<script>
	var table=null;
	var pid=0; //上一级目录id
	var cid=0; //当前目录id
	var sel_rowid='';
	var sel_type='';
	var count = 0;
	var req_id="";
	var timer1;
    $(document).ready(function() {
    	layui.use('table', function(){
    	    table = layui.table;
        	table.on('checkbox(table)', function(obj){
        		var checkStatus = table.checkStatus('tbDemo'); //test即为基础参数id对应的值
  		    	if(checkStatus.data.length == 1)
  		    	{
  		    		$("#btn_recovery").show();
  	  		   	} else{
  	  	  		   	$("#btn_recovery").hide();
  	  	  		}
      		});
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
    		var sel_rows = '';
    		var date = (new Date()).Format("yyyy-MM-dd hh:mm:ss");
    		if(data.length>0){
    			for(var i=0;i<data.length;i++){
        			var type = '';
                    if(time_comparison(data[i].endtime,date)){
                    	if(data[i].file_size=="-"){
            				type = "folder";
            				sel_rows +=data[i].id+"_"+type+"_"+data[i].endtime+",";
                    	} else {
                    		type = "file";
                    		var path = $("#"+data[i].id).attr('data-path');
                    		sel_rows +=data[i].id+"_"+type+"_"+data[i].endtime+"_"+path+",";
                        }
                    	
                    } else{
                    	layer.alert('不能删除有效期内的文件或者文件夹！');
                    	return;
                    }
            	}
        	}
        	if(sel_rows==''){
        		layer.alert('不能删除有效期内的文件或者文件夹！');
			}
            if(confirm("是否确定要删除选择文件？一旦删除，过程不可逆，请慎重！")){
                $.post("/admin/file/recycle/do_delete","sel_rows="+sel_rows,function(data){
                	layer.alert(data,{icon: 8},function(index){
                		layer.close(index);
                		reloadData();
                    });
                });
            }
       	});
       	
    	$("#btn_recovery").click(function(){
    		var checkStatus = table.checkStatus('tbDemo');
    		var data = checkStatus.data[0];
    		var type = '';
			if(data.file_size=="-"){
				type = "folder";
        	} else {
        		type = "file";
            }
    		var id_type = data.id+'_'+type;
    		layer.open({
    			title:'恢复到',
    			area: ['500px', '400px'],
    			type: 2, 
    			content: '/admin/file/recycle/recovery_page?id_type='+id_type,
    			cancel: function(){ 
    				reloadData();
    			},
      		});
       	});
       	
    	$("#btn_recovery").hide();
    });

    function time_comparison(endtime,nowtime){ 
        var end = new Date(endtime.replace("-", "/").replace("-", "/"));  
        var now = new Date(nowtime.replace("-", "/").replace("-", "/"));  
        if(nowtime < endtime){    
            return false;    
        } else{
        	return true;
        }
    }
    
    function openFolder(id)
    {
        var type=$("#"+id).data("type");
        if(type=="folder"){
            //文件夹
        	//当前目录id
        	//cid = id.substring(1,id.length);
            //reloadData(cid);
        } else{
            var img_type = "gif|jpg|jpeg|png|bmp|";
            var pdf_type = "pdf";
            var video_type = "mp4";
            var path=$("#"+id).data("path");
            if(img_type.indexOf(type.toLowerCase())>-1){
            	layer.open({
            		title:'图片',
          		  	type: 1, 
            		area: ['800px', '500px'],
          		  	content: '<img src="'+path+'" style="width:100%; height:100%;" />' //这里content是一个普通的String
          		});
            } else if(pdf_type.indexOf(type.toLowerCase())>-1){
            	layer.open({
            		title:'pdf',
          		  	type: 1, 
            		area: ['800px', '700px'],
          		  	content: '<a id="detail" style="width:100%; height:100%;" href="'+path+'"></a>' //这里content是一个普通的String
          		});
            	$('#detail').media({width:780, height:700});
            } else if(video_type.indexOf(type.toLowerCase())>-1){
            	layer.open({
            		title:'视频',
          		  	type: 1, 
            		area: ['800px', '700px'],
          		  	content: '<video src="'+path+'" controls="controls" style="width:100%; height:100%;"></video>' //这里content是一个普通的String
          		});
            } else {
            	layer.alert('目前不支持该格式文件的预览！');
            }
            //return;
        }
    }
    
    Date.prototype.Format = function(format){ 
    	var o = { 
    	"M+" : this.getMonth()+1, //month 
    	"d+" : this.getDate(), //day 
    	"h+" : this.getHours(), //hour 
    	"m+" : this.getMinutes(), //minute 
    	"s+" : this.getSeconds(), //second 
    	"q+" : Math.floor((this.getMonth()+3)/3), //quarter 
    	"S" : this.getMilliseconds() //millisecond 
    	}
    	if(/(y+)/.test(format)) { 
    		format = format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length)); 
		}
    	for(var k in o) { 
        	if(new RegExp("("+ k +")").test(format)) { 
        		format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));    
        	 } 
    	} 
    	return format; 

    }
    function reloadData(){
        table.reload('tbDemo', {
      	  	url: '/admin/file/recycle/get_files'
      	});
    }
</script>
<title>我的网盘</title>
</head>
<body>
<div id="content">
	<blockquote class="layui-elem-quote">
		<a href="javascript:void(0);" class="layui-btn" id="btn_del">
			删除
		</a>
		<a href="javascript:void(0);" class="layui-btn" id="btn_recovery">
			恢复
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
	<table id="table" lay-filter="table" class="layui-table" lay-skin="nob" lay-data="{url:'/admin/file/recycle/get_files', id:'tbDemo'}">
    	<thead>
    	<tr>
        	<th lay-data="{checkbox:true}"></th>
            <th lay-data="{field:'name', width:680,sort:true}">文件名称</th>
            <th lay-data="{field:'file_size', width:180,sort:true}">文件大小</th>
            <th lay-data="{field:'updatetime', width:180,sort:true}">删除时间</th>
            <th lay-data="{field:'endtime', width:180,sort:true}">结束时间</th>
        </tr>
        </thead>
	</table>
</div>
</body>
</html>