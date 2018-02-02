<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * Date: 2017/11/27
 * Time: 16:49
 * 干啥滴：用户行为日志类
 * author：huxiaobai
 */
class Behavior_log extends MY_Controller{
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

    //行为日志展示
    public function behavior_list(){
        $arr = $this->input->get();
        // print_r($arr);die;
        $where = array();
        if(!empty($arr['column'])){
          // $where = "column = "."'".$arr['column']."'";
          $where['column'] = $arr['column'];
        }
        if(!empty($arr['action'])){
          // $where .= " and name = "."'".$arr['action']."'";
          $where['name'] = $arr['action'];
        }
        if(!empty($arr['startime']) && !empty($arr['endtime'])){
          $where['addtime > '] = strtotime($arr['startime']);
          $where['addtime < '] = strtotime($arr['endtime']);
        }
        $wheres['where'] = $where;
        $this->load->model('system/Actions_logs_model','actions_logs',true);
        //分页
        $this->load->library('pagination');//装载类文件
        //每一页显示的数据条数的变量
        $page_size=9;
        $config['base_url']=site_url("admin/knowledge/behavior_log/behavior_list/");
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
        $config['total_rows']=$this->actions_logs->get_search_nums($wheres,1,100000);//总的记录数
        $this->pagination->initialize($config);
        $offset=intval($this->uri->segment(5));//用intval使空格转0，显示出来0
        $data['situation'] = $this->actions_logs->get_search_list($wheres,$offset,$page_size);
        $data['total_rows'] = $config['total_rows'];
        $this->load->view('/admin/knowledge/behavior_list',$data);
    }

    //删除操作
    public function del_action(){
      exit(json_encode(array('status'=>0,'msg'=>"做啥亏心事了?想删日志?死了这条心吧!")));
      //判断当前用户是否有删除权限
      $this->load->model('different/Intellectual_rights_model','intrights',true);
      $ty = 5;
      $operation_id = 1;
      $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
      if($num < 1){
          exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权删除日志!')));
      }

      $ids = $this->input->post('id',TRUE);
      if($ids == null){
          exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数!')));
      }
      $ids = trim($ids);
      $arr = explode(',',$ids);
      $this->load->model('system/Actions_logs_model','actions_logs',true);
      foreach($arr as $v){
        $this->actions_logs->retrieve($v);
        //为对象赋值之后首先要检测合法性
        if($this->actions_logs->id == '' || $this->actions_logs->id < 1)
        {
            exit("error");
        }
        $st = $this->actions_logs->delete();
      }
      if($st == false){
        exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误,请联系管理员!')));
      }
      exit(json_encode(array('status'=>1,'msg'=>'日志删除成功!')));

    }
}
?>
