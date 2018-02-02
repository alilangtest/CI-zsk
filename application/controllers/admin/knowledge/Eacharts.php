<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * Date: 2017/11/15
 * Time: 8:47
 * 干啥滴：图形报表分类
 * author：huxiaobai
 */
class Eacharts extends MY_Controller{

    function __construct()
	{
		parent::__construct();
		if($this->is_login == false)
			redirect('/');
	}

	public function index()
	{
       //查询出所有的部门 以及 该部门下所属的员工数量
       //首先查询出所有的部门都有哪些
       $wheres['select'] = "name,ding_dept_id";
       $wheres['where'] = "ding_dept_id != 'a1'";
       $this->load->model('users/Department_model','dept',TRUE);
       $this->load->model('users/User_model','user',TRUE);
       $this->load->model('different/Article_share_model','article_share',true);
       $this->load->model('different/Article_model','article',true);
       $arr = $this->dept->get_search_list($wheres,0,99999999);
       $array = array();
       //遍历循环部门ding_dept_id
       foreach($arr as $v){
           $department = $v['ding_dept_id'];
           $name = $v['name'];
           $num = $this->user->get_single($department);
           $array[] = "{name:\"$name\",y:$num}";
       }
       //柱状图数据：
       $dataArr = join($array,',');
       //接下来为饼状图提供数据
       $wheres['where'] = 'dpt = -1';
       $num1 = $this->article->get_search_nums($wheres);
       $wheres['where'] = 'dpt = 1';
       $num2 = $this->article->get_search_nums($wheres);
       $wheres['where'] = 'dpt = 2';
       $num3 = $this->article_share->get_search_nums($wheres);
       $gr = $num1>0?sprintf("%.2f", $num1/($num1+$num2+$num3)*100):0;
       $bm = $num1>0?sprintf("%.2f", $num1/($num1+$num2+$num3)*100):0;
       $fx = $num1>0?sprintf("%.2f", $num1/($num1+$num2+$num3)*100):0;
       $data['arr'] = "['个人知识',$gr],['部门知识',$bm],['公司分享',$fx]";
       $data['list'] = $dataArr;
	     $this->load->view('/admin/knowledge/eacharts_list',$data);
    }

}
?>
