<?php  
/**
 * @package user
 */
class Role_rights_model extends MY_Model
{
    /**
     * 表名
     * @param string
     */
    const TABLE_NAME = 'system_role_rights';      
	
    public $role_id;
	public $menu_id;
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
		if(empty($this->role_id) || empty($this->menu_id))
			return false;
        if(empty($this->addtime))
            $this->addtime =time();
        if(empty($this->status))
            $this->id = 0;
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
     function insert_batch($data =array())
     {
     	if(count($data) < 1)
     		return true;
     	$this->db->insert_batch(self::TABLE_NAME, $data);
     	return $this->db->affected_rows()>0?true:false;
     }
    //批量删除数据，慎用。
	function delete_batch($where =array())
     {
     	if(count($where) < 1)
     		return true;
     	$this->db->delete(self::TABLE_NAME, $where);
     	return $this->db->affected_rows()>0?true:false;
     }
	public function get_menus($role_id=0)
	{
		$sql="";
		if($role_id == 2)
			$sql="SELECT id,parentid,name,url,icon,level FROM ".$this->db->dbprefix."system_menu ORDER BY sort ASC,id ASC";
		else
    		$sql="SELECT id,parentid,name,url,icon,level FROM ".$this->db->dbprefix."system_menu WHERE id IN(SELECT menu_id FROM ".$this->db->dbprefix."system_role_rights WHERE role_id = $role_id) ORDER BY sort ASC,id ASC";
    	$query=$this->db->query($sql);
		$result = $query->result_array();
        return !empty($result) ? $result : array();	
    }
}


/* End of file user.php */
/* Location: /application/models/users/user.php */
