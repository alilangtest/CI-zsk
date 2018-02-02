<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		if($this->is_login == false)
			redirect('/');
	}
	 /** 
     * This is my DocComment! 
     * 
     * @Permissons:admin:home:view 
     */
	public function index()
	{
		$this->load->view('admin/home');
	}
	public function main()
	{
		$this->load->view('admin/main');
	}

	//修改密码操作
	public function change_pass()
	{
		if(!empty($this->input->post())){

			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('oldpass', '旧密码', 'required',array('required' => '旧密码不能为空！'));
			$this->form_validation->set_rules('newpassword', '新密码', 'required|matches[repassword]',array('required' => '新密码不能为空！','matches'=>'两次密码输入不一致!'));
			$this->form_validation->set_rules('repassword', '确认密码', 'required',array('required' => '确认密码不能为空！'));
			$msg='';
			if ($this->form_validation->run() == FALSE)
			{
				$errors = $this->form_validation->error_array();//获取所有的错误信息
				$arr = array_values($errors);
				$error = $arr[0];//得到第一个错误信息
				exit(json_encode(array('status'=>0,'msg'=>$error)));
			}
			else
			{
				$old_password=$this->input->post('oldpass',TRUE);
				$new_password=$this->input->post('newpassword',TRUE);
				$old_password=md5($this->user->mobile.$old_password.'sdyt.2017');
				if($old_password == $this->user->password)
				{
					$new_password=md5($this->user->mobile.$new_password.'sdyt.2017');
					if($old_password != $new_password)
					{
						$this->user->password=$new_password;
						if ($this->user->update()){
							//session统统的清空 不留下任何东西
							$this->session->sess_destroy();
							exit(json_encode(array('status'=>1,'msg'=>"修改成功!")));
						}else{
							exit(json_encode(array('status'=>0,'msg'=>"修改失败!")));
						}
					}
					else
					{
						exit(json_encode(array('status'=>0,'msg'=>"新密码不能和原密码一样!")));
					}
				}
				else{
					exit(json_encode(array('status'=>0,'msg'=>"原密码错误!")));
				}
					
			}
		}else{
			$this->load->view('admin/show_xgmm');
		}
	}
}