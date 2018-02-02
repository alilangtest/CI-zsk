<?php 
class Exec_job {

    public $_base_controller;
            
    public function __construct() 
    { 
//        $this->_base_controller = &get_instance();
    }
    
    /**
     * Object index running
     * @return boolean
     */
    public function running($uri = '',$parameters='')
    {
//    	$uri="jobs/wechat subscribe ";
//    	$parameters="fgfgfgfgfgfgfgfg 1";
        if($uri == '')
            return false;
  		$running_path = 'php /var/www/cloudsky/index.php jobs/';
        $running_path .= $uri;
        $redirect_address = ' > /dev/null 2>&1 &';
        $exec_path = $running_path . " " . $parameters . $redirect_address;
        exec($exec_path);
        
        return true;
    }
    
    
}


/* End of file Exec_job.php */
/* Location: ./application/controllers/jobs/jobs_running.php */