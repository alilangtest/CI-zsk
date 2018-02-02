<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/7
 * Time: 14:56
 * author：huxiaobai
 * 干啥滴：知识库权限分配表
 */
class Intellectual_rights_model extends MY_Model{

    const TABLE_NAME = 'intellectual_rights';

    // public $userid;//权限分配给了哪个用户
    public $ding_userid;//hsl 关联用户信息改用ding_userid
	  public $deptid;//部门
    public $operation_id;  //1：删除 2：修改 3：分享 4：恢复
    public $ty; //1：知识分类 2：部门知识 3：公司共享 4：回收站


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

    //验证权限是否重复
    public function verify_permissions($userid = '',$operation_id = '',$ty = ''){
        if($userid == '' || $operation_id == '' || $ty == ''){
            exit('哎呀!缺少必要参数!');
        }
        $this->db->select();
        $this->db->from(self::TABLE_NAME);
        $this->db->where("userid = $userid and operation_id = $operation_id and ty = $ty ");
        $data = $this->db->get();
        return $data->num_rows();
    }

    //删除该用户全部数据  谨慎操作 用到了事物！
    public function retrieve_del($userid = '')
    {
        if (empty($userid))
        {
            exit('哎呀!缺少必要参数!');
        }
        $this->db->where("userid = $userid");
        $this->db->delete(self::TABLE_NAME);
        return $this->db->affected_rows()>0?true:false;
    }

    //判断当前用户对某个栏目是否有某项权限
    public function authentication($userid = '',$ty = '',$operation_id = ''){
        if($userid == '' || $ty == '' || $operation_id == ''){
            exit('哎呀!缺少必要参数!');
        }
        $arr = $this->db->select('*')->from(self::TABLE_NAME)->where("ding_userid = $userid and ty = $ty and operation_id = $operation_id ")->get();
        $num = $arr->num_rows();
        return $num;
    }

}
?>
