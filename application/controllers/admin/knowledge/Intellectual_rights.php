<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * Date: 2017/11/07
 * Time: 11:02
 * 干啥滴：知识库权限分配
 * author：huxiaobai
 */
class Intellectual_rights extends MY_Controller{
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

    //权限分配页面展示
    public function rights_view(){
        $this->load->model('users/Department_model','dept',TRUE);
	    $where = array();
	    $depts = $this->dept->getlist($where,0,99999);
	    $data['depts'] = $depts;
	    $this->load->model('users/User_model','user',TRUE);
	    $data['users'] = $this->user->get_all();
		$this->load->view("admin/knowledge/rights_view",$data);
    }

    //执行权限分配操作
    public function do_rights(){
        //接参数
        $deptid = $this->input->post("deptid",TRUE);//部门id 29897246
        $userid = $this->input->post("userid",TRUE);//员工id 465
        // $ty     = $this->input->post("ty",TRUE);//目录  1：知识分类 2：部门知识 3：公司共享 4：回收站
        $operids = $this->input->post("operids",TRUE);//权限：1：新增 2：删除 3：修改 4：分享 5：恢复    1,2,
        //验证 $deptid  $userid  $ty一定会是数字类型   $operids为字符串类型 如果为空前端即提示错误信息
        if(!is_numeric($deptid) || empty($operids)){
            exit(json_encode(array('status'=>0,'msg'=>'亲!缺少必要参数!')));
        }
        //此处处理复杂的字符串 [1][1],[1][2],[1][3],[1][4],[2][1],[3][1],[4][1],
        $qxids = explode(',',trim($operids,','));
        $this->load->model('different/Intellectual_rights_model','intrights',true);

        //开启事物
        $this->db->trans_start();
        $this->intrights->retrieve_del($userid);
        foreach($qxids as $v){
            $ty_oper = explode('][',rtrim(ltrim($v,'['),']'));
            $ty = $ty_oper[0];//前端故意这么设计 下标为0表示的是ty->目录  1：知识分类 2：部门知识 3：公司共享 4：回收站
            $oper = $ty_oper[1];//前端故意这么设计 下标为1表示的是operation_id->权限：1：新增 2：删除 3：修改 4：分享 5：恢复
            //如此  $ty => $oper 就可以代表该用户对某个目录的某项权限了！

            //执行添加操作
            $this->intrights->ding_userid = $userid; //hsl
            $this->intrights->deptid = $deptid;
            $this->intrights->ty = $ty;
            $this->intrights->operation_id = $oper;
            $this->intrights->status = 1;
            $this->intrights->insert();
        }
        //提交事物
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            exit(json_encode(array('status'=>0,'msg'=>'权限分配失败!')));
        }
        exit(json_encode(array('status'=>0,'msg'=>'权限分配成功!')));
    }


    public function get_users()
	{
	    $deptid = $this->input->post("id",TRUE);
	    if(!is_numeric($deptid))
	    {
	        echo 'error';
	        exit;
	    }
	    $this->load->model('different/Intellectual_rights_model','intrights',true);
	    $wheres=array();
	    $where = array();
	    $where["deptid"] = $deptid;
	    $wheres["where"] = $where;
	    $data['list']=$this->intrights->get_search_list($wheres,0,99999);
	    echo json_encode($data['list']);
	}


    public function get_operation()
	{
        // echo "wahahaha123";die;
	    $deptid = $this->input->post("deptid",TRUE);
	    $userid = $this->input->post("userid",TRUE);
	    if(empty($deptid)||empty($userid)){
	        echo "error";
	        exit;
	    }
        $this->load->model('different/Intellectual_rights_model','intrights',true);
	    $wheres=array();
	    $where = array();
	    $where["deptid"] = $deptid;
	    $where["ding_userid"] = $userid;
	    $wheres["where"] = $where;
        $data['list']=$this->intrights->get_search_list($wheres,0,99999);
        // print_r($data['list']);die;
	    echo json_encode($data['list']);
	}

}
?>
