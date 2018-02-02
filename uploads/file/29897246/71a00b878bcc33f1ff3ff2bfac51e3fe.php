<?php
class Blog extends CI_Controller
{

  public $id;
  public $username;
  public $password;

//  public function __construct()
//  {
//    parent::__construct();
//  }

  //重映射方法
  // public function _remap($method,$param = array())
  // {
  //   if($method == 'index'){
  //     $method = 'comment';
  //     return call_user_func_array(array($this, $method), $param);
  //   }
  //
  // }


  public function config(){

    //$c = config_item('csrf_token_name');//读取单个的配置文件
    //html_escape($var);//去掉大于号 小于号 等特俗符号  可以防止xss跨站脚本攻击
  }

  /*
  *接收参数
  */
  public function index($name = null,$id = null)
  {
    echo "welcome friends";
    echo "===========";
    echo $name.'------------'.$id;
  }

  /*
  *扩展辅助函数
  */
  public function fzkz()
  {
    //首先你要创建一个文件 application/helpers/MY_array_helper.php ， 然后直接在里面写自己的函数即可！
    // $this->load->helper('array');
    // mm();die;

    //自己创建一个辅助函数类  只需要在application/helper/number_helper.php文件  然后在里面写函数即可！
    // $this->load->helper('number');
    // wahaha();
  }

  public function wahaha()
  {
    echo "jwocao!";die;
  }

  /*
  *创建新的类库
  */
  public function leiku()
  {
    //$this->load->model('user');
    $ar = $this->user->users();
    print_r($ar);die;
    // $arr = ['username'=>'胡绍良','password'=>'123456'];
    // $this->load->library('myfunc',$arr);//初始化类库的时候我们可以传递参数到该类库的构造函数当中去
    // $this->myfunc->aa();//调用类库里面的方法
  }

  /*
  *演示视图操作 以及动态设置值到视图
  */
  public function comment($name = null,$age = null)
  {
    $this->output->cache(60);
    $data  =  array(
      'name'=>'胡绍良',
      'age' => 25,
      'address'=>'山东济南',
      'users'=>array('hushaoliang','lijinjin','zhangfan'),
    );
    $this->load->view('home/myform');
    // $this->load->view('header');//加载头部视图
    // $this->load->view('content');//加载内容部分视图
    // $this->load->view('footer');//加载底部视图
  }

  //测试模型的使用 实例化模型 并且读取模型当中的某个方法
  public function mm()
  {
    $this->load->model('user');//加载模型
    $arr = $this->user->users();//调取模型里面的方法
    var_dump($arr);die;
  }

  //分页掩饰  只是代码  没有效果哦   分页具体可以参考之前做过的案例
  public function fy()
  {
    //装载类文件
    $this->load->library('pagination');
    //每一页显示的数据条数的变量
    $page_size=4;
    
    $this->load->helper('url');//分页一定要用它！！！！！！
    $config['base_url']=site_url("admin/Contacts/index/99/756b1vb2682d/page/");///url地址
    $config['uri_segment']=7;//分页的偏移量查询在那一段上面  这个很重要哦
    $config['num_links'] = 2;
    
    $config['full_tag_open'] = '<div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-14">';
    $config['full_tag_close'] = '</div>';
    $config['first_tag_open'] = '<span class="my">';
    $config['first_tag_close'] = '</span>';
    $config['cur_tag_open'] = '<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>';
    $config['cur_tag_close'] = '</em></span>';
    $config['last_tag_open'] = '<span class="my">';
    $config['last_tag_close'] = '</span>';
    
    //每一页显示的数据条数
    $config['per_page']=$page_size;
    $config['next_link']= '下一页';
    $config['prev_link']= '上一页';
    $config['last_link'] = '末页';
    $config['first_link'] = '首页';
    
    $config['total_rows']=$this->db->count_all('user');//总的记录数
    $this->pagination->initialize($config);
    $data['links'] = $this->pagination->create_links(); 
    $offset=intval($this->uri->segment(7));//用intval使空格转0，显示出来0 
    
    $data['user_list3'] = $this->user->all_mation($offset,$page_size);//查询的时候一定要放这两个参数进去  类似TP当中的哦
  }


