<?php
/**
 * @package user
 */
class User_model extends MY_Model
{
    /**
     * 表名
     * @param string
     */
    const TABLE_NAME = 'user';       //用户表
	const USERREGIESTEXTENDUSERID = 'USERREGIESTEXTENDUSERID';
    /**
     * 用户类型：
     * 1超级管理员 2普通管理员 3客服 4财务
     * 0普通个人用户
     **/
    const TYPE_USER     = 0;
	const TYPE_CHAOGUAN = 1;
    const TYPE_PUTONG   = 2;
    const TYPE_KEFU     = 3;
    const TYPE_CAIWU    = 4;
    const TYPE_QIYE     = 5;

    /**
    * is_lock是否锁定 0否 1是
    * default 0
    */
    const LOCK_NO       = 0;
    const LOCK_YES      = 1;

    /**
    * status 是否注销  0否 1是  cancel
    * default 0
    */
    const CANCEL_NO     = 0;
    const CANCEL_YES    = 1;
    /**
     * 用户登录USERID COOKIE
     */
    const COOKIE_LOGIN = "LOGINUSERID";
    /**
     * 用户登录令牌 COOKIE
     */
    const COOKIE_LOGIN_TOKEN = "LOGINTOKEN";
    /**
     * 用户活动时间  超时自动退出
     */
    const ON_LINE_TIME = 'ON_LINE_TIME';
    /**
     * 管理员登录USERID COOKIE
     */
    const COOKIE_MANAGER_LOGIN = "LOGINMANGERID";
    /**
     * 管理员登录令牌 COOKIE
     */
    const COOKIE_MANAGER_LOGIN_TOKEN = "LOGINMANGERTOKEN";
    /**
     * 管理员登录IP COOKIE
     */
    const COOKIE_MANAGER_LOGIN_IP = "LOGINMANGERIP";
    /**
     * 验证码session的前缀
     */
    const SESSION_FIX_VERIFY_CODE = "VERIFY_CODE";

    const LOGIN_STATUS_NORMAL=0;
    const LOGIN_STATUS_ERROR=-1;
    /**
     * 用户类型：
     * 1超级管理员 2普通管理员 3客服 4财务 5催收 6信贷审核 7论坛管理员
     * 0普通个人用户,8企业用户
     * default:0
     * @var int
     **/
    public $type_id;//
    public $openid;//微信ID
    public $password;//
    public $ding_userid;//钉钉userid
    public $name;//成员名称
    public $tel;//分机号（ISV不可见）
    public $work_place;//办公地点（ISV不可见）
    public $remark;//备注（ISV不可见）
    public $mobile;//手机号码（ISV不可见）
    public $email;//员工的电子邮箱（ISV不可见）
    public $org_email;//员工的企业邮箱（ISV不可见）
    public $active;//是否已经激活, true表示已激活, false表示未激活
    public $order_in_depts;//在对应的部门中的排序, Map结构的json字符串, key是部门的Id, value是人员在这个部门的排序值
    public $is_admin;//是否为企业的管理员, true表示是, false表示不是
    public $is_boss;//是否为企业的老板, true表示是, false表示不是
    public $dingid;//钉钉Id,在钉钉全局范围内标识用户的身份,但用户可以自行修改一次
    public $unionid;//在当前isv全局范围内唯一标识一个用户的身份,用户无法修改
    public $is_leader_in_depts;//在对应的部门中是否为主管, Map结构的json字符串, key是部门的Id, value是人员在这个部门中是否为主管, true表示是, false表示不是
    public $is_hide;//是否号码隐藏, true表示隐藏, false表示不隐藏
    public $department;//成员所属部门id列表
    public $position;//职位信息
    public $avatar;//头像url
    public $jobnumber;//员工工号
    public $extattr;//扩展属性，可以设置多种属性(但手机上最多只能显示10个扩展属性，具体显示哪些属性，请到OA管理后台->设置->通讯录信息设置和OA管理后台->设置->手机端显示信息设置)
    public $roles;//角色信息（ISV不可见），json数组格式
//    public $roles_id;//角色id（ISV不可见）
//    public $roles_name;//角色名称（ISV不可见）
//    public $roles_group_name;//角色分组名称（ISV不可见）

    public $logintimes;//登录次数
    public $_ip;
    public $lasttime;//最后登录时间
    public $lastip;//最后登录IP
    public $islock;
    public $has_sync;//是否和钉钉同步过详细信息 1：是	0：否
	//网站实际运行根目录
    public $_root_dir;
    
