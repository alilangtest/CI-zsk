<?php

class MY_Model extends CI_Model {

    /**
     * 记录|报告 错误的级别
     */
    const ERROR_LEVEL = "error";

    /**
     * Contains the id this object.
     * @var int
     */
    public $id;
    /**
     * Contains the status this object.
     * @var int
     */
    public $status;
    /**
     * Contains the date time this object was added.
     * @var int
     */
    public $addtime;
    /**
     * Contains the ip this object.
     * @var int
     */
    public $addip;
    /**
     * Contains the index number of the page to return data for.
     * @var int
     */
    public $_page_index;
    /**
     * Contains the number of data returned per page.
     * @var int
     */
    public $_page_count;
    /**
     * Indicates the field the results should be sorted by. Default is by id.
     * @var string
     */
    public $_sort_by;
    /**
     * Contains the direction to search for. Possible values are "ASC" or "DESC".
     * @var string
     */
    public $_sort_dir;
    /**
     * Contains the group by statement.
     * @var string
     */
    public $_group_by;
    /**
     * Contains the search results.
     * @var array
     */
    public $_search_results;
    /**
     * Contains the count of row for searching .
     * @var array
     */
    public $_search_num_rows;
    /**
     * Contains the insert fields.
     * @var array
     */
    public $_insert_fields;
    /**
     * Contains the update fields.
     * @var array
     */
    public $_update_fields;
    /**
     * original object
     * @var object
     */
    public $_original;
    /**
     * Contains the fields to select.  If none, all fields are selected.
     *
     * @var array
     */
    public $_selected_fields;
    /**
     * Contains the counter of searching.
     *
     * @var boolean
     */
    public $_is_selected_counter;
    /**
     * Contains the status for searching .
     * @var array
     */
    public $_search_status;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_search_results = array();
        $this->_insert_fields = array();
        $this->_update_fields = array();
        $this->_original = null;

    }

    /**
     * Retrieves the matching current object from the database.
     *
     * @param string $id
     * @return boolean
     */
    public function retrieve($id)
    {
    	return FALSE;
    }

    /**
     * Prepares for the insert of the current object.
     *
     * @return boolean
     */
    protected function prepare_insert_fields()
    {
        if(!$this->input->is_cli_request())
        {
            if(empty($this->addip))
                $this->addip = $this->input->ip_address();
        }

        if(empty($this->addtime))
            $this->addtime = time();

        $this->_insert_fields = array();

        foreach(get_object_vars($this) as $key => $value)
        {
            if (property_exists($this, $key) && !is_object($this->$key) && !is_array($this->$key)
                && substr($key, 0, 1) != '_' && $key != 'id')
            {
                if (is_numeric($value) && strpos($value, ".") !== false)
                {
                    $this->_insert_fields[$key] = (float)$value;
                }
                else
                    $this->_insert_fields[$key] = $value;
            }
        }

        if(empty($this->_insert_fields))
            return false;
        else
            return true;
    }

    /**
     * Override this method if the class needs to process any changes.
     */
    protected function prepare_insert(&$table_name)
    {
       return false;
    }

    /**
     * Insert the matching current object to the database.
     *
     * @return boolean
     */
    public function insert()
    {
        $table_name = "";

        if(!$this->prepare_insert($table_name))
        {
            log_message(self::ERROR_LEVEL, "Missing input parameters--insert--" . get_class($this));
            return false;
        }

        if (empty($this))
        {
            log_message(self::ERROR_LEVEL, "Current obj cannot be null--insert--" . get_class($this));
            return false;
        }

        if(!$this->prepare_insert_fields())
        {
            log_message(self::ERROR_LEVEL, "Make Current obj _insert_fields failed--insert--" . get_class($this));
            return false;
        }

        if(!$this->make_table_name($table_name))
        {
            log_message(self::ERROR_LEVEL, "Table name cannot be null: {$table_name}--insert--" . get_class($this));
            return false;
        }

        $fields = ",`";
        $values = ",";

        foreach($this->_insert_fields as $k => $v)
        {
            $fields .= $k . '`,`';
            $values .= $this->db->escape($v) . ',';
        }
        $fields = trim(trim($fields, "`"), ",");

        $sql = "INSERT INTO {$table_name} (" . $fields . ") VALUES (" . trim($values, ",") . ")";

        $this->db->query($sql);

        if($this->db->affected_rows() > 0)
        {
            $this->id = $this->db->insert_id();

            if(!$this->post_insert())
            {
                log_message(self::ERROR_LEVEL, "The post_insert failed--insert--" . get_class($this));
                return false;
            }

            return true;
        }
        else
        {
            log_message(self::ERROR_LEVEL, "The insert failed--insert--" . get_class($this));
            return false;
        }
    }

    /**
     * Override this method if the class needs to process any post insert actions.
     */
    protected function post_insert()
    {
        return true;
    }

    /**
     * Based on the original record with the current record and record any changes to the _update_fields field.
     */
    protected function prepare_update_fields()
    {
        if($this->isEmpty())
        {
            return false;
        }

        $className = get_class($this);
        $this->_original = new $className();

        if(!$this->_original->retrieve($this->id))
        {
            return false;
        }

        $this->_update_fields = array();

        foreach(get_object_vars($this->_original) as $key => $value)
        {
            if ((property_exists($this, $key)) && (!is_object($this->$key)) && (!is_array($this->$key)) &&
                (substr($key, 0, 1) != '_') && ($this->$key != $value) && ($key != "updatetime"))
            {
                $this->_update_fields[$key] = $this->$key;
            }
        }

        return true;
    }

    /**
     * Prepares the current object for update.  This method is required to update the
     * object.
     * @param string $table_name
     * @return true if successful, false if not.
     */
    protected function prepare_update(&$table_name)
    {
        if ($this->isEmpty())
        {
            log_message(self::ERROR_LEVEL, "Cannot update an empty object--prepare_update--" . get_class($this));
            return false;
        }

        return true;
    }

    /**
     * Updates the correponding database tables based on the current object.
     *
     * @return boolean
     */
    public function update()
    {
        if ($this->isEmpty())
        {
            log_message(self::ERROR_LEVEL, "Cannot update an empty object--update--" . get_class($this));
            return false;
        }

        $table_name = "";

        if(!$this->prepare_update($table_name))
        {
            log_message(self::ERROR_LEVEL, "Missing input parameters--update--" . get_class($this));
            return false;
        }

        if (empty($this))
        {
            log_message(self::ERROR_LEVEL, "Current obj cannot be null--update--" . get_class($this));
            return false;
        }

        if(!$this->prepare_update_fields())
        {
            log_message(self::ERROR_LEVEL, "Make Current obj _update_fields failed--update--" . get_class($this));
            return false;
        }

        if(!$this->make_table_name($table_name))
        {
            log_message(self::ERROR_LEVEL, "Table name cannot be null: {$table_name}--update--" . get_class($this));
            return false;
        }

        if(empty($this->_update_fields))
            return true;

        if(isset($this->updatetime))
            $this->_update_fields["updatetime"] = time();

        $fields = ",";

        foreach($this->_update_fields as $k => $v)
        {
            $fields .= '`'.$k . '`=' . $this->db->escape($v) . ',';
        }

        $sql = "UPDATE {$table_name} SET " . trim($fields, ",") . " WHERE id = " . $this->id;

        $this->db->query($sql);

        if($this->db->affected_rows() > 0)
        {
            if(!$this->post_update())
            {
                log_message(self::ERROR_LEVEL, "The post_update failed--update--" . get_class($this));
                return false;
            }

            return true;
        }
        else
        {
            log_message(self::ERROR_LEVEL, "The update failed--update--" . get_class($this));
            return false;
        }
    }

    /**
     * Override this method if the class needs to process any post update actions.
     */
    protected function post_update()
    {
        return true;
    }

    /**
     * Prepares the current object for delete.  This method is required to delete the object.
     * @param string $table_name
     * @return true if successful, false if not.
     */
    protected function prepare_delete(&$table_name)
    {
        if ($this->isEmpty())
        {
            log_message(self::ERROR_LEVEL, "Empty object--prepare_delete--" . get_class($this));
            return false;
        }

        return true;
    }

    /**
     * Deletes the current object from the database.
     *
     * @return boolean if successful, false if not.
     */
    public function delete()
    {
        if ($this->isEmpty())
        {
            log_message(self::ERROR_LEVEL, "Cannot delete an object--delete--" . get_class($this));
            return false;
        }

        $table_name = "";

        if(!$this->prepare_delete($table_name))
        {
            log_message(self::ERROR_LEVEL, "Missing input parameters--delete--" . get_class($this));
            return false;
        }

        if (empty($this))
        {
            log_message(self::ERROR_LEVEL, "Current obj cannot be null--delete--" . get_class($this));
            return false;
        }

        if(!$this->make_table_name($table_name))
        {
            log_message(self::ERROR_LEVEL, "Table name cannot be null: {$table_name}--delete--" . get_class($this));
            return false;
        }

        $sql = "DELETE FROM {$table_name} WHERE id = ?";
        $result = $this->db->query($sql, array($this->id));

        if ($this->db->affected_rows() > 0)
        {
            if(!$this->post_detele())
            {
                log_message(self::ERROR_LEVEL, "The post_detele failed--delete--" . get_class($this));
                return false;
            }

            return true;
        }
        else
        {
            log_message(self::ERROR_LEVEL, "Object not found--delete--" . get_class($this));
            return false;
        }
    }

    /**
     * Override this method if the class needs to process any post delete actions.
     */
    protected function post_detele()
    {
        return true;
    }

    /**
     * Loads the input object into the current object.  The input object must match the current object type.
     *
     * @param Mixed $obj，object或array
     * @return boolean true if success,false if faild.
     */
    public function result_load($obj)
    {
        if (empty($obj))
            return false;

        if (is_array($obj))
        {
            foreach($obj as $key => $value)
            {
                if(is_array($value))
                {
                    $this->result_load($value);
                }
                elseif(is_object($value))
                {
                    $this->result_load($value);
                }
                else
                {
                    if (property_exists($this, $key) && !is_object($this->$key))
                    {
                        if (is_numeric($value) && strpos($value, ".") !== false)
                        {
                            $this->$key = (float)$value;
                        }
                        else
                            $this->$key = $value;
                    }
                }
            }
        }
        else
        {
            foreach(get_object_vars($obj) as $key => $value)
            {
                if (property_exists($this, $key) && !is_object($this->$key))
                {
                    if (is_numeric($value) && strpos($value, ".") !== false)
                    {
                        $this->$key = (float)$value;
                    }
                    else
                        $this->$key = $value;
                }
            }
        }

        return true;
    }

    /**
     * Make table name with dbprefix.
     * @param string $table_name
     *
     * @return string table_name | null.
     */
    protected function make_table_name(&$table_name)
    {
        if (empty($table_name))
            return false;

        $table_name = $this->db->dbprefix . $table_name;

        return true;
    }

    /**
     * Checks if the current object is empty.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->id);
    }

    /**
     * Checks if the current search object has paging enabled.
     *
     * @return boolean True if paging is enabled, false if not.
     */
    public function is_pageing()
    {
        return ($this->_page_index != null) && is_numeric($this->_page_index);
    }
    protected function prepare_search(&$table_name)
    {
        return false;
    }
    /**
     * 此参数兼容于CI SQL构造语法,具体请查看CI手册。
     *
     * */
     function get_search_nums($search=array())
     {
     	$table_name = "";
      	if(!$this->prepare_search($table_name))
        {
            log_message(self::ERROR_LEVEL, "Missing input parameters--search--" . get_class($this));
            return false;
        }
     	if( !empty($search))
     	{
     	    if(isset($search['select']))
     	        $this->db->select($search['select']);
     	    if(isset($search['where']))
     			$this->db->where($search['where']);
     		if(isset($search['like']))
     			$this->db->like($search['like']);
     		if(isset($search['where_in']) && is_array($search['where_in']))
     			foreach($search['where_in'] as $k=>$v)
     				$this->db->where_in($k,$v);
			if(isset($search['joins']) && is_array($search['joins']))
			    foreach($search['joins'] as $v)
			        $this->db->join($v['table'],$v['condition'],$v['type']);
     	}
     	$this->db->from($table_name);
     	return $this->db->count_all_results();
     }
     /*
      * 此参数兼容于CI SQL构造语法,具体请查看CI手册。
      *
      *
      * **/
 	public function get_search_list($search=array(), $start=0, $limit=10)
   {
    //  print_r($search);die;
   		$table_name = "";
      	if(!$this->prepare_search($table_name))
        {
            log_message(self::ERROR_LEVEL, "Missing input parameters--search--" . get_class($this));
            return false;
        }
   		if( !empty($search))
     	{
     		if(isset($search['select']))
     	        $this->db->select($search['select']);
     	    if(isset($search['where']))
     			$this->db->where($search['where']);
     		if(isset($search['like']))
     			$this->db->like($search['like']);
     		if(isset($search['where_in']) && is_array($search['where_in']))
     			foreach($search['where_in'] as $k=>$v)
     				$this->db->where_in($k,$v);
			if(isset($search['joins']) && is_array($search['joins']))
			    foreach($search['joins'] as $v)
			        $this->db->join($v['table'],$v['condition'],$v['type']);
     		if(isset($search['order_by']))
     			$this->db->order_by($search['order_by']);
     		else
     			$this->db->order_by("id","desc");
     	}
        $query = $this->db->get($table_name,$limit,$start);
        $result = $query->result_array();
        return !empty($result) ? $result : array();
   }

}





/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
