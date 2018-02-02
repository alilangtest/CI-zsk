<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Recycle extends MY_Controller {
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
	    $this->load->view('/admin/file/recycle_list',$data);
	}

	public function get_files()
	{
	    //管理人员获取当前部门下所有删除的目录和文件，其他人员只能查看自己上传和新建的文件夹
	    $this->load->model("system/User_dept_model","ud",TRUE);
	    $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>6);
	    $nums = $this->ud->count_nums($where);
	    $is_manager = false;
	    if($nums[0]['nums'] > 0){
	        $is_manager = true;
	    }
	    $deptid = $_SESSION["default_dept"];
	    header('Content-type: application/json');
	    $this->load->model("file/directory_model","dir",TRUE);
	    $data=array();
	    $where=array();
	    $where['deptid'] = $deptid;
	    $where['status']= 0;
	    if(!$is_manager){
	        $where['ding_userid']= $this->user->ding_userid;
	    }
	    $dir_list=$this->dir->getlist($where);
	    foreach($dir_list as $m)
	    {
	        $endtime = $m['updatetime']+2*24*3600;
	        $data[]=array('id'=>$m['id'],'name'=>'<img src="/public/images/file/folder.png">'.'<a href="javascript:void(0);" id="f'.$m['id'].'" data-type="folder" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>'-','updatetime'=>date('Y-m-d H:i:s',$m['updatetime']),'endtime'=>date('Y-m-d H:i:s',$endtime));
	    }
	    $this->load->model("file/files_model",'file',TRUE);

	    $wheres=array();
	    $where = array();
	    $where['deptid']=$deptid;
	    $where['status']=-1;
	    if(!$is_manager){
	        $where['ding_userid']= $this->user->ding_userid;
	    }
	    $wheres['where'] = $where;
	    $files_list=$this->file->get_search_list($wheres,0,9999);
	    $files_arr=array('code'=>0,'msg'=>'ok');

	    foreach($files_list as $m)
	    {
	        $size = $m['file_size'];
	        if($size/1024 >1024){
	            $size = round($size/1024/1024, 2).'M';
	        }else{
	            $size = round($size/1024).'KB';
	        }
	        $endtime = $m['updatetime']+2*24*3600;
	        $data[]=array('id'=>$m['id'],'name'=>'<img src= "'.$m['file_icon'].'" />'.'<a href="javascript:void(0);" id="'.$m['id'].'" data-type="'.$m['file_type'].'"  data-path="'.$m['file_path'].'" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>$size,'updatetime'=>date('Y-m-d H:i:s',$m['updatetime']),'endtime'=>date('Y-m-d H:i:s',$endtime));
	    }
	    $files_arr['data']=$data;
	    echo json_encode($files_arr);
	}

	public  function do_delete()
	{
	    //先判断是否有删除权限
	    $this->load->model("system/User_dept_model","ud",TRUE);
	    $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>6);
	    $nums = $this->ud->count_nums($where);
	    if($nums[0]['nums']<1){
	        echo "没有权限！";
	        exit;
	    }
	    $sel_rows = $this->input->post("sel_rows",TRUE);
	    if(empty($sel_rows)){
	        echo "error";
	        exit;
	    }
	    $time = time();
	    $sel_rows = trim($sel_rows,',');
	    $sel_rows_arr = explode(',', $sel_rows);
	    $dir_arr = array();
	    $file_arr = array();
	    $dir_path_arr = array();
	    $file_path_arr = array();
	    $this->load->model("file/directory_model","dir",TRUE);
	    $this->load->model("file/files_model",'file',TRUE);
	    foreach ($sel_rows_arr as $sel_row){
	        $sel_row_arr = explode('_', $sel_row);
	        $id = $sel_row_arr[0];
	        $type = $sel_row_arr[1];
	        $endtime = $sel_row_arr[2];
	        if($time > strtotime($endtime)){
	            //有效期内，物理删除
	            if($type=="folder"){
	                $dir_arr[] = $id;
	                $pdirs = $this->dir->get_dirs($id);
	                $dir_path = './uploads/file/'.$_SESSION["default_dept"];
	                foreach ($pdirs as $pdir){
	                    $dir_path = $dir_path.'/'.$pdir['id'];
	                }
	                $dir_path_arr[] = $dir_path;
	                $cildren_dirs = $this->dir->get_childrens($id);
	                foreach ($cildren_dirs as $cildren_dir){
	                    $dir_arr[] = $cildren_dir['id'];
	                    $wheres = array();
	                    $where = array();
	                    $where['deptid']=$_SESSION['default_dept'];
	                    $where['directory_id']=$cildren_dir['id'];
	                    $where['status']=-1;
	                    $wheres['where'] = $where;
	                    $children_files=$this->file->get_search_list($wheres,0,9999);
	                    foreach ($children_files as $children_file){
	                        $file_arr[] = $children_file['id'];
	                        $file_path_arr[] = $children_file['file_path'];
	                    }
	                }
	                $wheres = array();
	                $where = array();
                    $where['deptid']=$_SESSION['default_dept'];
                    $where['directory_id']=$id;
                    $where['status']=-1;
                    $wheres['where'] = $where;
                    $children_files=$this->file->get_search_list($wheres,0,9999);
	                foreach ($children_files as $children_file){
	                    $file_arr[] = $children_file['id'];
	                    $file_path_arr[] = $children_file['file_path'];
	                }
	            } else{
	                $file_arr[] = $id;
	                $file_path_arr[] = $sel_row_arr[3];
	            }
	        } else{
	            echo "不能删除有效期内的文件或者文件夹！";
	            exit;
	        }
	    }
	    $this->db->trans_start();
	    if(!empty($dir_arr)){
	        $this->dir->delete_batch(array('id'=>$dir_arr));
	    }
	    if(!empty($file_arr)){
	        $this->file->delete_batch(array('id'=>$file_arr));
	    }
	    if(count($file_path_arr)){
	        foreach ($file_path_arr as $file_path){
	            if(file_exists('.'.$file_path)){
	                unlink('.'.$file_path);
	            }
	        }
	    }
// 	    if(count($dir_path_arr)){
// 	        foreach ($dir_path_arr as $dir_path){
// 	            if(is_dir($dir_path)){
// 	                $this->deleteAll($dir_path);
// 	                rmdir($dir_path);
// 	            }
// 	        }
// 	    }
	    $this->db->trans_complete();
	    if ($this->db->trans_status() === FALSE)
	    {
	        echo "删除失败！";
	    }
	    else
	    {
	        echo "删除成功！";
	    }
	}

	private function deleteAll($path) {
	    $op = dir($path);
	    while(false != ($item = $op->read())) {
	        if($item == '.' || $item == '..') {
	            continue;
	        }
	        if(is_dir($op->path.'/'.$item)) {
	            $this->deleteAll($op->path.'/'.$item);
	            rmdir($op->path.'/'.$item);
	        } else {
	            unlink($op->path.'/'.$item);
	        }

	    }
	}

	public function recovery_page()
	{
	    $id_type = $this->input->get('id_type',TRUE);
	    $data['id_type'] = $id_type;
	    $this->load->model("file/Directory_model","dir",TRUE);
	    $where=array();
	    $where['deptid']=$_SESSION["default_dept"];
	    $data['dirs']=$this->dir->getlist($where);
	    $this->load->view('admin/file/file_recovery',$data);
	}

	public function do_recovery()
	{
	    $this->load->model("system/User_dept_model","ud",TRUE);
	    $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>6);
	    $nums = $this->ud->count_nums($where);
	    if($nums[0]['nums']<1){
	        echo "没有权限！";
	        exit;
	    }
	    $id_type = $this->input->post('id_type',TRUE);
	    $tar_id = $this->input->post('tar_id',TRUE);
	    if(empty($tar_id)||empty($id_type)){
	        echo 'error';
	        exit;
	    }
	    $this->load->model("file/directory_model","dir",TRUE);
	    $this->load->model("file/files_model",'file',TRUE);
	    $this->load->model("file/directory_model","dir1",TRUE);
	    $id_type_arr = explode('_', $id_type);
	    $id = $id_type_arr[0];
	    $type = $id_type_arr[1];
	    if($tar_id=='-'){
	       //恢复到原文件夹，判断原文件是否存在，如果删除，不允许恢复
	       if($type=="folder"){
	           $this->dir->retrieve($id);
	           $pid = $this->dir->parentid;
	           if($pid!=0){
	               $this->dir1->retrieve($this->dir->parentid);
	               if(empty($this->dir1->id)||$this->dir1->status==0){
	                   echo "目标文件夹已经不存在或者删除，请选择恢复到其他文件夹！";
	                   exit;
	               }
	               $this->dir->status = 1;
	           } else {
	               $this->dir->status = 1;
	           }
	           $this->dir->update();
	       } else {
	           $this->file->retrieve($id);
	           $dir_id = $this->file->directory_id;
	           if($dir_id==0){
	               $this->file->status = 2;
	           } else {
	               $this->dir1->retrieve($dir_id);
	               if(empty($this->dir1->id)||$this->dir1->status==0){
	                   echo "目标文件夹已经不存在或者删除，请选择恢复到其他文件夹！";
	                   exit;
	               }
	               $this->file->status = 2;
	           }
	           $this->file->update();
	       }
	       echo "ok";
	    } else {
	        //恢复到其他文件夹
	        if($tar_id!='-'&&$tar_id!=''){
	            if($type=="folder"){
	                $this->dir->retrieve($id);
	                $this->dir->status = 1;
	                $this->dir->parentid = $tar_id;
	                $this->dir->update();
	            } else {
	                $this->file->retrieve($id);
	                $this->file->status = 2;
	                $this->file->directory_id = $tar_id;
	                $this->file->update();
	            }
	            echo "ok";
	        } else{
	            echo "请选择存在的文件夹！";
	            exit;
	        }
	    }
	}
}
