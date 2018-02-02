<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_rights extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		if($this->is_login == false)
			redirect('/');
	}
	public function index()
	{
	    $this->load->model('users/Department_model','dept',TRUE);
	    $where = array();
	    $depts = $this->dept->getlist($where,0,99999);
	    $data['depts'] = $depts;
	    $this->load->model('users/User_model','user',TRUE);
	    $data['users'] = $this->user->get_all();
		$this->load->view("admin/permission/user_dept_list",$data);
	}

	public function get_users()
	{
	    $deptid = $this->input->post("id",TRUE);
	    if($deptid == 0)
	    {
	        echo 'error';
	        exit;
	    }
	    $this->load->model("system/User_dept_model","ud",TRUE);
	    $wheres=array();
	    $where = array();
	    $where["deptid"] = $deptid;
	    $wheres["where"] = $where;
// 	    $data['users']=$this->ud->get_users($deptid);
	    $data['list']=$this->ud->get_search_list($wheres,0,99999);
	    echo json_encode($data['list']);
	}

	function save_data()
	{
	    $deptid = $this->input->post("deptid",TRUE);
		$userid = $this->input->post("userid",TRUE);
// 	    $userids=trim($userids,',');
	    $operids = $this->input->post("operids",TRUE);

	    if(empty($deptid)||empty($userid)){
	        echo "error";
	        exit;
	    }
	    $this->load->model("system/User_dept_model","ud",TRUE);
	    $this->db->trans_start();
	    $this->ud->delete_batch(array('deptid'=>$deptid,'ding_userid'=>$userid));
        if($operids!=null && $operids!=""){
            $operids=trim($operids,',');
            $operids_arr=explode(",",$operids);
            $insert_batch=array();
            $time=time();
            foreach($operids_arr as $o)
            {
                $insert_batch[]=array('deptid'=>$deptid,'ding_userid'=>$userid,'operation_id'=>$o,'addtime'=>$time,'status'=>1);
            }
            $this->ud->insert_batch($insert_batch);
        }
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
    		echo 'no';
    	else
            echo 'ok';
	}

	function get_operation()
	{
	    $deptid = $this->input->post("deptid",TRUE);
	    $userid = $this->input->post("userid",TRUE);
	    if(empty($deptid)||empty($userid)){
	        echo "error";
	        exit;
	    }
	    $this->load->model("system/User_dept_model","ud",TRUE);
	    $wheres=array();
	    $where = array();
	    $where["deptid"] = $deptid;
	    $where["ding_userid"] = $userid;
	    $wheres["where"] = $where;
	    $data['list']=$this->ud->get_search_list($wheres,0,99999);
	    echo json_encode($data['list']);
	}
}
