<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_uploads extends MY_Controller {
	const COLUMN_NAME="我的上传";
	function __construct()
	{
		parent::__construct();
		if($this->is_login == false)
			redirect('/');
	}

	public function index()
	{
	    $this->load->model('users/Department_model','dept',TRUE);
	    $dept_str = trim(trim($this->user->department,"]"),"[");
	    $dept_ids = explode(',',$dept_str);
	    $data_list = $this->dept->get_depts($dept_ids);
	    foreach ($dept_ids as $id){
	        $list = $this->dept->get_children($id);
	        foreach ($list as $l){
	            if (strpos('.'.$dept_str, $l['ding_dept_id'])>0)
	            {
	                continue;
	            } else {
	                $data_list[] = $l;
	                $dept_str = $dept_str.','.$l['ding_dept_id'];
	            }
	        }
	    }
	    $data['list'] =$data_list;
	    $this->load->view('/admin/file/my_uploads',$data);
	}

    public function get_files()
    {
        $page=$this->input->get("page",TRUE);
        $limit=$this->input->get("limit",TRUE);
        $name = $this->input->get("name",TRUE);
        $status = $this->input->get("status",TRUE);
        $deptid = $_SESSION["default_dept"];
        header('Content-type: application/json');
        $this->load->model("file/files_model",'file',TRUE);

        $wheres=array();
        $where = array();
        $where['deptid']=$deptid;
        $where['ding_userid'] = $this->user->ding_userid;
        $wheres['where'] = $where;
        if($status!='null' && !empty($status)){
            $status = array($status);
        } else {
            $status = array("1","2","3");
        }
        $where_in = array('status'=>$status);
        $wheres['where_in'] = $where_in;
        if($name!='null' && !empty($name)){
            $wheres['like'] = array('name'=>$name);
        }
        $files_list=$this->file->get_search_list($wheres,($page-1)*$limit,$limit);
        $files_arr=array('code'=>0,'msg'=>'ok','count'=>$this->file->get_search_nums($wheres));
        $data=array();
        foreach($files_list as $m)
        {
            $size = $m['file_size'];
            if($size/1024 >1024){
                $size = round($size/1024/1024, 2).'M';
            }else{
                $size = round($size/1024).'KB';
            }
            $status = '';
            switch ($m['status']){
                case '1':
                    $status = '未审核';
                    break;
                case '2':
                    $status = '通过';
                    break;
                case '3':
                    $status = '未通过';
                    break;
                default:
                    break;

            }
            $data[]=array('id'=>$m['id'],'name'=>'<img src= "'.$m['file_icon'].'" />'.'<a href="javascript:void(0);" id="'.$m['id'].'" data-type="'.$m['file_type'].'"  data-path="'.$m['file_path'].'" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>$size,'status'=>$status,'addtime'=>date('Y-m-d H:i:s',$m['addtime']));
        }
        $files_arr['data']=$data;
        echo json_encode($files_arr);
    }

    public function do_delete()
    {
        $ids = $this->input->post("ids",TRUE);
        $ids = trim($ids,',');
        if(empty($ids)){
            echo "error";
            exit;
        }
        $this->load->model("file/files_model",'file',TRUE);
        $ids_arr = explode(',', $ids);
        $ids = array();
        foreach ($ids_arr as $k=>$v){
            $ids[]=$v;
        }
        $wheres = array();
        $where_in = array('id'=>$ids_arr);
        $wheres['where_in'] = $where_in;
        $files_list = $this->file->get_search_list($wheres,0,99999);
        //逻辑删除列表
        $update_arr = array();
        //物理删除列表
        $delete_arr = array();
        $del_path_arr = array();
		$action_infos = array();//存放日志信息 后期批量插入到数据库 hsl
		$time = time();
        foreach ($files_list as $f){
            //判断是否审核通过或者不是此用户上传的文件
            if($f['status']==2 || $f['ding_userid'] != $this->user->ding_userid){
                echo "权限不足！";
                exit;
            } else{
                $id = $f['id'];
                if($f['status']==1){
                    $update_arr[] = array('id'=>$id,'status'=>-1,'updatetime'=>$time);
										$action_infos[] = array('name'=>'删除','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."删除了".$f['name']."该文章未进行审核!",'addtime'=>time());
                } else if($f['status']==3){
                    $delete_arr[]=$id;
                    $del_path_arr[] = $f['file_path'];
										$action_infos[] = array('name'=>'删除','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."删除了".$f['name']."该文章审核不通过!",'addtime'=>time());
                }
                continue;
            }
        }
        $this->db->trans_start();
		if(count($update_arr) > 0){
		    $this->file->update_batch($update_arr);
		}
		if(count($delete_arr) > 0){
		    $this->file->delete_batch(array('id'=>$delete_arr));
		}
		if(count($del_path_arr) > 0){
		    foreach ($del_path_arr as $k=>$v){
		        unlink('.'.$v);
		    }
		}

		$this->load->library('action_add');
		$stt = $this->action_add->increase_operating_all($action_infos);
		if($stt == false){
			log_message('error','删除个人上传日志写入失败!');
		}

	 	$this->db->trans_complete();
	    if ($this->db->trans_status() === FALSE)
		{
		    echo 'error';
		}
		else
		{
			echo '删除成功！';
		}
    }
}