  /*
  *测试结果对象转换成数组
  *使用到的函数是get_object_vars()  这个函数的意思就是把对象里面的属性作为键 值为值  返回一条一维数组形式的结果；
  */
  public function objarray()
  {
    $arr = $this->db->select('*')->where('id>',1)->get('users');
    if($arr->num_rows() > 0){
      $ar = $arr->row();
      $s = get_object_vars($ar);
      //$s 為“：Array ( [id] => 5 [username] => wangming [password] => 123456 [address] => 山东济南历城区 )
      foreach($s as $k=>$v){
        if(!property_exists($this,$k) && !is_object($this->$k)){
          print_r($k);die;
        }
      }
    }
  }

  //设置辅助函数
  public function fz()
  {
        //url辅助函数
        //$this->load->helper('url');
        //生成url
        //$url = site_url('blog/index/2');//ci.cn/index.php/blog/index/2.html  推荐在任何时候都使用这种方法来生成你的 URL ，这样在你的 URL 变动时你的代码将具有可移植性。
        //也可以是数组格式的哦：
        //$url = site_url(['blog','index',2]);//ci.cn/index.php/blog/index/2.html

        //生成url
        // $url = base_url('home/blog/index/122');//ci.cn/home/blog/index/122
        //也可以是数组格式的哦：
        // $url = base_url(['home','blog','index',122]);//ci.cn/home/blog/index/122
        // $url = base_url('image/icon/123.jpg');//ci.cn/image/icon/123.jpg

        //获取当前访问的url完整地址:
        //$url = current_url(); //  ci.cn/index.php/home/blog/fz.html

        //获取当前路径的分段
        //$url = uri_string();//home/blog/fz

        //在配置文件中配置的 index_page 参数
        //$url = index_page();

        //生成标准的url地址：  就像一个表单按钮一样的那种
        //echo anchor('news/local/123', 'My News', 'title="News title"');
        //echo anchor(prep_url(site_url('home/blog/mm')), 'My News', 'title="News title"');//必须生成http://形式的url才行！
        // Prints: <a href="http://example.com/index.php/news/local/123" title="News title">My News</a>

        //生成http://www.baidu.com这丫的域名；
        //$url = prep_url('example.com');

        //地址的跳转  此处存在疑问 为啥不能直接写分段就实现跳转 还必须得是http://  原因是我们必须设置config.php里面的$config['base_url'] = 'http://ci.cn';必须是http://ci.cn 而不是ci.cn
        //redirect(prep_url(site_url('home/blog/mm')));

        //因为我们在config.php文件当中设置了$config['base_url'] = 'http://ci.cn'; http://ci.cn  所以我们可以直接写分段 即可跳转到相关链接地址！
        //redirect('/welcome/users');

        //======================================================
        //cookie辅助函数
        //$this->load->helper('cookie');
        //设置cookie
        // set_cookie('username','胡绍良',60);
        // set_cookie('password','123456',60);
        //访问cookie
        // $username = get_cookie('username');
        //删除cookie
        //delete_cookie('password');

        //======================================================
        //数组辅助函数
        //$this->load->helper('array');

        //element()  第一个参数是要获取到值的索引  第二个参数是数组本身 第三个参数是默认值
        // $arr= [
        //   'name'=>'胡绍良',
        //   'age'=>19,
        //   'sex'=>1,
        //   'address'=>'山东济南'
        // ];
        // $name = element('name',$arr,'hushaoliang');
        // print_r($name);die;

        //elements()可以获取到多个数组当中的元素  也是根据索引来获取
        //   $array = array(
        //     'color' => 'red',
        //     'shape' => 'round',
        //     'radius' => '10',
        //     'diameter' => '20'
        // );
        // $my_shape = elements(array('color', 'shape', 'height'), $array);
        // print_r($my_shape);die;
        //注意 我们可以通过elements()来接收post过来的数据 这样可以防止客户发送额外的数据插入到数据库当中 其实相当于TP当中执行插入到数据库当中的哪些数据elements(array('id', 'title', 'content'), $_POST);  从上例中可以看出，只有 id、title、content 三个字段被更新


        //获取数组当中随机的以一个元素值：
        // $arr= [
        // 'name'=>'胡绍良',
        // 'age'=>19,
        // 'sex'=>1,
        // 'address'=>'山东济南'
        // ];
        // echo random_element($arr);

        //======================================================

        //表单辅助函数 表单函数去参考home/comment.php视图里面的写法
        $this->load->helper('form');
        $this->load->view('home/comment');

  }


