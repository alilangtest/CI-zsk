<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/28
 * Time: 10:31
 * author：huxiaobai
 * 干啥滴：行爲日志model
 */
class Actions_logs_model extends MY_Model{

    const TABLE_NAME = 'actions_logs';

    public $name;//行为名称
    public $executor;//执行者
    public $content;//提醒内容
    public $column;//栏目编号  有了行为名称和栏目编号 我们就可以知道对谁操作了什么操作！

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

}
