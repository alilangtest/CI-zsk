<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/3
 * Time: 10:44
 * author：huxiaobai
 * 干啥滴：部门知识
 */
class Dpt_intellectual extends MY_Controller{
    const COLUMN_NAME = "部门知识";
    function __construct()
    {
        parent::__construct();
        if($this->is_login == false)
            redirect('/');
    }

    public function index()
    {
        exit('error');//让敌人扑个空
    }

    public function dpt_intellectual_list(){
        //查询该用户所属部门
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
        $data['list'] =$data_list;//当前用户所属部门
        $this->load->model('different/Article_model','article',true);
        $kw = $this->input->get('kw',TRUE);
        if($kw && $kw != ''){
            $where = "articles.status = 1 and (articles.title like '%$kw%' or different.tname like '%$kw%' or user.name like '%$kw%' ) ";
        }
        //组合条件
        if(isset($where)){
            $where .= " AND articles.department = ".$_SESSION['default_dept']." AND  articles.dpt = 1";
        }else{
            $where = " articles.department = ".$_SESSION['default_dept'].' AND articles.status = 1 AND  articles.dpt = 1 ';
        }

        $wheres['where'] = $where;
        $wheres['order_by']='sort asc'; //分类编号越小越靠前

        //分页
        $this->load->library('pagination');//装载类文件
        //每一页显示的数据条数的变量
        $page_size=9;
        $config['base_url']=site_url("admin/knowledge/dpt_intellectual/dpt_intellectual_list/");
        $config['uri_segment']=5;
        $config['num_links'] = 2;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open'] = '<div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-14">';
        $config['full_tag_close'] = '</div>';
        $config['first_tag_open'] = '<span class="my">';
        $config['first_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>';
        $config['cur_tag_close'] = '</em></span>';
        $config['last_tag_open'] = '<span class="my">';
        $config['last_tag_close'] = '</span>';

        $config['per_page']=$page_size;
        $config['next_link']= '下一页';
        $config['prev_link']= '上一页';
        $config['last_link'] = '末页';
        $config['first_link'] = '首页';

        $config['total_rows']=count($this->article->get_search_list1($wheres));//总的记录数
        $this->pagination->initialize($config);
        $offset=intval($this->uri->segment(5));//用intval使空格转0，显示出来0
        $data['situation'] = $this->article->get_search_list1($wheres,$offset,$page_size);
        $data['total_rows'] = $config['total_rows'];
        // print_r($data['situation']);die;
        $this->load->view('/admin/knowledge/dpt_intellectual_list',$data);
    }

    /*
    * 点击"新增文章"弹框页面 以及 在弹框页面当中点击提交到该方法
    * 通过判断post数据是否为空 进行逻辑处理
    * */
    public function dpt_intellectual_add(){
        if(!empty($this->input->post())){

             //判断当前用户是否有新增权限
             $this->load->model('different/Intellectual_rights_model','intrights',true);
             $ty = 2; //1代表部门知识
             $operation_id = 1;//1代表新增
             $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
             if($num < 1){
                 exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权新增文章!')));
             }

            //服务端进行表单验证
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            //设置验证规则
            $this->form_validation->set_rules('title', '文章标题', 'required',array('required' => '文章标题不能为空！'));
            $this->form_validation->set_rules('column','所属栏目','required',array('required'=>'所属栏目不能为空！'));
            $this->form_validation->set_rules('keyword', '关键词', 'required',array('required' => '关键词不能为空！'));
            $this->form_validation->set_rules('describe','文章描述','required',array('required'=>'文章描述不能为空！'));
            $this->form_validation->set_rules('content', '关键词', 'required',array('required' => '文章内容不能为空！'));
            $this->form_validation->set_rules('sort', '排序', 'required',array('required' => '文章排序不能为空！'));
            $sort = $this->input->post('sort',TRUE);//分类排序
             //php当中0即是empty 空  为了满足测试人员提的要求  我只能单独再在此处判断一下如果是 = 0的时候直接给出提示 排序编号不能为0！
             if(!is_numeric($sort) || $sort == 0){
                exit(json_encode(array('status'=>0,'msg'=>'排序编号必须是数字类型并且不能为0!')));
            }
            //开始判断
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();//获取所有的错误信息
                $arr = array_values($errors);
                $error = $arr[0];//得到第一个错误信息
                exit(json_encode(array('status'=>0,'msg'=>$error)));
            }else{
//                print_r($this->input->post());die;
                $this->load->model('different/Article_model','article',true);
                // $this->article->uid = $this->user->id;//文章所属用户id  hsl
                $this->article->ding_userid = $this->user->ding_userid;//hsl
                $this->article->title = $this->input->post('title',true);//文章标题
                $this->article->column = $this->input->post('column',true);//文章分类
                $this->article->keyword = $this->input->post('keyword',true);//关键字
                $this->article->describe = $this->input->post('describe',true);//描述信息
                $this->article->content = $this->input->post('content',true);//文章内容
                $this->article->sort = $this->input->post('sort',true);//文章排序
                $this->article->dpt = 1;//dpt = 1 表示是部門知识
                 $this->article->department = $_SESSION['default_dept'];//发布文章的人所在的部门
                $this->article->status = 1; //文章的默认状态为1
                $st = $this->article->insert();
                if($st == false){
                    exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
                }

                //确定插入成功之后我们再此操作写入日志表当中
                $this->load->library('action_add');
                $stt = $this->action_add->increase_operating('新增',self::COLUMN_NAME,$this->user->name,$this->input->post('title',true));
                if($stt == false){
                  log_message('error','新增部门知识日志写入失败!');
                }

                exit(json_encode(array('status'=>1,'msg'=>'文章发布成功!')));
            }
        }else{
            //新增文章的时候我们需要查询出所有的栏目也就是文章分类；
            $this->load->model('different/Different_model','diff',true);
            $wheres['where'] = 'id > 0 ';
            $arr  =$this->diff->get_search_list($wheres,0,999999999);
            $data['col'] = $arr;
            $this->load->view('/admin/knowledge/dpt_intellectual_add',$data);
        }
    }