  /*
  *主要是数据库CURD
  */
  public function read()
  {
    //演示控制器当中直接读取数据库里面的内容   并且获取带有表前缀的表名称
    // $tablename = $this->db->dbprefix('users');//获取带有表前缀的表名称
    // $arr = $this->db->query("select * from $tablename");

    //演示控制器当中插入数据到数据库 并且自动给要插入的值加上单引号  并且还有自动获取带有表前缀的表名称；
    // $tablename = $this->db->dbprefix('users');
    // $username = $this->db->escape("王华");//我们在插入数据库的时候的值是需要加上单引号的  通过$this->db->escape()就可以自动加上！
    // $address = $this->db->escape("山东聊城东昌府区");//我们在插入数据库的时候的值是需要加上单引号的  通过$this->db->escape()就可以自动加上！
    // $this->db->query("INSERT INTO $tablename (id,username,password,address) values (7,$username,123456,$address)");


    //查询绑定
    // $tablename = $this->db->dbprefix('users');
    // $sql = "select * from $tablename where username = ? and id > ?";
    // $arr = $this->db->query($sql,array('胡绍良',0));
    // print_r($arr);die;

    //查询绑定
    // $sql = "select * from $tablename where username = ? and id in ?";
    // $arr = $this->db->query($sql,array('胡绍良',array(1,2,3,4,5,6)));//第二个参数除了是一个一维数组 还可以是二维数组
    // print_r($arr);

    //获取最近一次发生的错误
    // if ( ! $this->db->simple_query('SELECT `usernames` FROM `ci_users`'))
    // {
    //     $error = $this->db->error(); //获取到最后一次sql执行的错误信息 比如：Array ( [code] => 1054 [message] => Unknown column 'usernames' in 'field list' )
    // }
    // print_r($error);die;

    //生成查询结果  result()方法 返回对象数组  必须以对象的形式调用  结合foreach使用；
    // $sql = "select * from $tablename where id = ? and username = ?";
    // $arr = $this->db->query($sql,array(1,'胡绍良'));
    // $ar = $arr->result();
    // foreach($ar as $v){
    //   echo $v->username;
    // }

    //生成查询结果  result_array()方法  返回数组结果  必须已数组的形式调用
    // $sql = "select * from $tablename where id = ? and username = ?";
    // $arr = $this->db->query($sql,array(1,'胡绍良'));
    // //$arr->result_array()  其实是变成了一个二维数组
    // foreach($arr->result_array() as $v){
    //   echo $v['username'];
    // }

    //结果行  row()  默认返回结果集当中的第一行  并且是对象形式的
    // $sql = "select * from $tablename where id = ? and username = ?";
    // $arr = $this->db->query($sql,array('1','胡绍良'));
    // $ar = $arr->row();//默认是一个一维数组对象
    // echo $ar->username;

     //结果行  row(3)  默认返回结果集当中的指定的行数的记录  并且是对象形式的
    // $sql = "select * from $tablename where id > ?";
    // $arr = $this->db->query($sql,array('2'));
    // $ar = $arr->row(2);//默认是一个一维数组对象
    // print_r($ar->username);die;



    //结果行  row_array()  默认返回结果集当中的第一行  并且是数组形式
    // $sql = "select * from $tablename where id = ? and username = ?";
    // $arr = $this->db->query($sql,array('1','胡绍良'));
    // $ar = $arr->row_array();//默认是一个一维数组
    // echo $ar['username'];

    //结果行  row_array()  默认返回结果集当中的指定的行数记录  并且是数组形式
    // $sql = "select * from $tablename where id > ?";
    // $arr = $this->db->query($sql,array('3'));
    // $ar = $arr->row_array(2);//默认是一个一维数组
    // echo $ar['username'];

    // $sql = "select * from $tablename where id > ?";
    // $arr = $this->db->query($sql,array('3'));

    //$ar = $arr->first_row();//获取记录里面的第一条记录  返回对象格式
    //$ar = $arr->first_row('array');//获取结果里面的第一条记录  返回数组格式

    //$ar = $arr->last_row();//获取记录里面的最后一条记录  返回对象格式
    //$ar = $arr->last_row('array');//获取记录里面的最后一条记录  返回数组格式

    //unbuffered_row()方法会查询出当前一行 然后再将指针移动到下一条记录！
    //$ar = $arr->unbuffered_row();//默认就是对象的格式查询出来  第一条记录
    //$ar = $arr->unbuffered_row('array');//和row()方法一样的效果  但是不会把所有数据加载到内存当中预加载！


    //我们可以使用unbuffered_row()方法  阻止了将所有数据存储到内存当中  另外我们执行一边unbuffered_row()那么查询出当前的 就会将指针指向下一条  所以我们可以使用while()循环 来遍历出所有的结果集
    // while($row = $arr->unbuffered_row('array')){
    //   echo $row['username'];
    // }

    //返回对象结果的行数
    //$num = $arr->num_rows();

    //获取结果集对象当中的字段数
    //$num = $arr->num_fields();

    //下边是一个整体哈
    // $data = $arr->result();
    // $arr->free_result();//当我们查询出来的时候会把所有的记录存储到了内存当中很占资源 所以当我们生成查询结果之后我们最好释放掉内存当中的资源 这样比较节省内存消耗
    // $this->load->view('home/comment',array('data'=>$data));//另外注意的是ci当中这个地方和yii以及laravel或者TP当中的写法是一样的！
    // print_r($num);die;

    //data_seek()方法 用来设置下一个结果行的内部指针
    // $arr->data_seek(3);//表示指针往下移动3个！
    // $arr = $arr->unbuffered_row();//默认查出移动后的指针也就是第四条哦



   //查询辅助函数
  //  $sql = "insert into $tablename (id,username,password,address) values(?,?,?,?)";
  //  $arr = $this->db->query($sql,array(10,'张力','123456','山西西安'));
  //  $id = $this->db->insert_id();//获取到插入到数据库当中的这条记录的id是多少！
  //  $num = $this->db->affected_rows();//插入 更新  删除写类型的操作 获取到受影响的行数；
  //  print_r($this->db->last_query());die;//该方法返回上一次执行的查询语句（是查询语句，不是结果）

  // $num = $this->db->count_all('ci_users');//获取数据表当中总的记录数；
  // print_r($num);die;

  //print_r($this->db->platform());//获取数据库驱动器

  //=======================================================================================
  //更加简单的查询操作

  //插入操作
  // $data = array('username'=>'哇哈哈','password'=>123456,'address'=>'山东济南天桥区');
  // $ar = $this->db->insert_string('ci_users',$data);//第一个参数是表名称 第二个参数是一个关联数组 表示即将要插入到数据库当中的数据  返回的是string生成一条sql语句！
  // //上边的操纵只是生成一条sql语句  执行还得是$this->db->query();
  // $arr = $this->db->query($ar);

  //更新操作
  // $data = array('username'=>'lijinjin','address'=>'北京中南海');
  // $where = 'id = 2 and password = 123456';
  // $str = $this->db->update_string('ci_users',$data,$where);//第一参数是表名称 第二个参数是要修改的数据 第三个参数是条件
  // $this->db->query($str);

  //=======================================================================================
  //查询构造器

  //get()方法表示获取到数据库当中所有的记录

  // $users = $this->db->get('users',1,2);//第二个参数表示查询的数量  第三个参数表示从哪条记录开始
  // $arr = $users->result();


  //get_compiled_select()方法 第一个参数表示表名称 第二个参数表示是否重置查询 只是生成sql语句  不执行！
  //$sql = $this->db->limit(1,2)->get_compiled_select('users',false);
  //如果我们第二个参数写成false表示不重置查询 那么下边我们再继续使用get_compiled_select的时候  就不用指定表名称  并且下边的sql语句会附带上上边的sql语句  就比如下边的sql语句会是：SELECT `username`, `password`, `address` FROM `ci_users` LIMIT 2, 1  之所以这样是因为没有重置查询 会记住之前的查询！
  //如果我们不想这样使用 每次都是生成新的sql语句 那么第二个参数直接为true即可！
  //$sqls = $this->db->select('username,password,address')->get_compiled_select();
  // print_r($sqls);die;

  //limit的使用 和 select 的使用  和 where条件的使用
  //$arr = $this->db->select('username,password,address')->limit(3,1)->where('id > 1')->get('users');

  //get_where()方法的使用
  // $ar = $this->db->get_where('users',array('id'=>3));

  //$this->db->select();
  // $this->db->select('username,password,address');
  // $arr = $this->db->get('users');
  // print_r($arr->result_array());die;

  //$this->db->select_max()   获取到某个字段的最大值
  // $this->db->select_max('id');
  // $ar = $this->db->get('users');
  // print_r($ar->result_array());die;

  //$this->db->min() 获取到某个字段的最小值
  // $this->db->select_min('id');
  // $ar = $this->db->get('users');
  // print_r($ar->result_array());die;

  //$this->db->avg() 获取某个字段的平均数
  // $this->db->select_avg('id');
  // $ar = $this->db->get('users');
  // print_r($ar->result_array());die;


  //$this->db->select_sum() 表示获取到某个字段的所有的值的总和
  // $this->db->select_sum('id');
  // $ar = $this->db->get('users');
  // print_r($ar->result_array());die;

  //$this->db->from() 用于编写查询语句中的 FROM 子句:
  // $this->db->select('username,password,address');
  // $this->db->from('users');
  // $this->db->where('id = 3');
  // $arr = $this->db->get();
  // print_r($arr->result_array());die;

  //$this->db->join()
  // $this->db->select('users.id,users.username,student.uid,student.status');
  // $this->db->from('users');
  // $this->db->join('student','student.uid = users.id');
  // $this->db->where('users.id = 3 and users.username = "李锦锦"');
  // $arr = $this->db->get();
  // print_r($arr->result_array());die;


  //$this->db->where()的四种查询方法

  //第一种：简单的 key/value 方式:
  // $arr = $this->db->where('username','胡绍良')->get('users');
  // print_r($arr->result_array());die;

  //第二种：自定义 key/value 方式:   为了控制比较，你可以在第一个参数中包含一个比较运算符：
  // $arr = $this->db->where('id >=',3)->get('users');
  // print_r($arr->result_array());die;

  //第三种：关联数组方式:
  // $where = array('id'=>1,'username'=>'胡绍良');
  // $arr = $this->db->where($where)->get('users');
  // print_r($arr->result_array());die;

  //第三种方法也可以是使用这样的写法：
  // $where = array('id >=' => 1,'password !=' => 0);
  // $arr =  $this->db->where($where)->get('users');
  // print_r($arr->result_array());die;

  //第四种：自定义字符串方法
  // $where = "id = 1 and username = '胡绍良'";
  // $ar = $this->db->where($where)->get('users');
  // print_r($ar->result_array());die;


  //$this->db->or_where()方法
  // $this->db->where('id = 1 and username = "胡绍良"');
  // $this->db->or_where('id = 2 and username = "lijinjin"');
  // $this->db->from('users');
  // $arr = $this->db->get();
  // print_r($arr->result_array());die;

  //$this->db->where_in()方法
  // $wherein = array(1,2,3,4,5);
  // $arr = $this->db->where_in('id',$wherein)->get('users');
  // print_r($arr->result_array());die;

  //$this->db->or_where_in()方法
  // $this->db->where('username','胡绍良');
  // $this->db->or_where_in('id',array(2,3,4));
  // $this->db->from('users');
  // $arr = $this->db->get();
  // print_r($arr->result_array());


  //下边两个就不用举例子了！
  //$this->db->where_not_in()
  //$this->db->or_where_not_in()

  //$this->db->like()方法
  //第一种：简单 key/value 方式:
  // $this->db->where('id >',1);
  // $this->db->like('username','李','both');
  // $this->db->like('password','li','both');
  // $this->db->from('users');
  // $arr = $this->db->get();
  // print_r($arr->result_array());die;

  //第二种：关联数组方式:
  // $like = array('username'=>'胡','password'=>'123');
  // $this->db->where('id',1);
  // $this->db->like($like);
  // $this->db->from('users');
  // $arr = $this->db->get();
  // print_r($arr->result_array());die;

  //$this->db->or_like()方法
  // $this->db->where('id >',1);
  // $this->db->like('username','李','both');//第三个参数还可以穿after  before both
  // $this->db->or_like('username','li','both');
  // $this->db->from('users');
  // $arr = $this->db->get();
  // print_r($arr->result_array());die;

  //下边两个就不用举例子了
  //$this->db->not_like()
  //$this->db->or_not_like()


  //group_by()方法
  // $arr = $this->db->where('id>',2)->from('users')->group_by('username')->get();
  //$arr = $this->db->where('id>',2)->from('users')->group_by(array('username','id'))->get();//group_by()括号当中还可以放数组
  //print_r($arr->result_array());die;

  //having()方法   (having方法必须要结合group_by()方法来使用  并且必须要放在group_by()方法的后边)
  // $arr = $this->db->where('id >',2)->from('users')->group_by('username')->having('username = "wangming"')->get();
  // print_r($arr->result());die;


  //order_by()
  // $ar = $this->db->where('id >',3)->from('users')->order_by('id','desc')->get();//正常的排序
  // $ar = $this->db->where('id >',3)->from('users')->order_by('id','RANDOM')->get();//表示按照id随机排序
  // print_r($ar->result_array());die;


  //$this->db->limit();这个不多讲了！

  //$this->db->count_all_results();获取特定条件下查询出来的结果的数据
  // $this->db->where('id >',3);
  // $this->db->or_where('username','胡绍良');
  // $this->db->from('users');
  // $num = $this->db->count_all_results();
  // print_r($num);die;

  //$this->db->count_all();
  //print_r($this->db->count_all('users'));


  //查询条件组：（有点小复杂！）
  // $arr = $this->db->select('*')->from('users')
  // ->group_start()
  //   ->where('id',1)
  //   ->or_group_start()
  //     ->where('id',2)
  //     ->where('username','lijinjin')
  //   ->group_end()
  // ->group_end()
  // ->where('password',123456)
  // ->get();
  // // print_r($arr->result_array());
  // print_r($this->db->last_query());die;

  //==========================================================
  //插入操作

  // $data = array(
  //   'username'=>'绵阳',
  //   'password'=>'123456',
  //   'address'=>'四川绵阳'
  // );
  // $id = $this->db->insert('users',$data);
  // print_r($this->db->insert_id());die;
  // print_r($id);die;


  //get_compiled_insert()只是生成一条sql语句但是并不执行；
  // $data = array(
  //   'username'=>'绵阳',
  //   'password'=>'123456',
  //   'address'=>'四川绵阳'
  // );
  // $sql = $this->db->set($data)->get_compiled_insert('mytable');//第二个参数如果是false表示不重置  那么我们再在下边写相同的语法的时候会记住这里的这些药插入的数据；
  // print_r($sql);die;

  //批量插入操作
  // $data = [
  //   ['username'=>'小明','password'=>'123456','address'=>'shandongyanggu'],
  //   ['username'=>'小先','password'=>'123456','address'=>'北京上海'],
  // ];
  // $arr = $this->db->insert_batch('users',$data);
  // print_r($arr);die;

  //通过$this->db->set()来插入数据
  // $this->db->set('username','韩小花');
  // $this->db->set('password','123456');
  // $this->db->set('address','韩国');
  // $id = $this->db->insert('users');
  // print_r($id);die;


  //或者传递一个数组进去
  // $data = ['username'=>'攀枝花','password'=>'wahahah','address'=>'四川攀枝花'];
  // $this->db->set($data);
  // $this->db->insert('users');


  //=============================================
  //更新数据操作
  //replace()方法的使用 必须要有主键或者唯一索引 比如这里的id是我们的主键  然后先执行delete 然后再insert 也就是说先delete掉id = 16 的记录 再插入 id = 16的我们新添加的这条记录
  // $data = ['id'=>16,'username'=>'王海洋','password'=>'654321','address'=>'海南岛'];
  // $id = $this->db->replace('users',$data);
  // print_r($id);die;

  //$this->db->set()方法
  // $this->db->set('username','离得两');
  // $this->db->where('id = 2');
  // $ar = $this->db->update('users');
  // print_r($ar);die;

  //或者传递一个数组进去
  // $data = ['username'=>'攀枝花','password'=>'wahahah','address'=>'四川攀枝花'];
  // $this->db->set($data);
  // $this->db->where('id',18);
  // $this->db->update('users');


  //$this->db->update()方法
  // $data = [
  //   'username'=>'java',
  //   'password'=>'wahaha123',
  //   'address'=>'西川重庆'
  // ];
  // $this->db->where('id =',18)->update('users',$data);
  //或者写成下边的这种形式：
  // $this->db->update('users',$data,'id = 18');


  //批量更新数据
  // $data = [
  //   ['id'=>1,'username'=>'hushaoliang1','address'=>'山东济南历城区'],
  //   ['id'=>2,'username'=>'hushaoliang2','address'=>'山东聊城东昌府区'],
  // ];
  // $ids = $this->db->update_batch('users',$data,'id');//第一个参数是表名称 第二个参数是要更新的数据 第三个参数是where里面的条件也就是更新id = 1 的 以及 id = 2的数据
  // print_r($ids);die;


  //删除数据
  //第一种写法：
  // $id = $this->db->delete('users',array('id'=>18));
  // print_r($id);die;
  //第二种写法：
  // $this->db->where('id=',17);
  // $this->db->delete('users');

  //删除多张表里面的数据
  // $tables = ['users','student'];
  // $this->db->where('id =',3);
  // $this->db->delete($tables);

  //删除一张表里面所有的数据
  // $this->db->empty_table('student');
  //or 使用
  // $this->db->truncate('student');


  //查询构造器缓存
  // $this->db->start_cache();//开始缓存
  // $arr = $this->db->select('username,address');
  // $this->db->stop_cache();//停止缓存

  // $ar = $this->db->get('users');

  // $this->db->select('password')->get('users');
  // $this->db->flush_cache();//清空缓存
  // $this->db->select('password')->get('users');



  //事物的使用   记住将数据库引擎转换成InnoDB
  // $this->db->trans_start();
  // $this->db->delete('users',array('id'=>15));
  // $this->db->insert('users',['id'=>13,'username'=>'wahaha','password'=>'爽歪歪','address'=>'山东菏泽']);
  // $this->db->trans_complete();


  //事物的使用  手动设置事物
  // $this->db->trans_begin();
  // $this->db->delete('users',array('id'=>15));
  // $this->db->insert('users',['id'=>13,'username'=>'wahaha','password'=>'爽歪歪','address'=>'山东菏泽']);
  // if ($this->db->trans_status() === FALSE)
  // {
  //     $this->db->trans_rollback();
  // }
  // else
  // {
  //     $this->db->trans_commit();
  // }


  //数据库缓存的实现
  //1.首先在database.php文件当中 开启数据库缓存'cache_on' => TRUE,  设置数据库缓存位置： 'cachedir' => 'E:\phpstudy\WWW\ci3.15\db_cahce',然后执行下边的代码即可，数据库缓存其实就是将读取出来的数据缓存到了文件当中；下次用的时候直接读取的是文件里面的内容

  // $this->db->cache_on();
  // $query = $this->db->query("SELECT * FROM ci_users");
  // $this->db->cache_off();

  //删除数据库缓存文件
  //当我们插入数据到数据库之后我们需要删除数据库文件里面的缓存文件  不然查询不到我们新添加的这条记录信息
  // $this->db->insert('users',array('username'=>'要洗','password'=>'123456','address'=>'山东大聊城'));
  // $this->db->cache_delete('home', 'blog');

  //删除所有的数据库缓存文件：
  //$this->db->cache_delete_all();

  }

