<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sync extends CI_Controller {
	public $key="sdyt.oo.sdyt";
	/**
	 * 同步用户和部门信息
	 * 
	 * */
	public function sync_users_depts()
	{
		
		//同步用户
		$this->load->model("system/sync_model","sync",TRUE);
		$this->load->model("users/user_model","user",TRUE);
		$this->sync->retrieve(1);
		if($this->sync->last_id == "" || $this->sync->last_id < 1)
		{
			$this->sync->last_id = 0;
			$this->sync->update();
		}
		$time=time();
		$resp=file_get_contents("http://office.cloudskysec.com/api/users/get_users?time=".$time."*sign=".md5($time.$this->key)."&time=".$time."&star_id=".$this->sync->last_id);
		$resp = json_decode($resp,TRUE);
		$user_batch_data=array();
		
		if($resp['code'] == 0 && count($resp['data']) > 0)
		{
			$user_batch_data=array();
			foreach($resp['data'] as $d)
			{
				$user_batch_data[]=array(
								"type_id"=>1,
								"openid"=>$d["openid"],
								"ding_userid"=>$d["ding_userid"],
								"name"=>$d["name"],
								"tel"=>$d["tel"],
								"work_place"=>$d["work_place"],
								"remark"=>$d["remark"],
								"mobile"=>$d["mobile"],
								"email"=>$d["email"],
								"org_email"=>$d["org_email"],
								"active"=>$d["active"],
								"order_in_depts"=>$d["order_in_depts"],
								"is_admin"=>$d["is_admin"],
								"is_boss"=>$d["is_boss"],
								"dingid"=>$d["dingid"],
								"unionid"=>$d["unionid"],
								"is_leader_in_depts"=>$d["is_leader_in_depts"],
								"is_hide"=>$d["is_hide"],
								"department"=>$d["department"],
								"position"=>$d["position"],
								"avatar"=>$d["avatar"],
								"jobnumber"=>$d["jobnumber"],
								"extattr"=>$d["extattr"],
								"roles"=>$d["roles"],
								"status"=>1,
								"type"=>2
							);
			}
			$last_user=end($resp['data']);
			$this->sync->last_id=$last_user['id'];
			
			$this->db->trans_start();
			$this->user->insert_batch($user_batch_data);
			$this->sync->update();
			$this->db->trans_complete();
		}
		//同步离职用户
		$time=time();
		$resp=file_get_contents("http://office.cloudskysec.com/api/users/get_users?time=".$time."*sign=".md5($time.$this->key)."&time=".$time."&star_id=0&status=-1");
		
		$resp = json_decode($resp,TRUE);
		$user_update_batch_data=array();
		
		if($resp['code'] == 0 && count($resp['data']) > 0)
		{
			$user_batch_data=array();
			foreach($resp['data'] as $d)
			{
				$user_update_batch_data[]=array(
								"mobile"=>$d["mobile"],
								"status"=>$d["status"]
							);
			}
			$this->user->update_batch($user_update_batch_data,"mobile");
		}
		
		//同步部门
		$this->sync->retrieve(2);
		if($this->sync->last_id == "" || $this->sync->last_id < 1)
		{
			$this->sync->last_id = 0;
			$this->sync->update();
		}
		$time=time();
		$resp=file_get_contents("http://office.cloudskysec.com/api/users/get_depts?time=".$time."*sign=".md5($time.$this->key)."&time=".$time."&star_id=".$this->sync->last_id);
		$resp = json_decode($resp,TRUE);
		$dept_batch_data=array();
		
		if($resp['code'] == 0 && count($resp['data']) > 0)
		{
			foreach($resp['data'] as $d)
			{
				$dept_batch_data[]=array("ding_dept_id"=>$d["ding_dept_id"],
										"name"=>$d["name"],
										"ding_parentid"=>$d["ding_parentid"],
										"order"=>$d["order"],
										"create_dept_group"=>$d["create_dept_group"],
										"auto_add_user"=>$d["auto_add_user"],
										"dept_hiding"=>$d["dept_hiding"],
										"dept_permits"=>$d["dept_permits"],
										"user_permits"=>$d["user_permits"],
										"org_dept_owner"=>$d["org_dept_owner"],
										"dept_manager_userid_list"=>$d["dept_manager_userid_list"],
										"is_leaf"=>$d["is_leaf"]
				);
			}
			$last_dept=end($resp['data']);
			$this->sync->last_id=$last_dept['id'];
			$this->load->model("users/Department_model","dept",TRUE);
			$this->db->trans_start();
			$this->dept->insert_batch($dept_batch_data);
			$this->sync->update();
			$this->db->trans_complete();
		}
	}
}
