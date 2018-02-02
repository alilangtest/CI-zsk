<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		if($this->is_login == false)
			redirect('/');
	}
	public function index()
	{
	    $this->load->model("system/role_rights_model","role_r",TRUE);
		$data['menus']=$this->role_r->get_menus(2);
		$this->load->view('/admin/menu/menu_index',$data);
	}
	
	public function get_menu_detail() 
	{
	    $id = $this->input->post("id");
	    if (empty($id)) 
	    {
	        echo "error";
	        exit;
	    }
	    $this->load->model("system/Menu_model","menu",TRUE);
	    $this->menu->retrieve($id);
	    $arr=array('url'=>$this->menu->url,'icon'=>$this->menu->icon,'sort'=>$this->menu->sort);
	    echo json_encode($arr);
	}
	
	public function save_menu() 
	{
	    $id = $this->input->post("id");
	    $name = $this->input->post("name");
	    $url = $this->input->post("url");
	    $icon = $this->input->post("icon");
	    $sort = $this->input->post("sort");
	    if (empty($id)) 
	    {
	        echo "error";
	        exit;
	    }
	    $this->load->model("system/Menu_model","menu",TRUE);
	    $this->menu->retrieve($id);
	    $this->menu->name = $name;
	    $this->menu->url = $url;
	    $this->menu->icon = $icon;
	    $this->menu->sort = $sort;
	    $this->menu->update();
	    echo "ok";
	}
	
	public function do_update_insert()
	{
	    $id=$this->input->post('id',TRUE);
	    $pid=$this->input->post('pid',TRUE);
	    $name=$this->input->post('name',TRUE);
	    $this->load->model("system/Menu_model","menu",TRUE);
	    if($id != null && $id != "undefined")
	    {
	        $this->menu->retrieve($id);
	        if($this->menu->id == '')
	        {
	            echo '-2';
	            exit;
	        }
	        $this->menu->name=$name;
	        if($this->menu->update())
	            echo $this->menu->id;
            else
                echo '-1';
	    }
	    else
	    {
	        $this->menu->name=$name;
	        $this->menu->parentid=$pid;
	        $this->load->model("system/Menu_model","menu2",TRUE);
	        $this->menu2->retrieve($pid);
	        $this->menu->level=$this->menu2->level+1;
	        $this->menu->sort = 10;
            if($this->menu->insert())
                echo $this->menu->id;
            else
                echo '-1';
	    }
	}
	
	public function del_menu()
	{
	    $id=$this->input->post('id',TRUE);
	    if (empty($id))
	    {
	        echo "error";
	        exit;
	    }
	    if ($this->user->type_id==2) 
	    {
	        $this->load->model("system/Menu_model","menu",TRUE);
	        $this->menu->retrieve($id);
	        if( $this->menu->id == "" || $this->menu->id < 1)
	        {
	        	
	        }
	        if ($this->menu->level==1) 
	        {
	            $wheres=array();//总查询条件
	            $where=array();
	            $wheres['where']="parentid='$id'";
	            $num = $this->menu->get_search_nums($wheres);
	            if($num>0){
	                echo "请先删除该菜单下所有子菜单！";
	                exit;
	            }
	        }
	        $this->db->trans_start();
	        $this->menu->delete();
	        $this->load->model("system/role_rights_model","role_r",TRUE);//将菜单关联的权限删除 
	        $where=array("menu_id"=>$this->menu->id);
	        $this->role_r->delete_batch($where);
	        $this->db->trans_complete();
		    if ($this->db->trans_status() === FALSE)
			{
			    echo "删除失败！";
			}
			else
			{
				echo "删除成功！";
			}
	    } else {
	        echo "删除权限不足！";
	    }
	}
}