<?php
/**
 * @package user
 */
class Share_model extends MY_Model
{
    /**
     * 表名
     * @param string
     */
    const TABLE_NAME = 'share';
	//status:0:逻辑删除;1:正常可用;
    // public $userid;   //文件或文件夹所属用户
  public $ding_userid;//hsl
  public $deptid;   //文件或文件夹所属部门
	public $directory_id;   //目录id
	public $file_id;  //文件id
	public $to_userid;   //分享给用户id
	public $to_deptid;   //分享给部门id
	public $share_validity;   //有效期到期时间(2000000000：表示永久有效)

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
    
    //这个方法写的很臃肿 要下班了！就这样吧！
    public function retrieve_aa($file_id = '',$type_id = ''){
        if($file_id == '' || $type_id == ''){
            exit('缺少必要参数');
        }
        if($type_id == 'folder'){
            $num = $this->db->select('*')->from(self::TABLE_NAME)->where("directory_id = $file_id")->count_all_results();
            if($num > 0){ $this->db->set('status',0)->where("directory_id = $file_id")->update(self::TABLE_NAME); }
        }elseif($type_id == 'file'){
            $num = $this->db->select('*')->from(self::TABLE_NAME)->where("file_id = $file_id")->count_all_results();
            if($num > 0){ $this->db->set('status',0)->where("file_id = $file_id")->update(self::TABLE_NAME); }
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
		if(empty($this->directory_id)||empty($this->file_id))
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
    function insert_batch($data =array())
    {
        if(count($data) < 1)
     	    return true;
     	$this->db->insert_batch(self::TABLE_NAME, $data);
     	return $this->db->affected_rows()>0?true:false;
    }

    function get_nums($id='',$deptid='')
    {
        if(!empty($id)&&(!empty($deptid))){
            $where = "to_deptid='".$deptid."' AND (directory_id='".$id."' OR file_id='".$id."') AND share_validity > unix_timestamp(now())";
            $this->db->where($where);
            $this->db->from(self::TABLE_NAME);
            return $this->db->count_all_results();
        }
        return 0;
    }

    public function get_search_list($wheres=array(), $start=0, $limit=10)
    {
        $this->db->select(self::TABLE_NAME.'.*,nd_directory.name as dir_name,nd_files.name as file_name,nd_files.file_path,
            nd_files.file_type,nd_files.file_icon,nd_files.file_size,nd_department.name as dept_name,d2.name as to_dept_name');
        $this->db->from(self::TABLE_NAME);
        $this->db->join('nd_directory', 'nd_directory.id = nd_'.self::TABLE_NAME.'.directory_id','left');
        $this->db->join('nd_files', 'nd_files.id = nd_'.self::TABLE_NAME.'.file_id','left');
        $this->db->join('nd_department', 'nd_department.ding_dept_id = nd_'.self::TABLE_NAME.'.deptid','left');
        $this->db->join('nd_department d2', 'd2.ding_dept_id = nd_'.self::TABLE_NAME.'.to_deptid','left');
        if( !empty($wheres))
     	{
     		if(isset($wheres['where']) && is_array($wheres['where']))
     		    foreach ($wheres['where'] as $k=>$v)
     		        $this->db->where(self::TABLE_NAME.'.'.$k,$v);
            if(isset($wheres['like']) && is_array($wheres['like']))
            {
                foreach ($wheres['like'] as $k=>$v)
                    $this->db->like(self::TABLE_NAME.'.'.$k,$v);
            }
     		if(isset($wheres['where_in']) && is_array($wheres['where_in']))
     		{
     		    foreach ($wheres['where_in'] as $k=>$v)
     		        $this->db->where_in(self::TABLE_NAME.'.'.$k,$v);
     		}
     		if(isset($wheres['order_by'])&& is_array($wheres['order_by']))
     		    foreach ($wheres['order_by'] as $k=>$v)
     		        $this->db->order_by(self::TABLE_NAME.'.'.$k,$v);
     		else
     			$this->db->order_by(self::TABLE_NAME.".id","desc");
     	}
     	$this->db->limit($limit,$start);
        $query = $this->db->get();
        $result = $query->result_array();
        return !empty($result) ? $result : array();
    }
}


/* End of file user.php */
/* Location: /application/models/users/user.php */
