<?php
/**
 * @package user
 */
class Department_model extends MY_Model
{
	 const TABLE_NAME = 'department';       //用户表

	 public $ding_dept_id;//	部门id
	 public $name;//	部门名称
	 public $ding_parentid;//父部门id，根部门为1
	 public $order;//在父部门中的次序值
	 public $create_dept_group;//是否同步创建一个关联此部门的企业群, true表示是, false表示不是
	 public $auto_add_user;//当群已经创建后，是否有新人加入部门会自动加入该群, true表示是, false表示不是
	 public $dept_hiding;//是否隐藏部门, true表示隐藏, false表示显示
	 public $dept_permits;//可以查看指定隐藏部门的其他部门列表，如果部门隐藏，则此值生效，取值为其他的部门id组成的的字符串，使用|符号进行分割
	 public $user_permits;//可以查看指定隐藏部门的其他人员列表，如果部门隐藏，则此值生效，取值为其他的人员userid组成的的字符串，使用|符号进行分割
	 public $outer_dept;//是否本部门的员工仅可见员工自己, 为true时，本部门员工默认只能看到员工自己
	 public $outer_permit_depts;//本部门的员工仅可见员工自己为true时，可以配置额外可见部门，值为部门id组成的的字符串，使用|符号进行分割
	 public $outer_permit_users;//本部门的员工仅可见员工自己为true时，可以配置额外可见人员，值为userid组成的的字符串，使用| 符号进行分割
	 public $org_dept_owner;//企业群群主
	 public $dept_manager_userid_list;//部门的主管列表,取值为由主管的userid组成的字符串，不同的userid使用|符号进行分割
	 public $has_sync;
	 public $is_leaf;//是否叶子 默认 0
    public function __construct()
    {
        parent::__construct();
    }
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

		//根据部门id来查询部门信息
		public function retrieve_deptid($id){
			$data = $this->db->select('name')->from(self::TABLE_NAME)->where('ding_dept_id',$id)->get();
			$arr = $data->result_array();
			//部门唯一不可能查找出两个 直接返回吧
			return $arr[0]['name'];
		}

	protected function prepare_insert(&$table_name)
    {
    	if(empty($this->name))
        	return false;
        if(empty($this->status))
            $this->status = 1;
        if(empty($this->has_sync))
        	$this->has_sync=0;
        if(empty($this->addtime))
            $this->addtime =time();
        if(empty($this->is_leaf))
            $this->is_leaf = 0;
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
	function update_batch($data=array(),$field="")
    {
    	if(count($data) < 1 || $field == "")
    		return false;
    	return $this->db->update_batch(self::TABLE_NAME, $data, $field);
    }
     function get_dept_ids()
     {
     	$this->db->select("ding_dept_id");
     	$query = $this->db->get(self::TABLE_NAME);
     	$result = $query->result_array();
        return !empty($result) ? $result : array();
     }
 	public function getlist($data=array(), $start=0, $limit=10)
   {
   		$this->db->order_by("order ASC,id ASC");
        $query = $this->db->get_where(self::TABLE_NAME,$data,$limit,$start);
        $result = $query->result_array();

        return !empty($result) ? $result : array();
	}
	public function update_status($deptids=array(),$status= -99)
    {
    	if( !is_array($deptids) || $status == -99)
    		return FALSE;
        $this->db->where_in('ding_dept_id', $ding_userid);
        $data=array('status'=>$status);
        $this->db->update(self::TABLE_NAME, $data);
        return $this->db->affected_rows()>0?true:false;
    }
    public function get_depts($ids = array())
    {
        if(empty($ids))
        {
            return array();
        }
        $this->db->where_in('ding_dept_id', $ids);
        $query = $this->db->get(self::TABLE_NAME);
        $result = $query->result_array();

        return !empty($result) ? $result : array();
    }

    public function get_children($id ='') {
        if(empty($id)){
            return array();
        }
        $sql="SELECT *
                FROM
                	(
                		SELECT
                			*
                		FROM
                			nd_department
                		ORDER BY
                			ding_parentid,
                			ding_dept_id
                	) organization,
                	(SELECT @pv := '".$id."') initialisation
                WHERE
                	find_in_set(ding_parentid, @pv) > 0
                AND @pv := concat(@pv, ',', ding_dept_id)";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return !empty($result) ? $result : array();
    }

     //查询前置操作 返回表名称以及查询之前的一些操作 必须实现该方法
     protected function prepare_search(&$table_name)
     {
         $table_name = self::TABLE_NAME;
         return TRUE;
     }

}
