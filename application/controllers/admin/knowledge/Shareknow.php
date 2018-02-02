<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/1
 * Time: 16:13
 * author：huxiaobai
 * 干啥滴：共享知识类
 */
class Shareknow extends MY_Controller{
    const COLUMN_NAME = "公司共享";
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

    //公司共享知识列表(查询 分享到 当前用户所在部门的 共享知识)
    public function share_list(){

        //查询该用户所属部门
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
        $this->load->model('different/Action_log_model','action',true);
        $kw = $this->input->get('kw',TRUE);
//        echo $kw;die;
        if($kw && $kw != ' '){
            //这里严谨的话就不能仅仅根据单一项来查找  而是多个都可以查找！ 比如按照名称 id  发布人等！
            $where = " article_share.status = 1  and (articles.title like '%$kw%' OR  user.name like '%$kw%' OR nd_different.tname like '%$kw%') ";
        }
        if(isset($where)){
            $where .= " AND article_share.to_deptid = ".$_SESSION["default_dept"]." AND article_share.status = 1";
        }else{
            $where = " article_share.to_deptid = ".$_SESSION["default_dept"]." AND article_share.status = 1 ";
        }
        $wheres['where'] = $where;
//        print_r($where);die;
        //分页
        $this->load->library('pagination');//装载类文件
        //每一页显示的数据条数的变量
        $page_size=9;
        $config['base_url']=site_url("/admin/knowledge/Shareknow/share_list/");
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
        $count = count($this->article_share->get_search_list1($wheres));//总的记录数
        $config['total_rows']=$count;
        $this->pagination->initialize($config);
        $offset=intval($this->uri->segment(5));//用intval使空格转0，显示出来0
        $data['situation'] = $this->article_share->get_search_list1($wheres,$offset,$page_size);
        $data['total_rows'] = $config['total_rows'];
        $tj['where'] = "to_deptid = ".$_SESSION['default_dept'];
        $data['num'] = $this->action->get_search_nums($tj);
//        print_r($data['situation']);die;
        $this->load->view('/admin/knowledge/share_list',$data);
    }

    //查看单条记录信息
    public function single_info($id = ''){
        if($id == ''){
            exit('缺少必要参数!');
        }
        //判断该条记录如果过期 那么我们进禁止查看

        $this->load->model('different/Article_share_model','article_share',true);
        $wheres['where'] = "article_share.article_id = $id ";
        //直接使用get_search_list1方法来查询  不用再自己写！
        $arr = $this->article_share->get_search_list1($wheres,0,1);
        // if(strtotime($arr[0]['share_validity']) < time()){
        //     exit("<script>alert('此文章已经过期!请自行删除!');</script>");
        // }
        foreach($arr[0] as $k=>$v){
            $dt[$k] = $v;
        }
        $data['arr'] = $dt;
//        print_r($data);die;
        $this->load->view('/admin/knowledge/single_info',$data);
    }

    //共享知识的删除
    public function del_share(){

        //判断当前用户是否有删除权限
        $this->load->model('different/Intellectual_rights_model','intrights',true);
        $ty = 3; //1代表公司分享
        $operation_id = 2;//2代表删除
        $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
        if($num < 1){
            exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权删除此分享!')));
        }
        $arr = $this->input->post();
        if(empty($arr)){
            exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数!')));
        }
        $ids = trim($arr['id']);
        $arr = explode(',',$ids);
        $this->load->model('different/Article_share_model','article_share',true);
        $this->load->model('different/Article_model','article',true);
        //循环修改记录当中的status = 0;
        foreach($arr as $v){

            $this->article_share->retrieve($v);
            $this->article->retrieve($this->article_share->article_id);
            //为对象赋值之后首先要检测合法性
            if($this->article_share->id == '' || $this->article_share->id < 1)
            {
                exit("error");
            }
            $this->article_share->status = 0;
            $st = $this->article_share->update();
            if($st){
              //确定删除成功之后我们再此操作写入日志表当中
              $this->load->library('action_add');
              $stt = $this->action_add->increase_operating('删除',self::COLUMN_NAME,$this->user->name,$this->article->title);
              if($stt == false){
                log_message('error','公司共享知识日志写入失败!');
              }
            }
        }
        if($st == false){
            exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
        }

        exit(json_encode(array('status'=>1,'msg'=>'知识分享删除成功!')));
    }

    //展示公司共享当中的消息提醒内容（内容为:个人知识 部门知识当中删除了的但是已经分享到公司的内容在消息列表展示）
    public function show_action_message(){
        //根据session查询出分享到该部门已经被删除了的文章
        $this->load->model('different/Action_log_model','action',TRUE);
        $wheres['where'] = "to_deptid = ".$_SESSION['default_dept'];
        $data['list'] = $this->action->get_search_list($wheres);
        $this->load->view('/admin/knowledge/show_action_message',$data);
    }
    //删除消息列表记录
    public function action_del(){

         //判断当前用户是否有删除权限
         $this->load->model('different/Intellectual_rights_model','intrights',true);
         $ty = 3; //3代表公司分享
         $operation_id = 6;//6代表消息列表删除权限
         $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
         if($num < 1){
             exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权删除此分享!')));
         }


        $arr = $this->input->post();
        if(empty($arr)){
            exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数!')));
        }
        $ids = trim($arr['id']);
        $arr = explode(',',$ids);
        $this->load->model('different/Action_log_model','action',true);
        //循环修改记录当中的status = 0;
        foreach($arr as $v){
            $this->action->retrieve($v);
            //为对象赋值之后首先要检测合法性
            if($this->action->id == '' || $this->action->id < 1)
            {
                exit("error");
            }
            $st = $this->action->delete();
        }
        if($st == false){
            exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
        }
        exit(json_encode(array('status'=>1,'msg'=>'消息列表删除成功!')));

    }


}

?>
