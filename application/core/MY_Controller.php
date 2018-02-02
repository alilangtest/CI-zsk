<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    /**
     * 当前路径记忆  为cookie
     */
    const COOKIE_CURRENT_PATH = "CURRENTPATH";
    /**
     * 当前路径记忆的过期时间 为cookie
     * 单位：秒
     */ 
    const COOKIE_CURRENT_PATH_EXPIRE = 1800;
    /**
     * header View
     * @var array|string 
     */
    protected $header_view;
    /**
     * data for headerView
     * @var object|array|string 
     */
    protected $header_data;
    /**
     * menu View
     * @var array|string 
     */
    protected $menu_view;
    /**
     * data for menuView
     * @var object|array|string 
     */
    protected $menu_data; 
    /**
     * body View
     * @var array|string 
     */
    protected $body_view;
    /**
     * data for bodyView
     * @var object|array|string 
     */
    protected $body_data;
    /**
     * footer View
     * @var array|string 
     */
    protected $footer_view;
    /**
     * data for footerView
     * @var object|array|string 
     */
    protected $footer_data;
    /**
     * user logined  is or no
     * @var boolean 
     */
    protected $is_login;

    public function __construct()
    {
        parent::__construct();

        $this->header_view = null;
        $this->header_data = null;
        $this->body_view = null;
        $this->body_data = null;
        $this->footer_view = null;
        $this->footer_data = null;
        $this->is_login = false;
        $this->load->model('users/user_model','user',TRUE);       
        if($this->is_loginning())
            $this->is_login = true;
    }

    /**
     * render view pages.If viewPath exit then show,else logout.
     * @return null
     * @author zw  
     */
    public function render()
    {
        $this->header_data['is_login'] = $this->is_login;
        
        if($this->is_login)
        {
            $this->header_data['user_login'] = $this->user;
        }
            
        
        if(empty($this->header_view))
            $this->header_view = 'header';
        
        $this->load->view($this->header_view, $this->header_data);
        
        if(empty($this->body_view))
            $this->body_view = 'index';
        
        if(is_array($this->body_view) && count($this->body_view) > 0)
        {
            $this->load->view(array_shift($this->body_view), $this->body_data);

            if(count($this->body_view) > 0)
            {
                foreach ($this->body_view as $view)
                {
                    $this->load->view($view);
                }
            }
        }
        else
            $this->load->view($this->body_view, $this->body_data);
        
        if(empty($this->footer_view))
            $this->footer_view = 'footer';
        
        $this->load->view($this->footer_view, $this->footer_data);
    }

    /**
     * 判断用户是否登陆 同时生成 user object
     * @param type $fix default loginning of user
     * @return boolean
     */
    protected function is_loginning()
    {
        if(!$this->remember_path())
            return false;
        $uri_string='/'.uri_string();
        if(strpos($uri_string,"admin/") == 1)
        {
        	$userid = $this->session->bg_userid;
        	
//        	$c_uri= uri_string();
//        	$c_uris=explode("/",$c_uri);
//        	$_method=null;
//        	$method=null;
//        	foreach ($c_uris as $k=>$v)
//        	{
//        		try 
//        		{
//        			$_method=isset($c_uris[$k+1])?$c_uris[$k+1]:"index";
//        			$method = new ReflectionMethod($v, $_method);    
//        			if(is_object($method))
//        				break;    			
//        		}
//        		catch(Exception $e) 
//        		{
////					echo $e;
//        		}
//        	}
//        	$tag='@Permissons';
//        	$matches = array(); 
//		    preg_match("/".$tag.":(.*)(\\r\\n|\\r|\\n)/U", $method->getDocComment(), $matches); 
//		
//		    if (isset($matches[1])) 
//		    { 
//		        echo trim($matches[1]); 
//		    } 
	    
//        exit;
        }
        else
        	$userid = $this->session->userid;
        if(empty($userid))
            return false;
        if(!$this->user->retrieve($userid))
        {
            return false;
        }
        //检查动作超时
//        if(User_verify::USER_LOGIN == $this->user_verify->type)
//        {
//            $online_time = intval(get_cookie(User::ON_LINE_TIME));
//            
//            if($online_time < time())
//            {
//                $this->user->id = 0;
//                $this->clear_cookie_login();
//                return false;
//            }
//        }
    	//检测角色、权限
		if($this->user->type_id > 0)
		{
			$this->load->model("system/role_model","role",TRUE);
			$this->role->retrieve($this->user->type_id);
			if($this->role->id > 0 && $this->role->type == 2)
			{
				$this->load->model("system/role_rights_model","role_r",TRUE);
				$menus=$this->role_r->get_menus($this->role->id);
				$this->user->_menu=$menus;
			}
		}
        if(!$this->checking_user())
            return false;       
        return true;
    }
    
    /**
     * Check vip_expirsion status islock of user
     * Get avatar counter_message of user
     * @return boolean
     */
    private function checking_user()
    {
        if($this->user->isEmpty())
            return false;
        return true;
    }

    /**
     * Remeber current path for user
     * @return boolean
     */
    private function remember_path()
    {
        $first_url = $this->uri->segment(1);
        $second_url = $this->uri->segment(2);
        
//        if((!$this->input->is_ajax_request()) && empty($_GET) && empty($_POST) 
//            && (!in_array($first_url, $this->config->item('no_remember_paths_first'))) && (!in_array($second_url, $this->config->item('no_remember_paths_second'))))
//        {
//            set_cookie(self::COOKIE_CURRENT_PATH, "/" . $this->uri->uri_string(), self::COOKIE_CURRENT_PATH_EXPIRE);
//        }
        
        return true;
    }
    
    /**
     * 生成验证码
     * @return boolean
     */
    protected function auth_code()
    {
        $this->load->library('authcode');
        
        return true;
    }
    
    /**
     * 检查是否已经登录
     * @author: wq
     * @date: 2014-05-15 13:45
     */
    protected function check_login()
    {
    	if($this->user->isEmpty())
    	{
            redirect('/signin');
    	}
    }
    
    /**
     * 生成令牌
     * @param key 传入其它参数进行加密 
     * @author: wq
     * @date: 2014-05-16 16:24
     */
    protected function generate_token($key = '')
    {
    	$ip = $this->input->ip_address();
    	$user_agent = $this->input->user_agent();
        
    	return md5($key . $ip . $user_agent . mt_rand(1000, 9999) . time());
    }
    
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */

