<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * Date: 2017/10/30
 * Time: 9:45
 * 干啥滴：知识库分类
 * author：huxiaobai
 */
class Different extends MY_Controller
{
   const COLUMN_NAME = '知识分类';
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
    //展示分类列表
    public function different_set(){
        $this->load->model('different/Different_model','diff',true);
        $kw = $this->input->get('kw',TRUE);
        if($kw && $kw != ''){
           $wheres['where'] = " tname like '%$kw%' OR author like '%$kw%' ";
        }
        $wheres['order_by']='sort asc'; //分类编号越小越靠前
        //分页
        $this->load->library('pagination');//装载类文件
        //每一页显示的数据条数的变量
        $page_size=9;
        $config['base_url']=site_url("admin/knowledge/different/different_set/");
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

        $config['total_rows']=$this->diff->get_search_nums($wheres);//总的记录数
        $this->pagination->initialize($config);
        $offset=intval($this->uri->segment(5));//用intval使空格转0，显示出来0
        $data['situation'] = $this->diff->get_search_list($wheres,$offset,$page_size);
        $data['total_rows'] = $config['total_rows'];
        $this->load->view('/admin/knowledge/different_set',$data);
    }

    /*
     * 点击"新增分类"弹框页面 以及 在弹框页面当中点击提交到该方法
     * 通过判断post数据是否为空 进行逻辑处理
     * */
    public function different_add(){
        if(!empty($this->input->post())){
            //判断当前用户是否有新增权限
            $this->load->model('different/Intellectual_rights_model','intrights',true);
            $ty = 1; //1代表知识分类
            $operation_id = 1;//1代表新增
            $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
            if($num < 1){
                exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权新增分类!')));
            }

            $tname = $this->input->post('tname',TRUE);//分类名称
            $sort = $this->input->post('sort',TRUE);//分类排序
            //php当中0即是empty 空  为了满足测试人员提的要求  我只能单独再在此处判断一下如果是 = 0的时候直接给出提示 排序编号不能为0！
            if(!is_numeric($sort) || $sort == 0){
                exit(json_encode(array('status'=>0,'msg'=>'排序编号必须是数字类型并且不能为0!')));
            }
            //对接收到的名称和排序做是否为空验证
            if(empty($tname) || empty($sort)){
                exit(json_encode(array('status'=>0,'msg'=>'分类名称和排序都不能为空!')));
            }
            $this->load->model('different/Different_model','diff',true);
            //分类不能重复  别人创建了分类那么你就不能创建相同名称的分类
            if($this->diff->retrieve_tname($tname) > 0){
                exit(json_encode(array('status'=>0,'msg'=>'呜呜!分类名称已被占用!')));
            }
            // $this->diff->uid = $this->user->id;//登陆用户id hsl
            $this->diff->ding_userid = $this->user->ding_userid;// hsl
            $this->diff->tname = $tname;//分类名称
            $this->diff->sort = $sort;//分类排序
            $this->diff->author = $this->user->name;//发布人姓名 直接入库 避免链表查询
            $st = $this->diff->insert();
            if($st == false){
                exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
            }
            //确定插入成功之后我们再此操作写入日志表当中
            $this->load->library('action_add');
            $stt = $this->action_add->increase_operating('新增',self::COLUMN_NAME,$this->user->name,$tname);
            if($stt == false){
              log_message('error','新增分类日志写入失败!');
            }

            exit(json_encode(array('status'=>1,'msg'=>'分类添加成功!')));

        }else{
            $this->load->view('/admin/knowledge/different_add');
        }

    }

    //删除记录   (删除分类只能有管理员来删除!删除的时候必须给出提示信息!)
    public function different_del(){
        //判断当前用户是否有删除权限
        $this->load->model('different/Intellectual_rights_model','intrights',true);
        $ty = 1; //1代表知识分类
        $operation_id = 2;//2代表删除
        $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
        if($num < 1){
            exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权删除该分类!')));
        }

        $ids = $this->input->post('id',TRUE);
        $data_ids = explode(',',$ids);

        $this->load->model('different/article_model','article',true);
        $this->load->model('different/Different_model','diff',true);
        foreach($data_ids as $v){
            //要删除的分类id不能为null
            if($v == null){
                exit(json_encode(array('status'=>0,'msg'=>'缺少必要参数!')));
            }
             //需要判断要删除的分类下是否还存在文章;如果存在就不能删除该分类
            if($this->article->retrieve_column($v) > 0){
                exit(json_encode(array('status'=>0,'msg'=>'分类下有文章存在!禁止删除!')));
            }
            //循环删除
            $this->diff->retrieve($v);
            $tname = $this->diff->tname;
            $st =  $this->diff->delete();
            //确定删除成功之后我们再此操作写入日志表当中
            if($st){
              $this->load->library('action_add');
              $stt = $this->action_add->increase_operating('删除',self::COLUMN_NAME,$this->user->name,$tname);
              if($stt == false){
                log_message('error','删除分类日志写入失败!');
              }
            }
        }

       if($st == false){
           exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
       }
        exit(json_encode(array('status'=>1,'msg'=>'分类删除成功!')));

    }

    //修改记录
    public function different_update($id = ''){

        $this->load->model('different/Different_model','diff',true);
        if($this->input->post()){

            //判断当前用户是否有修改权限
            $this->load->model('different/Intellectual_rights_model','intrights',true);
            $ty = 1; //1代表知识分类
            $operation_id = 3;//3代表修改
            $num = $this->intrights->authentication($this->user->ding_userid,$ty,$operation_id);
            if($num < 1){
                exit(json_encode(array('status'=>0,'msg'=>'抱歉!您无权修改该分类!')));
            }

            $tname = $this->input->post('tname',TRUE);//分类名称
            $sort = $this->input->post('sort',TRUE);//分类排序
            $id = $this->input->post('id',TRUE);//记录id
             //php当中0即是empty 空  为了满足测试人员提的要求  我只能单独再在此处判断一下如果是 = 0的时候直接给出提示 排序编号不能为0！
             if(!is_numeric($sort) || $sort == 0){
                exit(json_encode(array('status'=>0,'msg'=>'排序编号必须是数字类型并且不能为0!')));
            }
            //对接收到的名称和排序做是否为空验证
            if(empty($tname) || empty($sort)){
                exit(json_encode(array('status'=>0,'msg'=>'分类名称和排序都不能为空!')));
            }
            $this->diff->retrieve($id);
            if($this->diff->id == '' || $this->diff->id < 1)
            {
                exit(json_encode(array('status'=>0,'msg'=>'数据错误!')));
            }
            $sname = $this->diff->tname;
            $this->diff->tname = $tname;
            $this->diff->sort = $sort;
            $st = $this->diff->update();//更新数据操作
            if($st == false){
                exit(json_encode(array('status'=>0,'msg'=>'数据库执行错误!请联系管理员!')));
            }
            //确定修改成功之后我们再此操作写入日志表当中
            $this->load->library('action_add');
            $stt = $this->action_add->increase_operating('修改',self::COLUMN_NAME,$this->user->name,$sname);
            if($stt == false){
              log_message('error','修改分类日志写入失败!');
            }
            exit(json_encode(array('status'=>1,'msg'=>'数据修改成功!')));

        }else{
            if($id == ''){
                exit('用户id不能为空!');
            }
            $this->diff->retrieve($id);
            $this->load->view('/admin/knowledge/different_update');
        }

    }


}





?>