    public $_dept; //

    /**
    * Constructor.
    */
    public function __construct()
    {
        parent::__construct();

        if(!$this->input->is_cli_request())
        {
            $this->load->library('session');
            $this->_ip   = $this->input->ip_address();
        }
        $this->_root_dir = dirname(BASEPATH);
    }
    /**
    * Retrieves the matching borrow object from the database.
    *
    * @param string $id
    * @return boolean
    */
    public function retrieve($id='')
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
    * 根据手机号获取用户信息
    */
   public function retrieve_mobile($mobile='')
   {
   		if($mobile == '')
   			return false;
      	$result = $this->db->select('*')
                ->where('mobile', $mobile)
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
    public function retrieve_openid($id="")
    {
      if (empty($id))
      {
          log_message(parent::ERROR_LEVEL, "Missing input parameters--" . get_class($this));
          return false;
      }

      $result = $this->db->select('*')
                ->where('openid', $id)
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
    public function retrieve_unionid($id="")
    {
      if (empty($id))
      {
          log_message(parent::ERROR_LEVEL, "Missing input parameters--" . get_class($this));
          return false;
      }

      $result = $this->db->select('*')
                ->where('unionid', $id)
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
	public function retrieve_ding_userid($id="")
    {
      if (empty($id))
      {
          log_message(parent::ERROR_LEVEL, "Missing input parameters--" . get_class($this));
          return false;
      }

      $result = $this->db->select('*')
                ->where('ding_userid', $id)
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
     * Prepares for the insert of the borrow object.
     *
     * @param string $table_name
     * @return boolean
     */
    protected function prepare_insert(&$table_name)
    {
        if(empty($this->status))
            $this->status = self::CANCEL_NO;

        if(empty($this->type_id))
            $this->type_id = self::TYPE_USER;

        if(empty($this->islock))
            $this->islock = self::LOCK_NO;
        $time= time();
        if(empty($this->logintimes))
            $this->logintimes = 1;
        if(empty($this->addtime))
            $this->addtime =$time;
        if(empty($this->addip))
            $this->addip = $this->_ip;
        if(empty($this->lasttime))
            $this->lasttime = $time;
        if(empty($this->has_sync))
            $this->has_sync = 0;
        if(empty($this->lastip))
            $this->lastip = $this->_ip;

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
	protected function prepare_search(&$table_name)
	{
		$table_name = self::TABLE_NAME;
        return TRUE;
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

    /**
    * 更新用户最后登录时间，登录次数+1
    *
    * @param  integer $id
    */
    public function update_login_info()
    {
        if(empty($this->user->id))
        {
            return false;
        }

        $arr_update = array(
                    'lastip' => $this->_ip, 'lasttime' => time(),
                    'logintimes' => $this->user->logintimes+1
                );
		$this->db->update( self::TABLE_NAME , $arr_update, array('id' => $this->user->id) );
        if($this->db->affected_rows())
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
    * 记住用户登录状态
    *
    * @param  integer  $id
    * @return boolean
    */
   private function remember_user($id)
   {
        if ( ! $id)
        {
             return FALSE;
        }

        return TRUE;
   }

   /**
    * 根据部门获取用户列表
    * @param array $data   where条件
    * @param start
    * @param limit
    */
   public function get_users_by_dept($dept_id=0)
   {
   		if($dept_id == 0)
   			return array();
   		$this->db->select('*');
   		if($dept_id == 1)
   			$this->db->where("department","[a1]");
   		else
   			$this->db->like("department",$dept_id);
        $query = $this->db->get('user');
        $result = $query->result_array();
        return !empty($result) ? $result : array();
   }

     function count_nums($data=array(),$data_like=array())
     {
     	$where = '';
	       if(!empty($data)){
	           foreach($data as $key => $value){
	                $where .= " and `$key` = '$value'";
	           }
	       }
	       if(!empty($data_like)){
	           foreach($data_like as $key => $value){
	                $where .= " and `$key` like '%$value%'";
	           }
	       }
     	$sql=" select count(id) nums from ".$this->db->dbprefix.'user'." where 1=1  $where order by id desc";
     	$query = $this->db->query($sql);
     	$result = $query->result_array();
        return !empty($result) ? $result : array();
     }

    public $_data;
    public function search_user($query = array())
    {
        $this->_data = array();
        //页数
        $this->_data['page'] = isset($query['page'])?$query['page']:1;
        //每页显示个数
        $this->_data['per_page_n'] = isset($query['per_page_n'])?$query['per_page_n']:15;
        if(isset($query['filter_a_clear'])) unset($this->_data['_filter_a']);
        //查询条件: 等于 like
        $query_filter_query = '';
        if(isset($query['filter_a'])){
            foreach ($query['filter_a'] as $key => $value){
                if($key == 'username' || $key == 'realname' || $key == 'email')
                    $query_filter_query .= $key." like '%".$value."%' AND ";
                else{
                    $query_filter_query .= $key." = '".$value."' AND ";
                }
            }
        }
        //查询条件: 不等于
        if(isset($query['filter_b'])){
            foreach ($query['filter_b'] as $key => $value){
                if(is_array($value))
                {
                    foreach ($value as $val)
                    {
                        $query_filter_query .= $key." != '".$val."' AND ";
                    }
                }
                else{
                    $query_filter_query .= $key." != '".$value."' AND ";
                }

            }
        }

        $this->_data['filter_query']  =  isset($query_filter_query)?$query_filter_query.'id != 0':'id != 0';

        //构造排序参数
        if(isset($query['order_clear'])) unset($this->_data['_order']);
        if(isset($query['order'])){
                $this->_data['_order']  =  $query['order'];
        }
        $this->_data['filter_order'] = isset($this->_data['_order'])?$this->_data['_order']:'id DESC';

        $result['result_list']  =  $this->find_all();//echo $this->db->last_query();
        $result['count_all']    =  $this->get_count();

        return $result;

    }
    /**
     * 获取字段元数据
     *
     * @access public
     * @param  model_name
     * @return array
     */
    public function get_field()
    {
    	return $this->db->field_data(self::TABLE_NAME);
    }
    /**
     * 获取总行数
     *
     * @access public
     * @param  model_name
     * @return int
     */
    public function get_count()
    {
        if(!empty($this->_data['filter_query']))
        {
            $this->db->where($this->_data['filter_query']);
            return $this->db->count_all_results(self::TABLE_NAME);//查看执行的sql语句
        }
        else
        {
            return  $this->db->count_all(self::TABLE_NAME);
        }

    }


    /**
     * 获取数据行
     *
     * @access public
     * @param  filter_order filter_query page per_page_n model_name
     * @return result_array or false
     */
    public function find_all()
    {

        $this->db->order_by($this->_data['filter_order']);
        $this->db->limit($this->_data['per_page_n'],($this->_data['page']-1)*$this->_data['per_page_n']);
        $this->db->select(self::TABLE_NAME.'.*');

        if($query = $this->db->get_where(self::TABLE_NAME, $this->_data['filter_query']))
        {
                return $query->result_array();
        }
        return false;
    }

    /**
     * Checks if the input role is a valid manager role type.
     * 检查是否有登陆后台的权限
     * @param string $role
     * @return boolean
     */
    static public function is_manager_role($role)
    {
        if (empty($role))
            return false;

        $role_vals = array(self::TYPE_CHAOGUAN, self::TYPE_PUTONG,
            self::TYPE_KEFU, self::TYPE_CAIWU);

        return in_array($role, $role_vals);
    }

    /**
     * Checks if the current manager has all input roles.
     *
     * @param array $roles 最低需要的权限组
     * @return boolean True if has some role, false if not.
     */

    public function has_roles($roles)
    {
        if (empty($roles) || !is_array($roles) || !self::is_manager_role($this->type_id))
            return false;

        foreach($roles as $role)
        {
            if($this->has_role($role))
                return true;
        }

        return false;

    }

    /**
     * Checks if the current manager has role access.
     * This method takes permission level into account, where as an admin always have access.
     *
     * @param string $role 最低需要的权限
     * @return boolean True if manager has role, false if not.
     */
    public function has_role($role)
    {
        if (empty($role) || !self::is_manager_role($this->type_id))
            return false;

        switch ($role)
        {
            case self::TYPE_CHAOGUAN:
                switch ($this->type_id)
                {
                    case self::TYPE_CHAOGUAN:
                        return true;
                    default:
                        return false;
                }
            case self::TYPE_PUTONG:
                switch ($this->type_id)
                {
                    case self::TYPE_CHAOGUAN:
                        return true;
                    case self::TYPE_PUTONG:
                        return true;
                    default:
                        return false;
                }
            case self::TYPE_KEFU:
                switch ($this->type_id)
                {
                    case self::TYPE_CHAOGUAN:
                        return true;
                    case self::TYPE_PUTONG:
                        return true;
                    default:
                        return false;
                }
            case self::TYPE_CAIWU:
                switch ($this->type_id)
                {
                    case self::TYPE_CHAOGUAN:
                        return true;
                    case self::TYPE_PUTONG:
                        return true;
                    case self::TYPE_CAIWU:
                        return true;
                    default:
                        return false;
                }
            case self::TYPE_XINDAI:
                switch ($this->type_id)
                {
                    case self::TYPE_CHAOGUAN:
                        return true;
                    case self::TYPE_PUTONG:
                        return true;
                    default:
                        return false;
                }
            case self::TYPE_LUNTAN:
                switch ($this->type_id)
                {
                    case self::TYPE_CHAOGUAN:
                        return true;
                    case self::TYPE_PUTONG:
                        return true;
                    default:
                        return false;
                }
            default:
                return false;
        }

        return false;
    }

   //$data=array('field'=>'field1,field2,field3...','where'=>array('name !=' => $name, 'id <' => $id, 'date >' => $date))
   public function exec_sql($data=array())
   {
   		if(isset($data['filed']))
   			$this->db->select($data['filed']);
   		else
   			return false;
   		if(isset($data['where']))
   			$this->db->where($data['where']);
   		$query = $this->db->get(self::TABLE_NAME);
 		return $query->row_array();
   }
     function insert_batch($data =array())
     {
     	if(count($data) < 1)
     		return false;
     	$this->db->insert_batch(self::TABLE_NAME, $data);
     	return $this->db->affected_rows()>0?true:false;
     }
     /**
      * 返回值为受影响的行数
      *
      * */
    function update_batch($data=array(),$field="")
    {
    	if(count($data) < 1 || $field == "")
    		return false;
    	return $this->db->update_batch(self::TABLE_NAME, $data, $field);
    }
	function get_user_ids($where=array(),$where_in=array())
     {
     	$this->db->select("ding_userid");
     	if(! empty($where))
     		$this->db->where($where);
     	if(! empty($where_in))
     		$this->db->where_in($where_in['key'],explode(",",$where_in['val']));
     	$query = $this->db->get(self::TABLE_NAME);
     	$result = $query->result_array();
        return !empty($result) ? $result : array();
     }
	function get_all()
     {
     	$this->db->select("*");
     	$this->db->order_by("id ASC");
     	$query = $this->db->get(self::TABLE_NAME);
     	$result = $query->result_array();
        return !empty($result) ? $result : array();
     }


     public function all_mation($offset,$page_size)
     {
       $sql = "SELECT u.`name`, u.`mobile`, u.`avatar` , u.`position`, d.`name` dname ,i.sex , i.employee_date  FROM bg_user u LEFT JOIN bg_department d ON u.department LIKE CONCAT(\"%\",d.ding_dept_id,\"%\") LEFT JOIN bg_user_info i ON u.ding_userid = i.ding_userid GROUP BY u.`name` ORDER BY u.id ASC limit $offset,$page_size ";
       $arr = $this->db->query($sql);
       return !empty($arr) ? $arr->result_array() : array();

     }
   	public function count_user($where = '')
   	{
   		$sql="SELECT COUNT(ID) sum FROM ".$this->db->dbprefix(self::TABLE_NAME)." WHERE 1=1  $where";
   		$query = $this->db->query($sql);
     	$result = $query->result_array();
        return !empty($result) ? $result[0] : array();
   	}
   	//获取未和钉钉同步的用户
	public function get_sync_user_list($start=0, $limit=50)
	{
		$this->db->select("id,ding_userid");
		$this->db->order_by("id","ASC");
		$this->db->where('has_sync', 0);//未同步过
		$this->db->where('ding_userid !=', 0);//钉钉用户
        $query = $this->db->get(self::TABLE_NAME,$limit,$start);
        $result = $query->result_array();
        return !empty($result) ? $result : array();
    }
    public function update_status($ding_userid=array(),$status= -99)
    {
    	if( !is_array($ding_userid) || $status == -99)
    		return FALSE;
        $this->db->where_in('ding_userid', $ding_userid);
        $data=array('status'=>$status);
        $this->db->update(self::TABLE_NAME, $data);
        return $this->db->affected_rows()>0?true:false;
    }
    public function get_single($department = ''){
        if($department == ''){
            exit('error');
        }
        $this->db->select('*');
        $this->db->from(self::TABLE_NAME);
        $this->db->where("department like '%$department%' ");
        $num = $this->db->count_all_results();
        return $num;

    }
}
/* End of file user.php */
/* Location: /application/models/users/user.php */