    //修改记录
    public function dpt_intellectual_update($id = ''){
        $this->load->model('different/Article_model','article',true);
        if($this->input->post()){

            //判断当前用户是否有修改权限
            $this->load->model('different/Intellectual_rights_model','intrights',true);
            $ty = 2; //1代表部门知识
            $operation_id = 3;//1代表新增
            $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
            if($num < 1){
                exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权修改此文章!')));
            }

            //服务端进行表单验证
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            //设置验证规则
            $this->form_validation->set_rules('title', '文章标题', 'required',array('required' => '文章标题不能为空！'));
            $this->form_validation->set_rules('column','所属栏目','required',array('required'=>'所属栏目不能为空！'));
            $this->form_validation->set_rules('keyword', '关键词', 'required',array('required' => '关键词不能为空！'));
            $this->form_validation->set_rules('describe','文章描述','required',array('required'=>'文章描述不能为空！'));
            $this->form_validation->set_rules('content', '关键词', 'required',array('required' => '文章内容不能为空！'));
            $this->form_validation->set_rules('sort', '排序', 'required',array('required' => '文章排序不能为空！'));
            $sort = $this->input->post('sort',TRUE);//分类排序
             //php当中0即是empty 空  为了满足测试人员提的要求  我只能单独再在此处判断一下如果是 = 0的时候直接给出提示 排序编号不能为0！
             if(!is_numeric($sort) || $sort == 0){
                exit(json_encode(array('status'=>0,'msg'=>'排序编号必须是数字类型并且不能为0!')));
            }
            //开始判断
            if ($this->form_validation->run() == FALSE){
                $errors = $this->form_validation->error_array();//获取所有的错误信息
                $arr = array_values($errors);
                $error = $arr[0];//得到第一个错误信息
                exit(json_encode(array('status'=>0,'msg'=>$error)));
            }else{
//                print_r($this->input->post());die;
                $this->load->model('different/Article_model','article',true);
                $this->article->retrieve($this->input->post('id',TRUE));
                $tname = $this->article->title;
                if($this->article->id == '' || $this->article->id < 1)
                {
                    exit(json_encode(array('static'=>0,'msg'=>'数据错误!')));
                }

                // $this->article->uid = $this->user->id;//文章所属用户id hsl
                $this->article->ding_userid = $this->user->ding_userid;//hsl
                $this->article->title = $this->input->post('title',true);//文章标题
                $this->article->column = $this->input->post('column',true);//文章分类
                $this->article->keyword = $this->input->post('keyword',true);//关键字
                $this->article->describe = $this->input->post('describe',true);//描述信息
                $this->article->content = $this->input->post('content');//文章内容
                $this->article->sort = $this->input->post('sort',true);//文章排序
                $this->article->status = 1; //文章的默认状态为1
                $st = $this->article->update();
                if($st == false){
                    exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
                }

                //确定修改成功之后我们再此操作写入日志表当中
                $this->load->library('action_add');
                $stt = $this->action_add->increase_operating('修改',self::COLUMN_NAME,$this->user->name,$tname);
                if($stt == false){
                  log_message('error','修改部门知识日志写入失败!');
                }

                exit(json_encode(array('status'=>1,'msg'=>'文章修改成功!')));
            }

        }else{
            if($id == ''){
                exit('用户id不能为空!');
            }
             //新增文章的时候我们需要查询出所有的栏目也就是文章分类；
             $this->load->model('different/Different_model','diff',true);
             $wheres['where'] = 'id > 0 ';
             $arr  =$this->diff->get_search_list($wheres,0,999999999);
             $data['col'] = $arr;

            $this->article->retrieve($id);
            $this->load->view('/admin/knowledge/dpt_intellectual_update',$data);
        }

    }