  //表单验证操作
  public function myForm()
  {
   
    // if($_POST){
          //详情参考手册去吧！太多了！卧槽！
          //print_r($this->input->post('username'));
          // print_r($this->input->get('username'));
          // print_r($this->input->cookie('username'));
          //$this->input->set_cookie('username','wahahaha123');

    // }
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    //验证规则的第一种写法：
    // $this->form_validation->set_rules('username', '用户名称', 'required',array('required' => '用户名称不能为空！'));
    // $this->form_validation->set_rules('password','密码','required',array('required'=>'密码不能为空！'));

    //验证规则的第二种写法：
    // $config = array(
    //   array(
    //     'field'=>'username',
    //     'label'=>'用户名称',
    //     'rules'=>'required',
    //     'errors'=>array(
    //       'required'=>'用户名称不能为空!',
    //     )
    //   ),
    //   array(
    //     'field'=>'password',
    //     'label'=>'用户密码',
    //     'rules'=>'required',
    //     'errors'=>array(
    //       'required'=>'用户密码不能为空!',
    //     )
    //   )
    // );

    //验证规则的第三种写法：级联规则
    // $this->form_validation->set_rules('username', '用户名称', 'required|min_length[5]|max_length[12]|is_unique[users.username]',array(
    //   'required'=>'用户名称必须填写！',
    //   'min_length'=>'用户名称长度不能大于5个字符!',
    // ));
    // $this->form_validation->set_rules('password','用户密码','trim|required|min_length[8]',array(
    //   'required'=>'用户密码必须填写！',
    //   'min_length'=>'用户密码的长度最小为8位',
    // ));
    // $this->form_validation->set_rules('passconf','确认密码','required|matches[password]',array(
    //   'matches'=>'两次密码输入不一致！',
    //   'required'=>'确认密码必须填写！',
    // ));

    //自定义方法进行规则验证
    //$this->form_validation->set_rules('email','邮箱','callback_check_email');

    //调用model模型里面的方法进行验证
    // $this->load->model('user');//加载模型
    // $this->form_validation->set_rules('email','邮箱',array(
    //   'required',
    //    array('check_email',array($this->user, 'valid_username')),
    // ));



    // $this->form_validation->set_rules($config);

    // $this->load->view('home/Myform');
    //为了调用特定组的验证规则，你可以将它的名称传给 run() 方法
    if ($this->form_validation->run('user') == FALSE)
    {
        // $this->form_validation->error_array();//获取所有的错误信息
        // $this->form_validation->set_message('check_email', 'model模型验证email规则！');//设置错误信息
        // $arr = $this->form_validation->error('username');//获取特定的错误信息  比如获取username域的错误信息；
        $this->load->view('home/myform');
    }
    else
    {
        $this->load->view('formsuccess');
    }
  }

  //自定义方法验证邮箱格式
  public function check_email($str)
  {
    if($str != 123){
      $this->form_validation->set_message('check_email','邮箱>123');
      return false;
    }
    return true;
  }


//表单验证会发生错误  如何在前端显示错误信息 以及 如何实现发生错误之后保留之前我们填写的内容  参考这里：

<tr class="tr">

<td class="left">*&nbsp;商品名称：</td>
<td colspan="3">

//保留我们之前输入的内容
<input name="name" id="name" type="text" value="<?php echo set_value("name");?>" class="ctext"  size="80" />

//显示错误信息
<?php echo form_error('name','<span class="error">','</span>'); ?>

</td>

 </tr>

}
