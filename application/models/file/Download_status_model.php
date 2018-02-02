<?php  
/**
 * @package user
 */
class Download_status_model extends MY_Model
{
    /**
     * 表名
     * @param string
     */
    const TABLE_NAME = 'download_status';      
	//status:0:正在压缩；1：压缩完成正在下载
    public $msg;   //压缩率
	public $request_id;
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
    public function retrieve_by_req_id($id)
    {
        if (empty($id))
        {
            log_message(parent::ERROR_LEVEL, "Missing input parameters--" . get_class($this));
            return false;
        }
    
        $result = $this->db->select('*')
        ->where('request_id', $id)
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
        if(empty($this->addtime))
            $this->addtime =time();
        if(empty($this->status))
            $this->status = 0;
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
}


/* End of file user.php */
/* Location: /application/models/users/user.php */