    //查看操作
    public function show_single($id = ''){
        $this->load->model('different/Article_model','article',true);
        if($id == ''){
            exit('用户id不能为空!');
        }
        $wheres['where'] = " articles.id = $id and articles.status = 1 ";
        $data['list'] = $this->article->get_search_list1($wheres);
        $this->load->view('/admin/knowledge/show_single',$data);
    }

    //删除操作
    public function dpt_intellectual_del(){
         //判断当前用户是否有删除权限
         $this->load->model('different/Intellectual_rights_model','intrights',true);
         $ty = 2;
         $operation_id = 2;
         $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
         if($num < 1){
             exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权删除此文章!')));
         }
        $ids = $this->input->post('id',TRUE);
        if($ids == null){
            exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数!')));
        }
        $ids = trim($ids);
        $arr = explode(',',$ids);


        // $this->load->model('different/Article_model','article',true);
        $this->load->model('different/Action_log_model','action',true);
        $this->load->model('different/Article_model','article',true);
        $this->load->model('different/Article_share_model','article_share',true);
        //循环修改记录当中的status = 0;
        //开启事物
        $this->db->trans_start();
        foreach($arr as $v){
            $this->article->retrieve($v);
            //为对象赋值之后首先要检测合法性
            if($this->article->id == '' || $this->article->id < 1)
            {
                exit("error");
            }
            //此地禁止物理删除  因为一旦共享到部门知识或者公司共享知识 那么如果物理删除 前两者当中将不可见! 也许我删除了我共享的知识 你想再看你会发先现 咿！ 咋没啦！ 岂不是完蛋了！
            $this->article->status = 0;
            $st = $this->article->update();
            if($st){
              //确定修改成功之后我们再此操作写入日志表当中
              $this->load->library('action_add');
              $stt = $this->action_add->increase_operating('删除',self::COLUMN_NAME,$this->user->name,$this->article->title);
              if($stt == false){
                log_message('error','删除部门知识日志写入失败!');
              }
            }
            //下边的操作涉及到了公司共享   判断删除的该篇文章是否已经共享到其他部门（在公司共享当中展示） 如果共享了已经 那么删除的同时 删除共享表当中对应的记录 并且记录该用户对此篇文章的删除操作 并且在公司共享当中以消息的形式展现提示用户此共享在何时被谁删除！
            //第一步：查找是否共享
            $wheres['where'] = "article_id = $v";
            $num = $this->article_share->get_search_nums($wheres);
                //如果$num大于0 说明此文章共享过
            if($num>0){
                //执行删除分享表当中数据的操作!
                $wheres['where'] = "article_id = $v";
                $data = $this->article_share->get_search_list($wheres);
                foreach($data as $vv){
                    //第二步：记录用户删除操作行为
                    $this->action->msg = '文章《'.$this->article->title."》被".$this->user->name."管理员于".date('Y-m-d H:i:s',time())."任性的删除了!想要获取请重新联系".$this->user->name."进行分享操作!";
                    $this->action->to_deptid = $vv['to_deptid'];
                    $this->action->sfgx = 1;
                    $this->action->article_id = $v;
                    $this->action->ly = $this->article->dpt;
                    // $this->action->author = $this->user->name;
                    $sst = $this->action->insert();
                }
                $this->article_share->del_articles($v);
            }

        }
         //提交事物
         $this->db->trans_complete();
         if ($this->db->trans_status() === FALSE){
             exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
         }
         exit(json_encode(array('status'=>1,'msg'=>'文章删除成功!')));
        // if($st == false){
        //     exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
        // }
        // exit(json_encode(array('status'=>1,'msg'=>'文章删除成功!')));
    }


