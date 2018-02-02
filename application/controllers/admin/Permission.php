<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		if($this->is_login == false)
			redirect('/');
	}
	public function index()
	{
//		$this->load->model("system/role_model",'role',TRUE);
//		$where=array();
//		$data['role_list']=$this->role->get_search_list($where,0,999);
		
		$this->load->view("admin/permission/role_list");
	}
	public function role_update($id=0)
	{
		if($id == 0)
		{
			echo 'error';
			exit;
		}
		$this->load->model("system/role_model",'role',TRUE);
		$this->role->retrieve($id);
		$this->load->view("admin/permission/role_update");
	}
	public function do_role_update()
	{
		$id=$this->input->post("id",TRUE);
		$name=$this->input->post("name",TRUE);
		$type=$this->input->post("type",TRUE);
		if($id > 0)
		{
			$this->load->model("system/role_model",'role',TRUE);
			$this->role->retrieve($id);
			if($this->role->id < 1)
			{
				echo 'error';
				exit;
			}
			$this->role->name = $name;
			$this->role->type = $type;
			if($this->role->update())
				echo 'ok';
			else
				echo 'error';
		}
		else
			echo 'error';
	}
	public function role_add()
	{
		$this->load->view("admin/permission/role_add");
	}
	public function do_role_add()
	{
		$name=$this->input->post("name",TRUE);
		$type=$this->input->post("type",TRUE);
		$this->load->model("system/role_model",'role',TRUE);
		$this->role->name = $name;
		$this->role->type = $type;
		if($this->role->insert())
			echo 'ok';
		else
			echo 'error';
	}
	public function do_role_delete()
	{
		$id=$this->input->post("id",TRUE);
		if($id > 2)
		{
			$this->load->model("system/role_model",'role',TRUE);
			$this->role->retrieve($id);
			if($this->role->id == "" || $this->role->id < 1)
			{
				echo 'error';
				exit;
			}
			$this->db->trans_start();
			$this->role->delete();
			$this->load->model("system/role_rights_model","role_r",TRUE);//将角色关联的权限删除 
	        $where=array("role_id"=>$this->menu->id);
	        $this->role_r->delete_batch($where);
		 	$this->db->trans_complete();
		    if ($this->db->trans_status() === FALSE)
			{
			    echo 'error';
			}
			else
			{
				echo 'ok';
			}
		}
		else
			echo 'error';
	}
	public function role_right($id=0)
	{
		if($id == 0)
		{
			echo 'error';
			exit;
		}
		$this->load->model("system/role_model",'role',TRUE);
		$this->role->retrieve($id);
		$this->load->model("system/role_rights_model","role_r",TRUE);
		$data['menus']=$this->role_r->get_menus(2);
		$role_menus=$this->role_r->get_menus($id);
		$role_menus_ids=",";
		foreach($role_menus as $m)
		{
			$role_menus_ids.=$m['id'].',';
		}
		$data['role_menus_ids']=$role_menus_ids;
		$this->load->view("admin/permission/role_rights",$data);
	}
	public function do_role_menu_update()
	{
		$menu_ids=$this->input->post("menu_ids",TRUE);
		$menu_ids=trim($menu_ids,',');
		$role_id=$this->input->post("role_id",TRUE);
		if($menu_ids == "" || $role_id == "")
		{
			echo 'error';
			exit;
		}
		$this->load->model("system/role_rights_model","role_r",TRUE);
		$this->db->trans_start();
		
		//删除原关联关系
		$this->role_r->delete_batch(array('role_id'=>$role_id));
		$menu_ids_arr=explode(",",$menu_ids);
		$insert_batch=array();
		$time=time();
		foreach($menu_ids_arr as $m)
		{
			$insert_batch[]=array('role_id'=>$role_id,'menu_id'=>$m,'addtime'=>$time);
		}
		$this->role_r->insert_batch($insert_batch);
		
		$this->db->trans_complete();
    	if ($this->db->trans_status() === FALSE)
    		echo 'no';
    	else
    		echo 'ok';
	}
	public function get_role()
	{
		$page=$this->input->get("page",TRUE);
		$limit=$this->input->get("limit",TRUE);
		header('Content-type: application/json');
		$this->load->model("system/role_model",'role',TRUE);
		$wheres=array();
		$role_list=$this->role->get_search_list($wheres,($page-1)*$limit,$limit);
		$role_arr=array('code'=>0,'msg'=>'dd','count'=>$this->role->get_search_nums($wheres));
		$data=array();
		foreach($role_list as $m)
		{
			$data[]=array('id'=>$m['id'],'name'=>$m['name'],'type'=>$m['type']==2?"后台":"前台",'addtime'=>date('Y-m-d H:i:s',$m['addtime']));
		}
		$role_arr['data']=$data;
		echo json_encode($role_arr);
	}
}