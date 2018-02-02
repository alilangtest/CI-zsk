<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/10/31
 * Time: 9:58
 * author：huxiaobai
 * 干啥滴：知识库文章model
 */
class Article_model extends MY_Model{

    const TABLE_NAME = 'articles';
    // public $uid;//所属用户id
    public $ding_userid;//hsl 关联用户信息改用ding_userid
    public $title;//名称
    public $column;//所属分类
    public $keyword;//关键词
    public $describe;//描述信息
    public $content;//内容
    public $sort;//排序
    public $dpt;// -1:个人知识   1:部门知识
    public $department;//发布人所在的部门id


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    //查询前置操作 返回表名称以及查询之前的一些操作 必须实现该方法
    protected function prepare_search(&$table_name)
    {
        $table_name = self::TABLE_NAME;
        return TRUE;
    }

    /**
     * Prepares for the insert of the borrow object.
     *
     * @param string $table_name
     * @return boolean
     */
    protected function prepare_insert(&$table_name)
    {
        $table_name = self::TABLE_NAME;
        return true;
    }

    /**
     * Retrieves the matching borrow object from the database.
     *
     * @param string $id
     * @return boolean
     */
    public function retrieve($id)
    {
        if (empty($id))
        {
            log_message(parent::ERROR_LEVEL, "Missing input parameters--" . get_class($this));
            return false;
        }

        $result = $this->db->select('*')
            ->where('id', $id)
            ->limit(1)
            ->get(self::TABLE_NAME);

        if($result->num_rows() > 0)
        {
            $this->result_load($result->row());
            $result->free_result();

            if(!$this->isEmpty())
                return true;
            else
                return false;
        }
        else
        {
            $result->free_result();
            return false;
        }
    }

    //如果是超级管理员来删除分类 那么我们需要判断该分类下时候还存在文章
    public function retrieve_column($column = ''){
        if($column == ''){
            exit('缺少必须参数$column');
        }
        $this->db->select();
        $this->db->from(self::TABLE_NAME);
        $this->db->where('column',$column);
        $result = $this->db->get();
        $num = $result->num_rows();
        return $num;
//
    }

    /**
     * Prepares the current borrow for delete.
     * @param string $table_name
     * @return true if successful, false if not.
     */
    protected function prepare_delete(&$table_name)
    {
        if(!parent::prepare_delete($table_name))
        {
            log_message(parent::ERROR_LEVEL, "Missing input parameters--prepare_delete--" . get_class($this));
            return false;
        }

        $table_name = self::TABLE_NAME;
        return true;
    }

    /**
     * Prepares for the update of the borrow object.
     *
     * @param string $tableName
     * @return boolean
     */
    protected function prepare_update(&$table_name)
    {
        if(!parent::prepare_update($table_name))
        {
            log_message(parent::ERROR_LEVEL, "Missing input parameters--prepare_update--" . get_class($this));
            return false;
        }

        if(empty($this->id))
            return  FALSE;
        if(empty($this->updatetime))
            $this->updatetime = time();
        $table_name = self::TABLE_NAME;

        return true;
    }
    //这里是get_search_list1 而不是get_search_list 哦！
    //get_search_list满足不了链表查询的需求  get_search_list1涉及到链表查询
    public function get_search_list1($wheres = array(), $start = 0, $limit = 999999){
        if(empty($wheres)){
            exit("缺少必要参数");
        }
       $this->db->select('articles.*,different.tname,department.name,user.name as username');
        $this->db->from('articles');
        $this->db->join('different','articles.column = different.id','left');
        $this->db->join('department','articles.department = department.ding_dept_id','left');
        $this->db->join('user','articles.ding_userid = user.ding_userid');
        $this->db->where($wheres['where']);
        $this->db->order_by('articles.sort asc');
        $this->db->limit($limit,$start);
        $arr = $this->db->get();
        $str = $this->db->last_query();
        return !empty($arr)?$arr->result_array():array();
    }

}
