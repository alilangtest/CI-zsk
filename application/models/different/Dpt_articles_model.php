<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/3
 * Time: 10:58
 * author：huxiaobai
 * 干啥滴：部門知识库文章model
 */
class Dpt_articles_model extends MY_Model{

    const TABLE_NAME = 'dpt_articles';

    public $uid;//所属用户id
    public $dpt;//当前用户所在部门
    public $title;//名称
    public $column;//所属分类
    public $keyword;//关键词
    public $describe;//描述信息
    public $content;//内容
    public $sort;//排序


    /**
     * Constructor.
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
    public function get_search_list1($wheres = array(), $start = 0, $limit = 10){
        if(empty($wheres)){
            exit("缺少必要参数");
        }
        $this->db->select('dpt_articles.*,different.tname');
        $this->db->from('dpt_articles');
        $this->db->join('different','dpt_articles.column = different.id','left');
        $this->db->where($wheres['where']);
        $this->db->limit($limit,$start);
        $arr = $this->db->get();
//        $str = $this->db->last_query();
//        print_r($str);die;
//        print_r($arr->result_array());die;
        return !empty($arr)?$arr->result_array():array();
    }

}