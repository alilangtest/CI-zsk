<?php
/**
 * @package user
 */
class User_dept_model extends MY_Model
{
    /**
     * 表名
     * @param string
     */
    const TABLE_NAME = 'user_dept_rights';

  // public $userid;
  public $ding_userid;
	public $deptid;
	public $operation_id;  //1：移动；2：删除；3：审核；4：分享；5：重命名文件夹；6：回收站管理
    /**
    * Constructor.
    */
    public function __construct()
    {
        parent::__construct();
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
		if(empty($this->ding_userid) || empty($this->deptid))
			return false;
        if(empty($this->addtime))
            $this->addtime =time();
        if(empty($this->status))
            $this->status = 1;
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

        $table_name = self::TABLE_NAME;

        return true;
    }

    public function post_insert()
    {
        return true;
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
    //批量删除数据，慎用。
    function delete_batch($where =array())
    {
        if(count($where) < 1)
            return true;
        $this->db->delete(self::TABLE_NAME, $where);
        return $this->db->affected_rows()>0?true:false;
    }
    function insert_batch($data =array())
    {
        if(count($data) < 1)
     		return true;
     	$this->db->insert_batch(self::TABLE_NAME, $data);
     	return $this->db->affected_rows()>0?true:false;
    }

//     function get_users($deptid='')
//     {
//         if(empty($deptid)){
//             return array();
//         }
//         $query = $this->db->select('*')
//         ->where('deptid', $deptid)
//         ->get(self::TABLE_NAME);
//         $result = $query->result_array();
//         return !empty($result) ? $result : array();
//     }

    function count_nums($data=array())
    {
        $where = '';
        if(!empty($data)){
            foreach($data as $key => $value){
                $where .= " AND `$key` = '$value'";
            }
        }
        $sql="SELECT COUNT(id) nums FROM ".$this->db->dbprefix.self::TABLE_NAME." WHERE 1=1  $where";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return !empty($result) ? $result : array();
    }
}


/* End of file user.php */
/* Location: /application/models/users/user.php */
