<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2017/11/1
 * Time: 10:09
 * author：huxiaobai
 * 干啥滴：知识库文章分享model
 */
class Article_share_model extends MY_Model
{
    const TABLE_NAME = 'article_share';

    // public $uid;//文章所属用户id
    public $ding_userid;//hsl 关联用户信息改用ding_userid
    public $deptid;//发布人所属的部门
    public $article_id;//文章id
    public $to_userid;//分享给谁
    public $to_deptid;//分享到的部门id
    public $share_validity;//分享到期时间


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

    //验证文章是否分享过以及是否过期
    public function verify_share($aid = '', $did = '',$validate = ''){
        if($aid == '' && $did == '' && $validate == ''){
            return -1;//避开0和false混淆 返回-1；
        }else{
            //不管是永久有效还是临时有效 都要先验证该文章是否是永久有效  如果是永久有效 两种操作都禁止进行!
            $tt = $this->db->where(" article_id = ".$aid." AND to_deptid = ".$did." AND share_validity = 2000000000 ")->from(self::TABLE_NAME)->count_all_results();
            if($tt > 0){
                return -2;
            }
            //验证是否是操作有效期 如果没有操作有效期那么禁止操作!
            $where = " article_id = ".$aid." AND to_deptid = ".$did." AND unix_timestamp(`share_validity`) > unix_timestamp(now()) ";
            $this->db->where($where);
            $this->db->from(self::TABLE_NAME);
            return $this->db->count_all_results(); //如果没有就会返回0
        }
    }

    //涉及到链表查询  单独一个方法来操作
    public function get_search_list1($wheres = array(), $start = 0, $limit = 10)
    {
        //$wheres不能为空！我们要根据to_deptid来查询相关记录！
        if(empty($wheres)){
            exit("缺少必要参数");
        }
        $this->db->select('articles.*,user.name,department.name as dname,article_share.share_validity,article_share.id as sid,different.tname');
        $this->db->from('article_share');
        $this->db->join('articles','article_share.article_id = articles.id','left');
        $this->db->join('user','articles.ding_userid = user.ding_userid','left');
        $this->db->join('different','articles.column = different.id');
        $this->db->join('department','article_share.deptid = department.ding_dept_id','left');
        $this->db->where($wheres['where']);
        $this->db->limit($limit,$start);
        $this->db->order_by('article_share.addtime desc');
        $arr = $this->db->get();
        $str = $this->db->last_query();
        return !empty($arr)?$arr->result_array():array();
    }

    /*
    *回收站用戶到的model 沒有重新建立  直接写在了这里 因为不存在回收站表
    *articles文章表：我们需要查询出来的是当前用户自己删除的个人知识 + 所在部门删除掉的部门知识 判断的提条件是：status = 0 并且 （uid = 当前登录用户的id  或者 department = 当前用户所在的部门id ）
    *article_share文章分享表：我们需要查询出来的是公司分享当中删除掉的共享文章  判断的条件是：status = 0 并且 （to_department = 当前用户所在的部门id）
    *涉及了链表查询  联合查询 比较复杂
    *因为涉及到分页  所以在 链表查询+联合查询的外围 又加上了“表子查询”；
    */
    public function get_reclaim_list($start = 0, $limit = 10000){

       $sql = "SELECT * from (
        (SELECT
            `nd_articles`.id,`nd_articles`.title,`nd_articles`.`keyword`,`nd_articles`.`describe`,`nd_articles`.`content`,`nd_articles`.`addtime`,`nd_articles`.`department`,
            `nd_user`.`name`,
            `nd_department`.`name` AS `dname`,
            `nd_different`.`tname`,
            `nd_articles`.`dpt` as `ly`,
            `nd_articles`.`id` as `yid`
        FROM
            nd_articles
            LEFT JOIN `nd_user` ON `nd_articles`.`ding_userid` = `nd_user`.`ding_userid`
            LEFT JOIN `nd_different` ON `nd_articles`.`column` = `nd_different`.`id`
            LEFT JOIN `nd_department` ON `nd_articles`.`department` = `nd_department`.`ding_dept_id`
        WHERE
            `nd_articles`.`status` = 0 and ((`nd_articles`.`ding_userid` = ".$this->user->ding_userid." and `nd_articles`.`dpt` = -1 and `nd_articles`.`department` = ".$_SESSION["default_dept"]."  ) or (`nd_articles`.`department` = ".$_SESSION["default_dept"]." and `nd_articles`.`dpt` = 1)) )
        UNION ALL
        (SELECT
            `nd_articles`.id,`nd_articles`.title,`nd_articles`.`keyword`,`nd_articles`.`describe`,`nd_articles`.`content`,`nd_articles`.`addtime`,`nd_articles`.`department`,
            `nd_user`.`name`,
            `nd_department`.`name` AS `dname`,
            `nd_different`.`tname`,
            `nd_article_share`.`dpt` as `ly`,
            `nd_article_share`.`id` as `yid`
        FROM
            `nd_article_share`
            LEFT JOIN `nd_articles` ON `nd_article_share`.`article_id` = `nd_articles`.`id`
            LEFT JOIN `nd_user` ON `nd_articles`.`ding_userid` = `nd_user`.`ding_userid`
            left JOIN `nd_different` ON `nd_articles`.`column` = `nd_different`.`id`
            LEFT JOIN `nd_department` ON `nd_article_share`.`deptid` = `nd_department`.`ding_dept_id`
        WHERE
            `nd_article_share`.`status` = 0 and `nd_article_share`.`to_deptid` = ".$_SESSION["default_dept"]." )
                )
        AS bb limit $start,$limit";
       $arr = $this->db->query($sql);
    //    print_r($this->db->last_query());die;
       return !empty($arr)?$arr->result_array($arr):array();
   }

   //此方法用来执行删除多条记录
   public function del_articles($article_id = ''){
       if($article_id == ''){
           exit('缺少必要参数!');
       }
       $this->db->delete(self::TABLE_NAME,array('article_id'=>$article_id));
   }






}
