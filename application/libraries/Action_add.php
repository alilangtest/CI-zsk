<?php
/**
 * Created by PhpStorm.
 * Date: 2017/11/28
 * Time: 10:49
 * 干啥滴：日志增加类  统一调用此类当中的方法
 * author：huxiaobai
 */
 class Action_add
 {
   public function __construct()
   {
       $this->CI = & get_instance();
   }

   //直接写成tjrz也行 此处方法名纯属装B
   //单个审核
   public function increase_operating($action = '',$column_name = '',$username = '',$bs){
     if($action == '' || $column_name == '' || $username == ''){
       exit('缺少必要参数!');
     }
     $this->CI->load->model('system/Actions_logs_model','actions_logs',true);
     $this->CI->actions_logs->name = $action; //行为名称
     $this->CI->actions_logs->executor = $username;//执行者
     $this->CI->actions_logs->column = $column_name;//作用于栏目
     $content = $username."用户于".date('Y年m月d日 H时i分s秒').$action.'了'."'".$bs."'记录";
     $this->CI->actions_logs->content = $content;//提示内容
     $st = $this->CI->actions_logs->insert();
     return $st;
   }

    //批量审核
    public function increase_operating_all($data = array()){
      if(empty($data)){
        exit('缺少必要参数!');
      }
      $this->CI->load->model('system/Actions_logs_model','actions_logs',true);
      $st = $this->CI->db->insert_batch('actions_logs',$data);
      return $st;
    }
 }
?>