    //知识分享弹出页面
    public function dpt_intellectual_share(){
        //要分享的文章的id集合；
        $ids = $this->input->get('ids',true);
        //前端jq已经验证  后端再次验证！
        if($ids == ''){ exit('error');}
        $this->load->model('users/Department_model','dept',TRUE);
        $where = array();
        $depts = $this->dept->getlist($where,0,99999);
        $data['depts'] = $depts;
        $data['artcle_ids'] = $ids;
        $this->load->view('/admin/knowledge/dpt_intellectual_share',$data);
    }

    //处理知识分享
    public function do_share(){

         //判断当前用户是否有分享权限
         $this->load->model('different/Intellectual_rights_model','intrights',true);
         $ty = 2; //1代表部门知识
         $operation_id = 4;//4代表分享
         $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
         if($num < 1){
             exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权分享文章!')));
         }

        $article_ids = trim($this->input->post('article_ids',true),',');//文章id 可能是多篇文章同时分享
        $deptids = trim($this->input->post('deptids',true),',');//分享到的部门ids  可能会分享到多个部门
        $validate = $this->input->post('validate',true);//-1:永久有效 1:表示临时有效
        $dateTime = $this->input->post('dateTime',true);//临时有效的到期时间
        //安全验证 文章ids 和 部门ids 不能为空!
        if(empty($article_ids) || empty($deptids)){
            exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数(文章id 或 部门ids)')));
        }
        //如果有到期时间 那么到期时间不能小于当前的时间
        if($validate == 1 && strtotime($dateTime) < time() ){
            exit(json_encode(array('status'=>0,'msg'=>'过期时间不能小于当前时间!')));
        }
        //不能分享文件到所在部门
        if(strpos($deptids, $_SESSION["default_dept"]) > -1){
            exit(json_encode(array('status'=>0,'msg'=>'不能分享给文件所在的部门')));
        }

        $ars = explode(',',$article_ids);//Array( [0] => 1 [1] => 2 [2] => 3)
        $dis = explode(',',$deptids); //Array( [0] => 29895193 [1] => 29950204 [2] => 29894176)
        $this->load->model('different/Article_share_model','article_share',true);
        $this->load->model('different/Article_model','article',true);
        //该文件在该部门已经分享过了并且还没有过期就不能在重复分享  如果过期了是可以分享的
        //foreach双层循环 先执行完内部的再执行外部的哦！
        foreach($ars as $v){
            foreach($dis as $v1 ){

                $st = $this->article_share->verify_share($v,$v1,$validate);
                // echo $st;die;
                if($st == -1){
                    exit(json_encode(array('status'=>0,'msg'=>'Hi,缺少必要查询条件!')));
                }elseif($st > 0){
                    exit(json_encode(array('status'=>0,'msg'=>'文章未过期!请勿重复分享!')));
                }elseif($st == -2){
                    exit(json_encode(array('status'=>0,'msg'=>'请勿重复分享!此文章永久有效!')));
                }

                //通过了上边的验证 那么接下来就循环插入到文章分享表当中去
                // $this->article_share->uid = $this->user->id;//分享人为当前登录用户
                $this->article_share->ding_userid = $this->user->ding_userid;// hsl
                $this->article_share->deptid = $_SESSION["default_dept"];//分享人所在部门id
                $this->article_share->article_id = $v;//文章id
                $this->article_share->to_userid = '';//等待开发
                $this->article_share->to_deptid = $v1;//文章分享到的部门
                $this->article_share->status = 1;//共享文件入库状态为1
                $this->article_share->dpt = 2;// dpt字段的值是爲了在回收站列表展示的时候区分个人知识（-1）和部门知识（1）的

                //1:临时有效  -1：永久有效
                if($validate == 1){
                    if($dateTime == ''){
                        exit(json_encode(array('status'=>0,'msg'=>'Hi,请选择到期时间!')));
                    }
                    $this->article_share->share_validity = $dateTime;
                }elseif($validate == -1){
                    //永久有效,到2033-05-18 11:33:20
                    $this->article_share->share_validity = 2000000000;
                }
                $this->article->retrieve($v);
                $st = $this->article_share->insert();
                if($st){
                  //确定修改成功之后我们再此操作写入日志表当中
                  $this->load->library('action_add');
                  $stt = $this->action_add->increase_operating('分享',self::COLUMN_NAME,$this->user->name,$this->article->title);
                  if($stt == false){
                    log_message('error','分享部门知识日志写入失败!');
                  }
                }
            }

        }
        if($st == false){
            exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
        }
        exit(json_encode(array('status'=>1,'msg'=>'Hi,恭喜!文章分享成功!')));

    }
}
