<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Files extends MY_Controller {
	const COLUMN_NAME = "部门云盘";//hsl
	const COLUMN_NAMEA = "审核文件";//hsl
	function __construct()
	{
		parent::__construct();
		if($this->is_login == false)
			redirect('/');
	}

	public function index()
	{
	}
	private function mkdirs($dir, $mode = 0777)
	{
	    if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
	    if (!$this->mkdirs(dirname($dir), $mode)) return FALSE;
	    return @mkdir($dir, $mode);
	}
	public function files_list()
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
	    $this->load->model("system/User_dept_model","ud",TRUE);
	    // $where = array('userid'=>$this->user->id,'deptid'=>$_SESSION["default_dept"],'operation_id'=>1);
			 $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>1);
        $nums = $this->ud->count_nums($where);
	    if($nums[0]['nums']>0){
	        $data['move'] = 1;
	    } else {
	        $data['move'] = 0;
	    }
	    $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>2);
	    $nums = $this->ud->count_nums($where);
	    if($nums[0]['nums']>0){
	        $data['del'] = 1;
	    } else {
	        $data['del'] = 0;
	    }
	    $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>4);
	    $nums = $this->ud->count_nums($where);
	    if($nums[0]['nums']>0){
	        $data['share'] = 1;
	    } else {
	        $data['share'] = 0;
	    }
	    $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>5);
	    $nums = $this->ud->count_nums($where);
	    if($nums[0]['nums']>0){
	        $data['rename'] = 1;
	    } else {
	        $data['rename'] = 0;
	    }
	    $this->load->view('/admin/file/files_list',$data);
	}

	public function files_upload($dirid='')
	{
	    $data['dirid'] = $dirid;
	    $this->load->view('/admin/file/files_upload',$data);
	}

	public function do_upload()
	{
	    $dirid = $this->input->get('dirid',TRUE);
	    set_time_limit(0);
	    $this->load->model('users/Department_model','dept',TRUE);
	    $ids[]=$_SESSION["default_dept"];
	    $list = $this->dept->get_depts($ids);
	    $dept_name = $list[0]['name'];
	    //临时文件夹
	    $upload_temp_path = './uploads/file_tmp';
	    //存放文件路径
	    $target_path = './uploads/file/'.$_SESSION["default_dept"];
// 	    if(empty($dirid)||$dirid==0){
// 	        $target_path = $target_path.'/'.'0';
// 	    } else {
// 	        $this->load->model("file/Directory_model","dir",TRUE);
// 	        $dir_list = $this->dir->get_dirs($dirid);
// 	        foreach($dir_list as $l)
// 	        {
// 	            $target_path = $target_path.'/'.$l['id'];
// 	        }
// 	    }
	    //$cleanupTargetDir = true;
	    $maxFileAge = 5 * 3600;

	    if (!is_dir($upload_temp_path)) {
//	        mkdir($upload_temp_path,'0777',true);
//	        mkdirs($upload_temp_path);
//	        chmod($upload_temp_path,0777);
			$this->mkdirs($upload_temp_path);
	    }
	    if (!is_dir($target_path)) {
//	        mkdir($target_path,'0777',true);
//			mkdirs($target_path);
//	        chmod($target_path,0777);
			$this->mkdirs($target_path);
	    }
	    $old_filename = $_GET["name"];

	    $chunk = isset($_GET["chunk"]) ? intval($_GET["chunk"]) : 0;
	    $chunks = isset($_GET["chunks"]) ? intval($_GET["chunks"]) : 1;
	    //当前上传文件命名
	    $file_name_temp = $upload_temp_path.'/'.iconv("UTF-8", "GBK", $old_filename) .'.part';
	    $file_name = $file_name_temp.$chunk;

	    $in = file_get_contents("php://input", "rb");
	    if (!file_put_contents($file_name,$in)) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }

	    $flag = true;
	    for( $index = 0; $index < $chunks; $index++ ) {
	        if ( !file_exists($file_name_temp.$index) ) {
	            $flag = false;
	            break;
	        }
	    }
	    $file_ext = '';
	    $target_file = '';
	    if ( $flag ) {
	        $temps=explode('.',$old_filename);
	        $file_ext=end($temps);
	        $target_file = $target_path . '/' .md5($old_filename.time()).'.'.$file_ext;
	        $fp = fopen($target_file,"ab");        //合并后的文件名
	        $flag =true;
	        for( $index = 0; $index < $chunks; $index++ ) {
	            if(file_exists($file_name_temp.$index)) {
	                $handle = fopen($file_name_temp.$index,"rb");
	                fwrite($fp,fread($handle,filesize($file_name_temp.$index)));
	                fclose($handle);
	                unset($handle);
	                @unlink($file_name_temp.$index);
	            }
	            else
	            {
	                $flag=false;
	                break;
	                echo "上传失败";
	                exit;
	            }
	        }
	        fclose($fp);
	        if($flag == true)
	        {
	            //写入数据库
	            $this->load->model('file/Files_model','file',TRUE);
	            $this->file->ding_userid = $this->user->ding_userid;
	            $this->file->deptid = $_SESSION["default_dept"];
	            $this->file->directory_id = empty($dirid)?0:$dirid;
	            $this->file->name = $old_filename;
	            $this->file->file_type = $file_ext;
	            $this->file->file_size = $_GET["size"];
	            $this->file->status = 1;
	            $this->file->file_path = substr($target_file,1,strlen($target_file));
	            if(empty($file_ext)){
	                $this->file->file_icon = '/public/images/file/unknown.png';
	            }else{
	                $src="/public/images/file/".$file_ext.".png";
	                if(file_exists('.'.$src)){
	                    $this->file->file_icon = $src;
	                } else{
	                    $this->file->file_icon = '/public/images/file/unknown.png';
	                }
	            }
							//开启事物 hsl
							$this->db->trans_start();
							$this->file->insert();
							//上传文件成功之后我们再此操作写入日志表当中  hsl
							$action_infos = array(array('name'=>'上传','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."成功上传了文件".$old_filename,'addtime'=>time()));
							$this->load->library('action_add');
							$stt = $this->action_add->increase_operating_all($action_infos);
							if($stt == false){
								log_message('error','上传文件日志写入失败!');
							}
							//提交事物
							$this->db->trans_complete();
							if ($this->db->trans_status() === FALSE){
								if(file_exists($target_file))
									 @unlink($target_file);
							 	 echo "erorr";
							}
							echo "ok";

	        }
	        else
	        {
	            if(file_exists($target_file)){
	                @unlink($target_file);
	                echo "erorr";
	            }
	        }
	        exit;
	    }

	}

    public function get_files($parentid='0')
    {
//         $page=$this->input->get("page",TRUE);
//         $limit=$this->input->get("limit",TRUE);
        $deptid = $_SESSION["default_dept"];
        header('Content-type: application/json');
        $this->load->model("file/directory_model","dir",TRUE);
        $data=array();
        $where=array();
        $where['deptid']=$deptid;
        $where['parentid']=$parentid;
        $dir_list=$this->dir->getlist($where);
        foreach($dir_list as $m)
        {
            $data[]=array('id'=>$m['id'],'name'=>'<img src="/public/images/file/folder.png">'.'<a href="javascript:void(0);" id="f'.$m['id'].'" data-type="folder" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>'-','addtime'=>date('Y-m-d H:i:s',$m['addtime']));
        }
        $this->load->model("file/files_model",'file',TRUE);

        $wheres=array();
        $wheres['deptid']=$deptid;
        $wheres['directory_id']=$parentid;
        $wheres['status']=2;
        $files_list=$this->file->getlist($wheres);
        $files_arr=array('code'=>0,'msg'=>'ok');

        foreach($files_list as $m)
        {
            $size = $m['file_size'];
            if($size/1024 >1024){
                $size = round($size/1024/1024, 2).'M';
            }else{
                $size = round($size/1024).'KB';
            }
            $data[]=array('id'=>$m['id'],'name'=>'<img src= "'.$m['file_icon'].'" />'.'<a href="javascript:void(0);" id="'.$m['id'].'" data-type="'.$m['file_type'].'"  data-path="'.$m['file_path'].'" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>$size,'addtime'=>date('Y-m-d H:i:s',$m['addtime']));
        }
        $files_arr['data']=$data;
        echo json_encode($files_arr);
    }

    public function folder_add_page($parentid='')
    {
        $data['parentid'] = $parentid;
        $this->load->view('/admin/file/folder_add',$data);
    }

    public function do_folder_add()
    {
        $parentid = $this->input->post("parentid",TRUE);
        $name = $this->input->post("name",TRUE);
        $sort = $this->input->post("sort",TRUE);
        $this->load->model("file/Directory_model","dir",TRUE);
        $this->dir->ding_userid = $this->user->ding_userid;
        $this->dir->deptid = $_SESSION["default_dept"];
        $this->dir->parentid = $parentid;
        $this->dir->name = $name;
        $this->dir->sort = $sort;
				//开启事物 hsl
				$this->db->trans_start();
				$this->dir->insert();
				//确定新建文件夹成功之后我们再此操作写入日志表当中  hsl
				$action_infos = array(array('name'=>'新增','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."成功新建了文件夹".$name,'addtime'=>time()));
				$this->load->library('action_add');
				$stt = $this->action_add->increase_operating_all($action_infos);
				if($stt == false){
					log_message('error','新建文件夹日志写入失败!');
				}
				//提交事物
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE){
						echo "error";
				}
				echo "ok";
    }

    function change_session(){
        $dept = $this->input->post("id");
        if(!empty($dept)){
            $_SESSION["default_dept"] = $dept;
        }
    }

    function get_dirs()
    {
        $id = $this->input->post("id",TRUE);
        if(empty($id)||$id==0){
            exit;
        }
        $this->load->model("file/Directory_model","dir",TRUE);
        $list = $this->dir->get_dirs($id);
        $data = array();
        foreach($list as $m)
        {
            $data[]=array('id'=>$m['id'],'name'=>$m['name'],'parentid'=>$m['parentid']);
        }
        echo json_encode($data);
    }

    public function move_page()
    {
        $sel_rowids = $this->input->get('sel_rows',TRUE);
        $dirid = $this->input->get('dirid',TRUE);
        $this->load->model("file/Directory_model","dir",TRUE);
        $where=array();
        $where['deptid']=$_SESSION["default_dept"];
        $data['dirs']=$this->dir->getlist($where);
        $data['sel_rowids'] = $sel_rowids;
        $data['dirid'] = $dirid;
        $this->load->view("admin/file/file_move",$data);
    }

    public function do_move()
    {
        //先判断是否有权限
        $this->load->model("system/User_dept_model","ud",TRUE);
        $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>1);
        $nums = $this->ud->count_nums($where);
        if($nums[0]['nums']<1){
            echo "没有权限！";
            exit;
        }
        $sel_rowids =  $this->input->post("sel_rowids",TRUE);
        $tar_pid = $this->input->post("tar_pid",TRUE);

        if(empty($sel_rowids)){
            echo "没有选择移动的文件或文件夹";
            exit;
        }
        //explode摈弃掉最后一个无效选项，可以直接使用-1
        $id_types = explode(',', $sel_rowids,-1);
        //判断是否有不能移动的文件夹
        $this->load->model("file/Directory_model","dir",TRUE);
        $this->load->model("file/Files_model","file",TRUE);
				if($tar_pid == 0){
					$tname = "根目录";
				}else{
					$this->dir->retrieve($tar_pid);
					$tname = $this->dir->name;//移动到的文件夹名称
				}
        $dirs = array();
        $files = array();
				$action_infos = array();//存放日志信息 后期批量插入到数据库  hsl
//         $files_path = array();
//         $save_path = '/uploads/file/'.$_SESSION['default_dept'];
//         $tar_path = './uploads/file/'.$_SESSION['default_dept'];
//         $plist = $this->dir->get_dirs($tar_pid);
//         foreach ($plist as $p){
//             $tar_path = $tar_path.'/'.$p['id'];
//             $save_path = $save_path.'/'.$p['id'];
//         }
        foreach ($id_types as $id_type)
        {
            $id_type_arr = explode('_', $id_type);
            $src_id = $id_type_arr[0];
            if($id_type_arr[1]=="folder"){
                $this->dir->retrieve($src_id);
								$filename = $this->dir->name;//移动的文件夹名称
								$parentid = $this->dir->parentid;
								if($parentid == 0){
									$lz = "根目录";
								}else{
									$this->dir->retrieve($parentid);
									$lz = $this->dir->name;//从哪里移动的
								}
                $list = $this->dir->get_childrens($src_id);
                $str_dirs = $src_id.','.$this->dir->parentid;
                foreach($list as $m)
                {
                    $str_dirs=$str_dirs.','.$m['id'];
                }
                if(strpos($str_dirs,$tar_pid) > -1 ){
                    //
                    echo "不能将文件移动到自身及其子目录下！";
                    exit;
                }
                $dirs[] = array('id'=>$src_id,'parentid'=>$tar_pid);
								//hsl
								$action_infos[] = array('name'=>'移动','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."将文件夹".$filename."从".$lz."移动到了".$tname,'addtime'=>time());

            } elseif ($id_type_arr[1]=="file"){
                $this->file->retrieve($src_id);
								$filename = $this->file->name;//移动的文件名称
								$parentid = $this->file->directory_id;//文件所在的文件夹id
								if($parentid == 0){
									$lz = "根目录";
								}else{
									$this->dir->retrieve($parentid);
									$lz = $this->dir->name;//从哪里移动的
								}

                if($this->file->directory_id==$tar_pid){
                    echo "不能将文件移动到自身及其子目录下！";
                    exit;
                }
                $files[] = array('id'=>$src_id,'directory_id'=>$tar_pid);
								//hsl
								$action_infos[] = array('name'=>'移动','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."将文件".$filename."从".$lz."移动到了".$tname."目录下",'addtime'=>time());
//                 $src_file_path = $this->file->file_path;
//                 $temps=explode('/',$src_file_path);
//                 $file_name=end($temps);
//                 $tar_file_path = $save_path.'/'.$file_name;
//                 $files[] = array('id'=>$src_id,'directory_id'=>$tar_pid,'file_path'=>$tar_file_path);
//                 $files_path[] = array('s_path'=>$src_file_path,'t_path'=>$tar_file_path);
            }
        }
        $this->db->trans_start();
        if(!empty($dirs)){
            $this->dir->update_batch($dirs);
        }
        if(!empty($files)){
            $this->file->update_batch($files);
        }
				//hsl
				$this->load->library('action_add');
				$stt = $this->action_add->increase_operating_all($action_infos);
				if($stt == false){
					log_message('error','文件夹/文件移动日志写入失败!');
				}
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
             echo "移动失败！";
        }
        else
        {
             echo "移动成功！";
        }

    }

    public function do_download()
    {
        $sel_rows = $this->input->get("sel_rows",TRUE);
        $req_id = $this->input->get("req_id",TRUE);
        if(empty($sel_rows)||empty($req_id)){
            echo "error";
            exit;
        }
        session_write_close();
        $id_types = explode(',',$sel_rows,-1);
        $this->load->model("file/Directory_model","dir",TRUE);
        $this->load->model("file/Files_model","file",TRUE);
        $target_path = './uploads/file/'.$_SESSION["default_dept"];
        $temp_path = './uploads/file_tmp';
        //后续以部门/文件夹/文件的形式保存
        set_time_limit(0);
        $this->load->model("file/Download_status_model","ds",TRUE);
        $this->load->helper("download");
        if(count($id_types)==1)
        {
            //只有一个文件或者文件夹
            $id_type = explode('_',$id_types[0]);
            if($id_type[1]=="folder"){
                //文件夹压缩
//                 $id = $id_type[0];

//                 $this->dir->retrieve($id);
//                 if(empty($id)||$id==0){
//                     $target_path = $target_path.'/'.'0';
//                 } else {
//                     $dir_list = $this->dir->get_dirs($id);
//                     foreach($dir_list as $l)
//                     {
//                         $target_path = $target_path.'/'.$l['id'];
//                     }
//                 }
//                 $zip=new ZipArchive();
//                 $tmp_filename = $temp_path.'/'.$this->dir->name.'.zip';
//                 if($zip->open($tmp_filename, ZipArchive::CREATE)=== TRUE){
//                     $this->addFileToZip($target_path, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
//                     $zip->close(); //关闭处理的zip文件
//                 }
//                 if(!file_exists($tmp_filename)){
//                     exit("无法找到文件"); //即使创建，仍有可能失败。。。。
//                 }
//                 file_download(basename($tmp_filename),"application/zip",$tmp_filename);
//                 unlink($tmp_filename);
            } else if($id_type[1]=="file"){
                //单个文件直接下载
                $this->ds->request_id = $req_id;
                $this->ds->status = 1;
                $this->ds->msg = "共1个文件，服务器下载中，请勿关闭当前页面！";
                $this->ds->insert();
                $content_types_list = $this->mimeTypes();
                $default_content_type = "application/octet-stream";
                $id = $id_type[0];
                $this->file->retrieve($id);
                $file_path = $this->file->file_path;
                $file_name  = $this->file->name;
                $file_ext  = $this->file->file_type;
                $size = $this->file->file_size;
                if(!file_exists('.'.$file_path)){
                    exit("无法找到文件"); //即使创建，仍有可能失败。。。。
                    exit;
                }
                if (array_key_exists($file_ext, $content_types_list))
                {
                    $content_type = $content_types_list[$file_ext];
                }else{
                    $content_type =  $default_content_type;
                }
                $file_path=".".$file_path;
            }
        } else {
            //多文件和文件夹
            $zip=new ZipArchive();
            $tmp_filename = $temp_path.'/file.zip';

            if($zip->open($tmp_filename, ZipArchive::CREATE)=== TRUE){
                $total_c = count($id_types);
                $num = 0;
                $per = 0;
                //插入数据库
                $this->ds->request_id = $req_id;
                $this->ds->status = 0;
                $this->ds->msg = "共".$total_c."个文件，服务器打包压缩中，请稍后,请勿关闭当前页面！";
                $this->ds->insert();
                foreach ($id_types as $id_type){
                    $id_type = explode('_',$id_type);
                    $id = $id_type[0];
                    $type = $id_type[1];
                    if($type=="folder"){
                        //文件夹
//                         $this->dir->retrieve($id);
//                         $dir=0;
//                         if(empty($id)||$id==0){
//                             $target_path = $target_path.'/'.'0';
//                         } else {
//                             $dir_list = $this->dir->get_dirs($id);
//                             foreach($dir_list as $l)
//                             {
//                                 $target_path = $target_path.'/'.$l['id'];
//                             }
//                             $last_arr = end($dir_list);
//                             $dir = $last_arr['id'];
//                         }
//                         $this->addFileToZip($target_path, $zip, $dir);
                    } else {
                        //文件
                        $this->load->model("file/Files_model","file1",TRUE);
                        $this->file1->retrieve($id);
                        $zip->addFile(".".$this->file1->file_path, $this->file1->name);
                        $num++;
                    }
                }
                $zip->close(); //关闭处理的zip文件
            }
            if(!file_exists($tmp_filename)){
                exit("无法找到文件"); //即使创建，仍有可能失败。。。。
            } else {
                $this->ds->status = 1;
                $this->ds->msg="文件打包成功，下载中！请勿关闭当前页面！";
                $this->ds->update();
            }
//             $this->file_download(basename($tmp_filename),'application/zip',$tmp_filename);

            $file_name=basename($tmp_filename);
            $content_type = 'application/zip';
            $file_path = $tmp_filename;

        }

        $file_size=filesize($file_path);
        header("Content-Disposition: attachment;filename=".$file_name);
        header('Content-Type: '.$content_type);
        header("Cache-Control: no-cache");
        header("Content-Length: ".$file_size);
        $handle = fopen($file_path, 'rb');
        $buffer = '';
        $chunksize = 10*1024*1024;
        $i=1;
        while (!feof($handle) && (connection_status() === CONNECTION_NORMAL))
        {
            $buffer = fread($handle, $chunksize);
            print $buffer;
            //取出PHP buffering中的数据,放入server buffering
            ob_flush();
            //取出Server buffering的数据,放入browser buffering
            flush();
            $jd=round($chunksize*$i++/$file_size*100);
            if($jd <= 0)
                $jd=0;
            if($jd >= 100)
                $jd=100;
            $this->ds->msg="文件下载中,当前已经下载 ".$jd."%。请勿关闭当前页面！";
            $this->ds->update();
        }
        if(connection_status() !== CONNECTION_NORMAL)
        {
            echo "Connection aborted";
        }
        fclose($handle);
        $this->ds->msg="恭喜你，文件下载成功！";
        $this->ds->status=2;
        $this->ds->update();
        unlink($tmp_filename);
    }

    function get_download_status(){
        $this->load->model("file/Download_status_model","ds",TRUE);
        $req_id = $this->input->post("req_id",TRUE);
        if(empty($req_id)){
            echo "error";
            exit;
        }
        $this->ds->retrieve_by_req_id($req_id);
        echo json_encode(array("status"=>$this->ds->status,"msg"=>$this->ds->msg));
        if( $this->ds->status== 2)
            $this->ds->delete();
    }

    function addFileToZip($path,$zip,$dir){
        //$path = iconv("UTF-8", "GBK", $path);
        $handler = opendir($path); //打开当前文件夹由$path指定。
        while(($filename=readdir($handler))!==false){
            if($filename != "." && $filename != ".."){ //文件夹文件名字为'.'和‘..’，不对他们进行操作
                if(is_dir($path."/".$filename)){  // 如果读取的某个对象是文件夹，则递归
                    $this->addFileToZip($path."/".$filename, $zip);
                }else{
                    $zip->addFile($path."/".$filename, $filename);
                }
            }
        }
        closedir();
    }

    public function audit_page()
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
        $this->load->view('/admin/file/file_audit',$data);
    }

    public function get_audit_files()
    {
        $page=$this->input->get("page",TRUE);
        $limit=$this->input->get("limit",TRUE);
        $name = $this->input->get("name",TRUE);

        $deptid = $_SESSION["default_dept"];
        header('Content-type: application/json');
        $this->load->model("file/files_model",'file',TRUE);

        $wheres=array();
        $where = array();
        $where['deptid']=$deptid;
        $wheres['where'] = $where;
        $status = array("1");
        $where_in = array('status'=>$status);
        $wheres['where_in'] = $where_in;
        if($name!='null' && !empty($name)){
            $wheres['like'] = array('name'=>$name);
        }
        $files_list=$this->file->get_search_list($wheres,($page-1)*$limit,$limit);
        $files_arr=array('code'=>0,'msg'=>'ok','count'=>$this->file->get_search_nums($wheres));
        $data = array();
        foreach($files_list as $m)
        {
            $size = $m['file_size'];
            if($size/1024 >1024){
                $size = round($size/1024/1024, 2).'M';
            }else{
                $size = round($size/1024).'KB';
            }
            $data[]=array('id'=>$m['id'],'name'=>'<img src= "'.$m['file_icon'].'" />'.'<a href="javascript:void(0);" id="'.$m['id'].'" data-type="'.$m['file_type'].'"  data-path="'.$m['file_path'].'" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>$size,'addtime'=>date('Y-m-d H:i:s',$m['addtime']));
        }
        $files_arr['data']=$data;
        echo json_encode($files_arr);
    }

    public function do_audit()
    {
        //先判断当前用户是否有审核权限
        $this->load->model("system/User_dept_model","ud",TRUE);
        $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>3);
        $nums = $this->ud->count_nums($where);
        if($nums[0]['nums']<1){
            echo "没有权限！";
            exit;
        }
        $ids = $this->input->post("ids",TRUE);
        $ids = trim($ids,',');
        $type = $this->input->post("type",TRUE);
        if(empty($ids)){
            echo "error";
            exit;
        }
        $this->load->model("file/files_model",'file',TRUE);
        $ids_arr = explode(',', $ids);
        $update_arr = array();
				$action_infos = array();//存放日志信息 后期批量插入到数据库
				foreach ($ids_arr as $k=>$v){
					  $this->file->retrieve($v);// hsl
            if($type==1){
				$action_infos[] = array('name'=>'审核','column'=>self::COLUMN_NAMEA,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."对".$this->file->name."的审核为成功状态",'addtime'=>time());
                $update_arr[] = array('id'=>$v,'status'=>2);
            } else if($type==2){
				$action_infos[] = array('name'=>'审核','column'=>self::COLUMN_NAMEA,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."对".$this->file->name."的审核为失败状态!",'addtime'=>time());
                $update_arr[] = array('id'=>$v,'status'=>3);
            }
        }
        if(count($update_arr) > 0){
						//开启事物 hsl
        		$this->db->trans_start();
						$this->file->update_batch($update_arr);
						$this->load->library('action_add');
						$stt = $this->action_add->increase_operating_all($action_infos);
						if($stt == false){
							log_message('error','审核文件日志写入失败!');
						}
						//提交事物
						$this->db->trans_complete();
						if ($this->db->trans_status() === FALSE){
								echo "数据库执行错误!请联系管理员!";
						}
						echo "恭喜您完成审核!";

        } else {
            echo "未选择审核文件！";
        }
    }

    public function do_delete()
    {
        //先判断是否有删除权限
        $this->load->model("system/User_dept_model","ud",TRUE);
        $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>2);
        $nums = $this->ud->count_nums($where);
        if($nums[0]['nums']<1){
            echo "没有权限！";
            exit;
        }
//         $ids = $this->input->post('ids',TRUE);
//         $ids = trim($ids,',');
        $sel_rows = $this->input->post('sel_rows',TRUE);
        $sel_rows = trim($sel_rows,',');
        if(empty($sel_rows)){
            echo "没有选择要删除的文件或者文件夹！";
            exit;
        }
        $sel_rows = explode(',', $sel_rows);
        $update_file_arr = array();
        $update_dir_arr = array();
        $this->load->model("file/directory_model","dir",TRUE);
        $this->load->model("file/files_model",'file',TRUE);
        $this->load->model('file/share_model','share',TRUE);
        $time = time();
				$action_infos = array();//hsl
        foreach ($sel_rows as $id_type){
            $id = explode('_', $id_type)[0];
            $type = explode('_', $id_type)[1];
            if($type=="folder"){
				$this->dir->retrieve($id);
				if($this->dir->id == '' || $this->dir->id < 1)
				{
				    exit("error");
				}
				$this->share->retrieve_aa($id,$type);
                //文件夹判断是否有子文件夹或者文件
                $where=array();
                $where['deptid']=$_SESSION["default_dept"];
                $where['parentid']=$id;
                $dir_list=$this->dir->getlist($where);

                $wheres = array();
                $where=array();
                $where['deptid']=$_SESSION["default_dept"];
                $where['directory_id']=$id;
                $wheres["where"] = $where;
                $status = array(1,2);
                $wheres['where_in']=array('status'=>$status);
                $nums_file=$this->file->get_search_nums($wheres);
                if(count($dir_list) > 0||$nums_file > 0){
                    echo "不能删除带有子文件夹或者子文件的目录！";
                    exit;
                }
                $update_dir_arr[] = array('id'=>$id,'status'=>0,'updatetime'=>$time);
				//hsl
				$action_infos[] = array('name'=>'删除','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."成功删除了文件夹".$this->dir->name,'addtime'=>time());
            } else if($type=="file"){
        			  $this->file->retrieve($id);//hsl
        			  if($this->file->id == '' || $this->file->id < 1)
        			  {
        			      exit("error");
        			  }
        			$this->share->retrieve_aa($id,$type);
                    $update_file_arr[] = array('id'=>$id,'status'=>-1,'updatetime'=>$time);
    				//hsl
    				$action_infos[] = array('name'=>'删除','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."成功删除了文件".$this->file->name,'addtime'=>time());
            }
        }


        $this->db->trans_start();
        if(!empty($update_dir_arr)){
            $this->dir->update_batch($update_dir_arr);
        }
        if(!empty($update_file_arr)){
            $this->file->update_batch($update_file_arr);
        }
				//hsl
				$this->load->library('action_add');
				$stt = $this->action_add->increase_operating_all($action_infos);
				if($stt == false){
					log_message('error','刪除文件夾或者文件日志写入失败!');
				}
        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE)
        {
            echo "删除失败！";
        }
        else
        {
            echo "删除成功！";
        }
//         foreach ($ids as $i){
//             $update_arr[] = array('id'=>$i,'status'=>-1);
//         }
//         if(count($update_arr) > 0){
//             $this->load->model("file/files_model",'file',TRUE);
//             if($this->file->update_batch($update_arr)){
//                 echo "删除成功！";
//             } else {
//                 echo "删除失败";
//             }
//         } else {
//             echo "没有要删除的文件！";
//         }
    }

    public function mimeTypes()
    {
        /* Just add any required MIME type if you are going to download something not listed here.*/

        $mime_types = array("323" => "text/h323",
            "acx" => "application/internet-property-stream",
            "ai" => "application/postscript",
            "aif" => "audio/x-aiff",
            "aifc" => "audio/x-aiff",
            "aiff" => "audio/x-aiff",
            "asf" => "video/x-ms-asf",
            "asr" => "video/x-ms-asf",
            "asx" => "video/x-ms-asf",
            "au" => "audio/basic",
            "avi" => "video/x-msvideo",
            "axs" => "application/olescript",
            "bas" => "text/plain",
            "bcpio" => "application/x-bcpio",
            "bin" => "application/octet-stream",
            "bmp" => "image/bmp",
            "c" => "text/plain",
            "cat" => "application/vnd.ms-pkiseccat",
            "cdf" => "application/x-cdf",
            "cer" => "application/x-x509-ca-cert",
            "class" => "application/octet-stream",
            "clp" => "application/x-msclip",
            "cmx" => "image/x-cmx",
            "cod" => "image/cis-cod",
            "cpio" => "application/x-cpio",
            "crd" => "application/x-mscardfile",
            "crl" => "application/pkix-crl",
            "crt" => "application/x-x509-ca-cert",
            "csh" => "application/x-csh",
            "css" => "text/css",
            "dcr" => "application/x-director",
            "der" => "application/x-x509-ca-cert",
            "dir" => "application/x-director",
            "dll" => "application/x-msdownload",
            "dms" => "application/octet-stream",
            "doc" => "application/msword",
            "dot" => "application/msword",
            "dvi" => "application/x-dvi",
            "dxr" => "application/x-director",
            "eps" => "application/postscript",
            "etx" => "text/x-setext",
            "evy" => "application/envoy",
            "exe" => "application/octet-stream",
            "fif" => "application/fractals",
            "flr" => "x-world/x-vrml",
            "gif" => "image/gif",
            "gtar" => "application/x-gtar",
            "gz" => "application/x-gzip",
            "h" => "text/plain",
            "hdf" => "application/x-hdf",
            "hlp" => "application/winhlp",
            "hqx" => "application/mac-binhex40",
            "hta" => "application/hta",
            "htc" => "text/x-component",
            "htm" => "text/html",
            "html" => "text/html",
            "htt" => "text/webviewhtml",
            "ico" => "image/x-icon",
            "ief" => "image/ief",
            "iii" => "application/x-iphone",
            "ins" => "application/x-internet-signup",
            "isp" => "application/x-internet-signup",
            "jfif" => "image/pipeg",
            "jpe" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "jpg" => "image/jpeg",
            "js" => "application/x-javascript",
            "latex" => "application/x-latex",
            "lha" => "application/octet-stream",
            "lsf" => "video/x-la-asf",
            "lsx" => "video/x-la-asf",
            "lzh" => "application/octet-stream",
            "m13" => "application/x-msmediaview",
            "m14" => "application/x-msmediaview",
            "m3u" => "audio/x-mpegurl",
            "man" => "application/x-troff-man",
            "mdb" => "application/x-msaccess",
            "me" => "application/x-troff-me",
            "mht" => "message/rfc822",
            "mhtml" => "message/rfc822",
            "mid" => "audio/mid",
            "mny" => "application/x-msmoney",
            "mov" => "video/quicktime",
            "movie" => "video/x-sgi-movie",
            "mp2" => "video/mpeg",
            "mp3" => "audio/mpeg",
            "mpa" => "video/mpeg",
            "mpe" => "video/mpeg",
            "mpeg" => "video/mpeg",
            "mpg" => "video/mpeg",
            "mpp" => "application/vnd.ms-project",
            "mpv2" => "video/mpeg",
            "ms" => "application/x-troff-ms",
            "mvb" => "application/x-msmediaview",
            "nws" => "message/rfc822",
            "oda" => "application/oda",
            "p10" => "application/pkcs10",
            "p12" => "application/x-pkcs12",
            "p7b" => "application/x-pkcs7-certificates",
            "p7c" => "application/x-pkcs7-mime",
            "p7m" => "application/x-pkcs7-mime",
            "p7r" => "application/x-pkcs7-certreqresp",
            "p7s" => "application/x-pkcs7-signature",
            "pbm" => "image/x-portable-bitmap",
            "pdf" => "application/pdf",
            "pfx" => "application/x-pkcs12",
            "pgm" => "image/x-portable-graymap",
            "pko" => "application/ynd.ms-pkipko",
            "pma" => "application/x-perfmon",
            "pmc" => "application/x-perfmon",
            "pml" => "application/x-perfmon",
            "pmr" => "application/x-perfmon",
            "pmw" => "application/x-perfmon",
            "pnm" => "image/x-portable-anymap",
            "pot" => "application/vnd.ms-powerpoint",
            "ppm" => "image/x-portable-pixmap",
            "pps" => "application/vnd.ms-powerpoint",
            "ppt" => "application/vnd.ms-powerpoint",
            "prf" => "application/pics-rules",
            "ps" => "application/postscript",
            "pub" => "application/x-mspublisher",
            "qt" => "video/quicktime",
            "ra" => "audio/x-pn-realaudio",
            "ram" => "audio/x-pn-realaudio",
            "ras" => "image/x-cmu-raster",
            "rgb" => "image/x-rgb",
            "rmi" => "audio/mid",
            "roff" => "application/x-troff",
            "rtf" => "application/rtf",
            "rtx" => "text/richtext",
            "scd" => "application/x-msschedule",
            "sct" => "text/scriptlet",
            "setpay" => "application/set-payment-initiation",
            "setreg" => "application/set-registration-initiation",
            "sh" => "application/x-sh",
            "shar" => "application/x-shar",
            "sit" => "application/x-stuffit",
            "snd" => "audio/basic",
            "spc" => "application/x-pkcs7-certificates",
            "spl" => "application/futuresplash",
            "src" => "application/x-wais-source",
            "sst" => "application/vnd.ms-pkicertstore",
            "stl" => "application/vnd.ms-pkistl",
            "stm" => "text/html",
            "svg" => "image/svg+xml",
            "sv4cpio" => "application/x-sv4cpio",
            "sv4crc" => "application/x-sv4crc",
            "t" => "application/x-troff",
            "tar" => "application/x-tar",
            "tcl" => "application/x-tcl",
            "tex" => "application/x-tex",
            "texi" => "application/x-texinfo",
            "texinfo" => "application/x-texinfo",
            "tgz" => "application/x-compressed",
            "tif" => "image/tiff",
            "tiff" => "image/tiff",
            "tr" => "application/x-troff",
            "trm" => "application/x-msterminal",
            "tsv" => "text/tab-separated-values",
            "txt" => "text/plain",
            "uls" => "text/iuls",
            "ustar" => "application/x-ustar",
            "vcf" => "text/x-vcard",
            "vrml" => "x-world/x-vrml",
            "wav" => "audio/x-wav",
            "wcm" => "application/vnd.ms-works",
            "wdb" => "application/vnd.ms-works",
            "wks" => "application/vnd.ms-works",
            "wmf" => "application/x-msmetafile",
            "wps" => "application/vnd.ms-works",
            "wri" => "application/x-mswrite",
            "wrl" => "x-world/x-vrml",
            "wrz" => "x-world/x-vrml",
            "xaf" => "x-world/x-vrml",
            "xbm" => "image/x-xbitmap",
            "xla" => "application/vnd.ms-excel",
            "xlc" => "application/vnd.ms-excel",
            "xlm" => "application/vnd.ms-excel",
            "xls" => "application/vnd.ms-excel",
            "xlt" => "application/vnd.ms-excel",
            "xlw" => "application/vnd.ms-excel",
            "xof" => "x-world/x-vrml",
            "xpm" => "image/x-xpixmap",
            "xwd" => "image/x-xwindowdump",
            "z" => "application/x-compress",
            "rar" => "application/x-rar-compressed",
            "zip" => "application/zip");
        return $mime_types;
    }

    public function share_page(){
        $this->load->model('users/Department_model','dept',TRUE);
        $where = array();
        $depts = $this->dept->getlist($where,0,99999);
        $data['depts'] = $depts;
        $sel_rowids = $this->input->get('sel_rows',TRUE);
        $data['sel_rowids'] = $sel_rowids;
        $this->load->view('admin/file/file_share',$data);
    }

    public function do_share()
    {
        //先判断是否有权限
        $this->load->model("system/User_dept_model","ud",TRUE);
        $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>4);
        $nums = $this->ud->count_nums($where);
        if($nums[0]['nums']<1){
            echo "没有权限！";
            exit;
        }
        $sel_rowids =  $this->input->post("sel_rowids",TRUE);
        $sel_rowids = trim($sel_rowids,',');
        $deptids = $this->input->post("deptids",TRUE);
        $deptids = trim($deptids,',');
        $validate = $this->input->post("validate",TRUE);
        $dateTime = $this->input->post("dateTime",TRUE);
        if(empty($sel_rowids)||empty($deptids)||empty($validate)){
            echo "error";
            exit;
        }
        if(strpos($deptids, $_SESSION["default_dept"]) > -1){
            echo "不能分享给文件或文件夹所在的部门！";
            exit;
        }
        $id_types_arr = explode(',',$sel_rowids);
        $this->load->model("file/Files_model","file",TRUE);
        $this->load->model("file/Directory_model","dir",TRUE);
        $this->load->model("file/Share_model","share",TRUE);
        $share_arr = array();
				$action_infos = array();//hsl 存放日志信息 后期批量插入到数据库
        $dept_arr = explode(',',$deptids);
        foreach ($id_types_arr as $id_type)
        {
            $id = explode('_',$id_type)[0];
            $type = explode('_',$id_type)[1];
            //判断该文件或文件夹是否已经分享到目标部门且未过期
            foreach ($dept_arr as $deptid){
							  $this->load->model('users/Department_model','dept',TRUE);
								$name = $this->dept->retrieve_deptid($deptid);
                $num = $this->share->get_nums($id,$deptid);
                if($num>0){
                    echo "不能重复分享！";
                    exit;
                }
                $share = array();
                if($type=="folder"){
                    $this->dir->retrieve($id);
                    // $share['userid'] = $this->dir->userid; //hsl
					$share['ding_userid'] = $this->dir->ding_userid;
                    $share['deptid'] = $this->dir->deptid;
                    $share['directory_id'] = $id;
                    $share['file_id'] = null;
										//hsl
										$action_infos[] = array('name'=>'分享','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."分享了文件夹".$this->dir->name."到".$name,'addtime'=>time());
                }else if($type=="file"){
                    $this->file->retrieve($id);
                    $share['ding_userid'] = $this->file->ding_userid;
                    $share['deptid'] = $this->file->deptid;
                    $share['file_id'] = $id;
                    $share['directory_id'] = null;
										//hsl
										$action_infos[] = array('name'=>'分享','column'=>self::COLUMN_NAME,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."分享了文件".$this->file->name.'到'.$name,'addtime'=>time());
                }
                $share['status'] = 1;
                $share['to_deptid'] = $deptid;
                if($validate==-1){
                    //永久有效,到2033-05-18 11:33:20
                    $share['share_validity'] = 2000000000;
                } else if($validate==1){
                    //临时有效
                    if($dateTime!=null){
                        $share['share_validity'] = strtotime($dateTime);
                    }
                }
                $share_arr[]=$share;
            }
        }
        if($share_arr!=null &&count($share_arr)>0){
            // if($this->share->insert_batch($share_arr)){
            //     echo "分享成功！";
            //     exit;
            // }
						//开启事物 hsl
						$this->db->trans_start();
						$this->share->insert_batch($share_arr);
						$this->load->library('action_add');
						$stt = $this->action_add->increase_operating_all($action_infos);
						if($stt == false){
							log_message('error','审核文件日志写入失败!');
						}
						//提交事物
						$this->db->trans_complete();
						if ($this->db->trans_status() === FALSE){
								echo "分享失败!";
						}else{
							 echo "分享成功!";
						}

        }
        // echo "分享失败！";
    }

    public function share_list_page()
    {
        $this->load->view('admin/file/files_share_list');
    }

    public function share_list($dir_id=0,$sid=0)
    {
        $page=$this->input->get("page",TRUE);
        $limit=$this->input->get("limit",TRUE);
        header('Content-type: application/json');
        $this->load->model('users/Department_model','dept',TRUE);
        $this->load->model("file/Share_model","share",TRUE);
        $this->load->model("file/directory_model","dir",TRUE);
        if($dir_id==0){
            //获取用户的部门及子部门
            $dept_str = trim(trim($this->user->department,"]"),"[");
            $dept_ids = explode(',',$dept_str);
            $dept_ids_arr = $dept_ids;
            foreach ($dept_ids as $id){
                $list = $this->dept->get_children($id);
                foreach ($list as $l){
                    if (strpos('.'.$dept_str, $l['ding_dept_id'])>0)
                    {
                        continue;
                    } else {
                        //$data_list[] = $l;
                        // $dept_ids_arr[] = $l['id'];//此处修改为了下边这行代码
                        $dept_ids_arr[] = $l['ding_dept_id'];
                        $dept_str = $dept_str.','.$l['ding_dept_id'];
                    }
                }
            }
            $wheres = array();
            $where = array('share_validity >'=>time(),'status'=>1);
            $wheres['where']= $where;
            $where_in = array('to_deptid'=>$dept_ids_arr);
            $wheres['where_in'] = $where_in;
            $files_list=$this->share->get_search_list($wheres,($page-1)*$limit,$limit);
            $files_arr=array('code'=>0,'msg'=>'ok','count'=>$this->share->get_search_nums($wheres));
            $data = array();
            foreach($files_list as $m)
            {
                $validate_time = '';
                if($m['share_validity']==2000000000){
                    $validate_time = '永久';
                } else{
                    $validate_time = date('Y-m-d H:i:s',$m['share_validity']);
                }
                if($m['directory_id']!=null&& !empty($m['directory_id'])){
                    $data[]=array('id'=>$m['id'],'name'=>'<img src="/public/images/file/folder.png">'.'<a href="javascript:void(0);" id="f'.$m['directory_id'].'" data-id="f'.$m['directory_id'].'" data-sid='.$m['id'].' data-type="folder" onclick="openFolder(this.id);">'.$m['dir_name'].'</a>','file_size'=>'-','dept_name'=>$m['dept_name'],'to_dept_name'=>$m['to_dept_name'],'share_validity'=>$validate_time);
                } else if($m['file_id']!=null&& !empty($m['file_id'])){
                    $size = $m['file_size'];
                    if($size/1024 >1024){
                        $size = round($size/1024/1024, 2).'M';
                    }else{
                        $size = round($size/1024).'KB';
                    }
                    $data[]=array('id'=>$m['id'],'name'=>'<img src= "'.$m['file_icon'].'" />'.'<a href="javascript:void(0);" id="'.$m['file_id'].'" data-id="'.$m['file_id'].'" data-sid='.$m['id'].' data-type="'.$m['file_type'].'" data-path="'.$m['file_path'].'" onclick="openFolder(this.id);" >'.$m['file_name'].'</a>','file_size'=>$size,'dept_name'=>$m['dept_name'],'to_dept_name'=>$m['to_dept_name'],'share_validity'=>$validate_time);
                }

            }
            $files_arr['data']=$data;
            echo json_encode($files_arr);
        } else{
            $this->dir->retrieve($dir_id);
            $this->share->retrieve($sid);
            $this->dept->retrieve($this->share->deptid);
            $validate_time = '';
            if($this->share->share_validity==2000000000){
                $validate_time = '永久';
            } else{
                $validate_time = date('Y-m-d H:i:s',$this->share->share_validity);
            }
            $data=array();
            $where=array();
            $where['deptid']=$this->dir->deptid;
            $where['parentid']=$dir_id;
            $dir_list=$this->dir->getlist($where);
            foreach($dir_list as $m)
            {
                $data[]=array('id'=>$m['id'],'name'=>'<img src="/public/images/file/folder.png">'.'<a href="javascript:void(0);" id="f'.$m['id'].'" data-id="f'.$m['id'].'" data-sid='.$sid.' data-type="folder" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>'-','dept_name'=>$this->dept->name,'share_validity'=>$validate_time);
            }
            $this->load->model("file/files_model",'file',TRUE);

            $wheres=array();
            $wheres['deptid']=$this->dir->deptid;
            $wheres['directory_id']=$dir_id;
            $wheres['status']=2;
            $files_list=$this->file->getlist($wheres);
            $files_arr=array('code'=>0,'msg'=>'ok');

            foreach($files_list as $m)
            {
                $size = $m['file_size'];
                if($size/1024 >1024){
                    $size = round($size/1024/1024, 2).'M';
                }else{
                    $size = round($size/1024).'KB';
                }
                $data[]=array('id'=>$m['id'],'name'=>'<img src= "'.$m['file_icon'].'" />'.'<a href="javascript:void(0);" id="'.$m['id'].'" data-id="'.$m['id'].'" data-sid='.$m['id'].' data-type="'.$m['file_type'].'"  data-path="'.$m['file_path'].'" onclick="openFolder(this.id);">'.$m['name'].'</a>','file_size'=>$size,'dept_name'=>$this->dept->name,'share_validity'=>$validate_time);
            }
            $files_arr=array('code'=>0,'msg'=>'ok');
            $files_arr['data']=$data;
            echo json_encode($files_arr);
        }

    }

    public function folder_update_page()
    {
        $cid = $this->input->get('cid',TRUE);
        $dir_id = $this->input->get('dir_id',TRUE);
        $this->load->model("file/directory_model","dir",TRUE);
        $this->dir->retrieve($dir_id);
        $data['cid'] = $cid;
        $this->load->view('admin/file/folder_update',$data);
    }

    public function do_folder_update(){
        //先判断是否有权限
        $this->load->model("system/User_dept_model","ud",TRUE);
        $where = array('ding_userid'=>$this->user->ding_userid,'deptid'=>$_SESSION["default_dept"],'operation_id'=>5);
        $nums = $this->ud->count_nums($where);
        if($nums[0]['nums']<1){
            echo "没有权限！";
            exit;
        }
        $id = $this->input->post("id",TRUE);
        $name = $this->input->post("name",TRUE);
        if(empty($id)){
            echo "error！";
            exit;
        }

        $this->load->model("file/Directory_model","dir",TRUE);
        $this->dir->retrieve($id);
				$tname = $this->dir->name;
        $this->dir->name = $name;
				//开启事物 hsl
				$this->db->trans_start();
				$this->dir->update();
				$this->load->library('action_add');
				$action_infos[] = array('name'=>'修改','column'=>self::COLUMN_NAMEA,'executor'=>$this->user->name,'content'=>$this->user->name."用户于".date('Y年m月d日 H时i分s秒')."对".$tname."的名称进行了修改",'addtime'=>time());
				$stt = $this->action_add->increase_operating_all($action_infos);
				if($stt == false){
					log_message('error','修改文件夹名称日志写入失败!');
				}
				//提交事物
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE){
						echo "error";
				}
				echo "ok";


    }

}
