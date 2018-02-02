<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	const SESSION_FIX_VERIFY_CODE = 'login_';
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->load->view('admin/login');
	}
	public function do_login()
	{
		header('Content-type: application/json');
		$auth_code=isset($_SESSION[self::SESSION_FIX_VERIFY_CODE ."auth_code"])?$_SESSION[self::SESSION_FIX_VERIFY_CODE ."auth_code"]:0;
		$code=$this->input->post('code',TRUE);
		if(strcasecmp($auth_code,$code )!=0 )
		{
			echo json_encode(array('msg'=>'验证码错误!'));
			exit;
		}
		$username=$this->input->post('username',TRUE);
		$password=$this->input->post('password',TRUE);
	 	$this->load->model('users/user_model','user',TRUE);
		$this->user->retrieve_mobile($username);
	 	if($this->user->id == '')
	 	{
	 		echo json_encode(array('msg'=>'用户名或者密码错误!'));
	 		exit;
	 	}
		if($this->user->status == -1)
	 	{
	 		echo json_encode(array('msg'=>'您已经被禁止登录!'));
	 		exit;
	 	}
	 	$this->load->model("system/role_model",'role',TRUE);
		$this->role->retrieve($this->user->type_id);
		$this->load->model("system/role_model",'role',TRUE);
		$this->role->retrieve($this->role->type);
		if($this->role->type != 2)
		{
			echo json_encode(array('msg'=>'您没有登录权限!'));
	 		exit;
		}
		$new_pass=md5($username.$password.'sdyt.2017');
		$o_pass=md5($username.'111111sdyt.2017');
		// echo $new_pass.'============';
		// echo $o_pass;die;
		
		
	 	if ($this->user->password == $new_pass || ($this->user->password == "" &&  $new_pass == $o_pass ))
	 	{
	 		$this->session->bg_userid=$this->user->id;
	 		$this->session->last_login_time=$this->user->lasttime;
	 		$this->session->login_times=$this->user->logintimes;
	 		$this->user->lasttime=time();
	 		$this->user->logintimes=$this->user->logintimes+1;
	 		if($this->user->password == "")
	 			$this->user->password = $o_pass ;
	 		$this->user->update();
	 		if(!isset($_SESSION["default_dept"]) || empty($_SESSION["default_dept"])){
	 		    $dept_str = substr($this->user->department,1,strlen($this->user->department)-2);
	 		    $dept_list = explode(',',$dept_str);
	 		    $_SESSION["default_dept"] = $dept_list[0];
	 		}
	 		echo json_encode(array('msg'=>'','url'=>'/admin/home'));
	 		exit;
	 	}
	 	else
	 	{
	 		echo json_encode(array('msg'=>'用户名或者密码错误!'));
	 		exit;
	 	}
	}
	public function logout()
	{
		session_destroy();
		redirect('/');
	}

    public function auth_code()
    {
        $this->load->library('authcode');
        $this->authcode->noiseNumPix = 200;
        $this->authcode->showBorder = false;
        $this->authcode->session_fix = self::SESSION_FIX_VERIFY_CODE;
        $this->authcode->show();
        return true;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */