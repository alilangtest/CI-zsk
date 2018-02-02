<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/3
 * Time: 8:54
 * author：huxiaobai
 * 干啥滴：回收站类
 */
class Recycle extends MY_Controller
{
    const COLUMN_NAME = "知识回收站";
    function __construct()
    {
        parent::__construct();
        if($this->is_login == false)
            redirect('/');
    }

    public function index()
    {
        exit('error');//让敌人扑个空
    }

    //回收站列表内容为 个人 部门 以及 公司分享 3个栏目当中删除掉的记录
    public function recycle_list(){
        // print_r($_SESSION["default_dept"]);die;   //43859148  29897246  29872738
        //查询当前用户所属部门
        $this->load->model('users/Department_model','dept',TRUE);
	    $dept_str = trim(trim($this->user->department,"]"),"[");
	    $dept_ids = explode(',',$dept_str);
	    $data_list = $this->dept->get_depts($dept_ids);
	    foreach ($dept_ids as $id){
	        $list = $this->dept->get_children($id);
	        foreach ($list as $l){
	            if (strpos('.'.$dept_str, $l['ding_dept_id'])>0)
	            {
	                continue;
	            } else {
	                $data_list[] = $l;
	                $dept_str = $dept_str.','.$l['ding_dept_id'];
	            }
	        }
	    }
        $data['list'] =$data_list;//当前用户所属部门

        $this->load->model('different/Article_share_model','article_share',true);
        $kw = $this->input->get('kw',TRUE);
//        if($kw && $kw != '请输入关键词'){
//            //这个地方我们需要用到联合查询;
//            //这里严谨的话就不能仅仅根据单一项来查找  而是多个都可以查找！ 比如按照名称 id  发布人等！
//            //$where = "articles.title like '%$kw%' OR articles.id like '%$kw%' OR department.name like '%$kw%' OR user.name like '%$kw%' ";
//        }
//        if(isset($where)){
//            $where .= " AND article_share.to_deptid = ".$_SESSION["default_dept"]." AND article_share.status = 0 " ;
//        }else{
//            $where = " article_share.to_deptid = ".$_SESSION["default_dept"]." AND article_share.status = 0 ";
//        }
//        $wheres['where'] = $where;
        //分页
        $this->load->library('pagination');//装载类文件
        //每一页显示的数据条数的变量
        $page_size=9;
        $config['base_url']=site_url("/admin/knowledge/Recycle/recycle_list/");
        $config['uri_segment']=5;
        $config['num_links'] = 2;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-14">';
        $config['full_tag_close'] = '</div>';
        $config['first_tag_open'] = '<span class="my">';
        $config['first_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>';
        $config['cur_tag_close'] = '</em></span>';
        $config['last_tag_open'] = '<span class="my">';
        $config['last_tag_close'] = '</span>';

        $config['per_page']=$page_size;
        $config['next_link']= '下一页';
        $config['prev_link']= '上一页';
        $config['last_link'] = '末页';
        $config['first_link'] = '首页';

        //涉及搜索 又涉及到链表查询 无法使用框架当中的get_search_list;
        $config['total_rows']=count($this->article_share->get_reclaim_list());
        $this->pagination->initialize($config);
        $offset=intval($this->uri->segment(5));//用intval使空格转0，显示出来0
        $data['situation'] = $this->article_share->get_reclaim_list($offset,$page_size);
        $data['total_rows'] = $config['total_rows'];
        // print_r($data['situation']);die;
        $this->load->view('/admin/knowledge/recycle_list',$data);
    }


      /*
       *删除操作
       *解释一下：ly 表示的是来源 这里的来源表示的是来自于哪张表 ly = -1 和 ly = 1 都是来自articles    ly = 2 来自于article_share表；
       *         yid 表示的是这条记录在对应的表当中的id值；
       * 这样做意义是：我们得根据ly知道去哪张表删除yid哪条记录；
       * 这样做的原因是：因为涉及到了两张不同表的删除操作！
       * */
    public function del_hs(){

        //判断当前用户是否有新增权限
        $this->load->model('different/Intellectual_rights_model','intrights',true);
        $ty = 4; //4代表回收站
        $operation_id = 2;//1代表新增
        $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
        if($num < 1){
            exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权删除此文章!')));
        }

       //Array( [ly] => -1,-1,2 [yid] => 1,2,2)    或者是 Array( [ly] => -1 [yid] => 1)
        $datas = $this->input->post();
        if(empty($datas)){
            exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数!')));
        }
        //进行数据的验证
        $lys = explode(',',$datas['ly']);//Array( [0] => -1 [1] => -1 [2] => 2)
        $yids = explode(',',$datas['yid']);//Array( [0] => 1 [1] => 2 [2] => 2)
        if(count($lys) != count($yids)){
            exit(json_encode(array('status'=>0,'msg'=>'很奇葩的致命数据缺失错误!')));
        }
        //下面执行删除逻辑
        $this->load->model('different/Article_model','article',true);
        $this->load->model('different/Article_share_model','article_share',true);
        foreach($lys as $k=>$v){

           if($v == -1 or $v == 1){
           //在这里判断 如果$v = -1 或者 1 那么就去articles表当中删除$yids[$k]的记录； -1：个人知识 1：部门知识  统一放在了articles一张表当中
              $this->article->retrieve($yids[$k]);
              $tname = $this->article->title;
              $st = $this->article->delete();
              if($st){
                //确定插入成功之后我们再此操作写入日志表当中
                $this->load->library('action_add');
                $stt = $this->action_add->increase_operating('删除',self::COLUMN_NAME,$this->user->name,$tname);
                if($stt == false){
                  log_message('error','知识回收站日志写入失败!');
                }
              }
           }elseif($v == 2){
           //如果$v=2 那么就去删除article_share表当中的记录 article_share表当中存放的是公司共享的文章；
              $this->article_share->retrieve($yids[$k]);
              $this->article->retrieve($this->article_share->article_id);
              $tname = $this->article->title;
              $st = $this->article_share->delete();
              if($st){
                //确定插入成功之后我们再此操作写入日志表当中
                $this->load->library('action_add');
                $stt = $this->action_add->increase_operating('删除',self::COLUMN_NAME,$this->user->name,$tname);
                if($stt == false){
                  log_message('error','知识回收站日志写入失败!');
                }
              }
           }
        }

        if($st == false){
            exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
        }
        exit(json_encode(array('status'=>1,'msg'=>'回收站文章删除成功!')));

    }

    //回收站恢复操作
    public function reinstate(){

        //这里我们要添加权限验证
        $datas = $this->input->post();
        if(empty($datas)){
            exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数!')));
        }
        //进行数据的验证
        $lys = explode(',',$datas['ly']);//Array( [0] => -1 [1] => -1 [2] => 2)
        $yids = explode(',',$datas['yid']);//Array( [0] => 1 [1] => 2 [2] => 2)
        // print_r($lys);
        // echo "======";
        // print_r($yids);die;
        if(count($lys) != count($yids)){
            exit(json_encode(array('status'=>0,'msg'=>'很奇葩的致命数据缺失错误!')));
        }
        //下面执行删除逻辑
        $this->load->model('different/Article_model','article',true);
        $this->load->model('different/Article_share_model','article_share',true);
        foreach($lys as $k=>$v){
            //如果是对部门知识和公司共享知识进行删除我们是要判断权限的
            if($v == 1 or $v == 2){
                //判断当前用户是否有恢复权限
                $this->load->model('different/Intellectual_rights_model','intrights',true);
                $ty = 4; //4代表回收站
                $operation_id = 5;//5代表恢复
                $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
                if($num < 1){
                    exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权恢复此文章!')));
                }
            }
            if($v == -1 or $v == 1){
            //在这里判断 如果$v = -1 或者 1 那么就去articles表当中删除$yids[$k]的记录； -1：个人知识 1：部门知识  统一放在了articles一张表当中
               $this->article->retrieve($yids[$k]);
               if($this->article->id == '' || $this->article->id < 1)
               {
                   exit("error");
               }
               $this->article->status = 1;
               $st = $this->article->update();
               if($st){
                 //确定插入成功之后我们再此操作写入日志表当中
                 $this->load->library('action_add');
                 $stt = $this->action_add->increase_operating('恢复',self::COLUMN_NAME,$this->user->name,$this->article->title);
                 if($stt == false){
                   log_message('error','知识回收站恢复日志写入失败!');
                 }
               }
            }elseif($v == 2){
            //如果$v=2 那么就去删除article_share表当中的记录 article_share表当中存放的是公司共享的文章；
            // echo $yids[$k];die;
               $this->article_share->retrieve($yids[$k]);
               if($this->article_share->id == '' || $this->article_share->id < 1)
               {
                   exit("error");
               }
               $this->article->retrieve($this->article_share->article_id);
               $this->article_share->status = 1;
               $st = $this->article_share->update();
               if($st){
                 //确定插入成功之后我们再此操作写入日志表当中
                 $this->load->library('action_add');
                 $stt = $this->action_add->increase_operating('恢复',self::COLUMN_NAME,$this->user->name,$this->article->title);
                 if($stt == false){
                   log_message('error','知识回收站恢复日志写入失败!');
                 }
               }
            }
         }

         if($st == false){
            exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
        }
            exit(json_encode(array('status'=>1,'msg'=>'回收站文章恢复成功!')));


    }

}
