<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>云天网盘</title>
	<script src="/public/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/public/layui/layui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/public/font-awesome/css/font-awesome.min.css">
    <style type="text/css">
		.my-logo{position: absolute;left:0;top: 0;width: 200px;height: 100%;line-height: 40px;text-align: center;color: #009688;font-size: 16px;}
		.layui-nav .layui-nav-item{line-height:40px;}
		.layui-nav .layui-nav-more{top:15px;}
		.layui-nav-child{top:40px;}
		.nav_right div{float:left;}
		iframe{border:0px;}
		#quit {width:50px; height:40px; background:url(/public/admin/images/quit.png) no-repeat center 7px;}
		#quit:hover { background-color:#000; cursor:pointer;  }
		#all { width:50px; height:40px; background:url(/public/admin/images/hover.png) no-repeat center top;}
		#all:hover { background-color:#000; cursor:pointer;  }
		#home {width:50px; height:40px; background:url(/public/admin/images/home2.png) no-repeat center 7px;}
		#home:hover { background-color:#000; cursor:pointer;  }
		#cache {width:50px; height:40px; background:url(/public/admin/images/cache.png) no-repeat center 7px;}
		#cache:hover { background-color:#000; cursor:pointer;  }
	</style>
	<script type="text/javascript">
	var cur_nav_id="";
	var element="";
	$(function() {
		var layer = null ;
//		var nav_flag = true;
		var layui_tab_content_height=$(".layui-body").height()-$(".layui-tab-title").height();
		var layui_tab_content_width=$(".layui-body").width();
		layui.use(['element','layer'], function(){
			element = layui.element;
			layer = layui.layer;
			element.on('nav(left_menu)', function(data){
				var html=$(data.context.innerHTML);
				var url=html.data("url");
				var id=html.data("id");
				cur_nav_id=id;
				var title=html.data("title");
				var content = "";
				if(url != undefined && id != undefined && title != undefined && url != '' && id != "" && title !="")
				{
					if($("#layui-tab li[lay-id='"+id+"']").length < 1)
					{
						content = '<iframe src="' + url + '" id="if-' + id + '"></iframe>';
						element.tabAdd('demo',{
							title:title,
							content:content,
							id:id
						  });
						element.tabChange('demo', id);
					}
					else
						element.tabChange('demo', id);
					$("#if-"+id).height(layui_tab_content_height-50);
					$("#if-"+id).width(layui_tab_content_width);
				}		
			  });
			element.on('tab(demo)', function(data){
				if($(this).attr("lay-id") != undefined)
				{
					cur_nav_id=$(this).attr("lay-id");
				} 
			});
			content = '<iframe src="/admin/home/main" id="if-main"></iframe>';
			element.tabAdd('demo',{
				title:'管理首页',
				content:content,
				id:'main'
			  });
			$("#if-main").height(layui_tab_content_height-50);
			$("#if-main").width(layui_tab_content_width);
			element.tabChange('demo', 'main');
		});
		$('#cache').click(function() {
			layer.confirm('确定要清空所有缓存吗？', {icon: 3, title:'提示'}, function(index){
				  layer.close(index);
				});
		});                                                                       
		$('#home').click(function() {
			window.top.location.href="/admin/home";
		});
		$('#quit').click(function(event) {
			layer.confirm('确定要退出吗？', {icon: 3, title:'提示'}, function(index){
			  layer.close(index);
			  window.top.location.href="/admin/login/logout";
			});
		});
		//修改密码
		$("#xgmm").click(function(){
			layer.open({
                    type: 2,
                    title:"修改密码",
                    area: ['700px', '280px'],
                    fixed: false, //不固定
                    maxmin: true,
                    content: '/admin/home/change_pass/'
                });
		});

	

	
	});
	</script>
</head>
<body>

<div class="layui-layout layui-layout-admin" style="min-width: 1200px;">
  <div class="layui-header" style="height: 40px;">
  		<div class="my-logo"><img src="/public/images/logo.png"  style="width: 100px;"/></div>
<!--    <div class="layui-logo">山东云天安全服务平台   --Powered by 山东云天平台研发部</div>    -->
    <!-- 头部区域（可配合layui已有的水平导航） -->
<!--   <ul class="layui-nav layui-layout-left">-->
<!--      <li class="layui-nav-item"><a href="javascript:void(0);">控制台</a></li>-->
<!--      <li class="layui-nav-item"><a href="javascript:void(0);">用户</a></li>-->
<!--      <li class="layui-nav-item">-->
<!--        <a href="javascript:;">其它系统</a>-->
<!--        <dl class="layui-nav-child">-->
<!--          <dd><a href="javascript:void(0);">邮件管理</a></dd>-->
<!--          <dd><a href="javascript:void(0);">消息管理</a></dd>-->
<!--          <dd><a href="javascript:void(0);">授权管理</a></dd>-->
<!--        </dl>-->
<!--      </li>-->
<!--    </ul>-->
    <div class="nav_right" style="float: right;">
    	<div id="cache" title="清空缓存"></div>
		<div id="home" title="首页"></div>
		<div id="all" title="全局导航"></div>
		<div id="quit" title="退出登录"></div>
    </div>
    <ul class="layui-nav" style="float: right;">
      <li class="layui-nav-item">
        <a href="javascript:;"><?php echo $this->user->mobile;?></a>
        <dl class="layui-nav-child">
          <dd><a href="javascript:void(0);">基本资料</a></dd>
          <dd><a href="javascript:void(0);" id="xgmm">修改密码</a></dd>
        </dl>
      </li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black" style="top:40px;">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="left_menu">
      
      	<?php 
      		$menu_list='';
      		$i=1;
			foreach($this->user->_menu as $m)
			{
				if($m['level'] == 1)
				{
					$menu_list .='<li class="layui-nav-item"><a href="javascript:void(0);">'.$m['name'].'</a>';
					$sub_menu_list='';
					foreach($this->user->_menu as $m2)
					{
						if($m2['parentid'] == $m['id'])
						{
							$sub_menu_list.=' <dd><a href="javascript:void(0);" id="p'.$i.'"  data-id="p'.$i++.'" data-title="'.$m2['name'].'" data-url="'.$m2['url'].'">&gt;&nbsp;&nbsp;'.$m2['name'].'</a></dd>';
						}
					}
					if($sub_menu_list !='')
						$sub_menu_list='<dl class="layui-nav-child">'.$sub_menu_list.'</dl>';
					$menu_list .=$sub_menu_list.'</li>';	
				}
			}
			echo $menu_list;
      	?>
      </ul>
    </div>
  </div>
  
  <div class="layui-body" style="top:40px;">
    <!-- 内容主体区域 -->
		    <div class="layui-tab" id="layui-tab" lay-filter="demo" lay-allowClose="true">
				  <ul class="layui-tab-title"></ul>
				  <div class="layui-tab-content"></div>
				</div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    2017 © cloudskysec.com - Powered by 山东云天安 - 全研发部
  </div>
</div>
</body>
</html>