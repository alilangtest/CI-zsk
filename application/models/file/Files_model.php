<?php
/**
 * @package user
 */
class Files_model extends MY_Model
{
    /**
     * 表名
     * @param string
     */
    const TABLE_NAME = 'files';
	//status:-1:逻辑删除;1:新增未审核;2:审核通过;3:审核未通过
    // public $userid;hsl
  public $ding_userid;
  public $deptid;
	public $directory_id;
	public $name;
	public $file_size;
	public $file_type;
	public $file_path;
	public $file_icon;
	public $sort;
	public $updatetime;

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
		if(empty($this->name))
			return false;
        if(empty($this->addtime))
            $this->addtime =time();
        if(empty($this->status))
            $this->status = 0;
        if(empty($this->sort))
            $this->sort = 10;
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
     function insert_batch($data =array())
     {
     	if(count($data) < 1)
     		return true;
     	$this->db->insert_batch(self::TABLE_NAME, $data);
     	return $this->db->affected_rows()>0?true:false;
     }

     public function getlist($data=array(),$order_by=array())
     {
         if( !empty($order_by))
             $this->db->order_by($order_by);
         else
             $this->db->order_by("id","desc");
             $query = $this->db->get_where(self::TABLE_NAME,$data);
             $result = $query->result_array();

         return !empty($result) ? $result : array();
     }

     public function update_batch($data =array())
     {
         if(count($data) < 1)
             return true;
         $this->db->update_batch(self::TABLE_NAME, $data,'id');
         return $this->db->affected_rows() > 0 ? true:false;
     }

     public function delete_batch($where_in = array()){
         if(count($where_in) < 1)
             return true;
         foreach ($where_in as $k=>$v){
             $this->db->where_in($k,$v);
         }
         $this->db->delete(self::TABLE_NAME);
         return $this->db->affected_rows()>0?true:false;
     }

}


/* End of file user.php */
/* Location: /application/models/users/user.php */
