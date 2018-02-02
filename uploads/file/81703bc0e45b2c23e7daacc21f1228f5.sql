-- 双中华先是注释的意思  中华线后边必须要有空格
# 也是表示注释的意思  也是单行注释
create database hushaoliang charset utf8; -- 创建数据库 并且设置字符集

create database `database` charset utf8; -- 数据库名称最好不要使用mysql关键字以及保留关键字  如果非得要使用比如就得要用database 那么在数据库的名称上加上反引号 这样就可以使用保留关键字和关键字了

# 报错:
 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'database charset utf8' at line 1  --数据库报错一般之后报告大体的位置 成为静默模式  sql syntax就是表示语法错误 然后根据报错去大体位置 慢慢去找吧

# 创建中文数据库
set names gbk;-- 首先要告诉它当前是什么编码 为gbk 
create database 中国 charset utf8; -- 然后创建中文版本的数据库  但是不建议这么使用哈  有的服务器不支持

-- 我们执行了创建数据库的命令 那么在mysql/data/目录下会创建相同名称的文件夹  没个数据库同名的文件夹目录下都会有一个.opt文件是数据库选项文件 里面有字符集和校对集

show databases; -- 查看所有的数据库
show databases like 'mysql_%';--  %表示可以替换所有的 _表示单个字符  这样匹配出来的是mysql_%其实就是相当于mysql%  如果要查询mysql_info那么查询条件应该是show databases like 'mysql\_%';反斜杠\表示转义
show databases like 'mysql\_%';

show create database ci; -- 查看数据库创建语句（其实就是查看创建数据库的sql语句）
show create table ci_student; #当然我们也可以查看创建表的sql执行语句

# 更改数据库 （数据库的名称是不允许修改的  所以这里的更改值的是修改选项里面的东西 也就是字符集和校对集 但是校对集又依赖于字符集）
alter database ci charset  gbk; -- 我们修改了字符集那么校对集也跟着修改了 也变成了gbk形式的了

drop database ci; -- 删除数据库  不是闹着玩的 删除之前一定要备份

#创建表  
-- 第一种方法 
-- 解释 if not exists 表示如果表不存在的话创建 如果存在的话就会报错  ci.ci_users表示在ci数据库下创建ci_users表
create table if not exists ci.ci_users(
    name varchar(10),
    age int,
    sex int
)charset utf8；

-- 第二种方法
use ci;
create table if not exists ci_users(
    name varchar(10),
    age int
)charset utf8;


-- 查看所有的表
show tables;
-- 查看指定的符合规则的表
show table like 'my%';
show table like 'my\_%'; --和查看数据库一样的解释；

--  \g表示的是分号的意思
show table like 'my%'\g

--  查看表结构
show columns from ci.ci_student\g  --查看ci数据库里面的ci_student表的所有的字段 也就是查看表结构
desc ci.ci_student; --第二种查看表结构的方法
describe ci.ci_student; --第三种查看表结构的方法

-- 修改表名称
rename table ci_student to student\g

-- 修改表本身
alter table ci_student charset utf8;
alter table ci_student ENGINE InnoDB;

-- 表中增加字段
alter table tea add column password varchar after userid;
alter table tea add column userpass varchar(200) not null after userid;

--表中修改字段 包括修改字段位置 字段类型
alter table tea modify password varchar(200) not null after userid;# 表示修改字段名称password的字段类型为varchar(200)长度  并且为之在userid的后边


--表中修改字段名称
alter table tea change tea gender char(3) not null after address; #change表示旧字段 gender表示新字段 char(3)新字段的类型长度  

-- 删除表中的字段
alter table tea drop name; #删除表中的name字段

-- 删除表
drop table ci_tea;

-- 插入数据到表当中
insert into ci_users values (4,'hushaoliang','2','山东聊城'),(5,'lijinjin','2','山东聊城'); #不指定字段的插入 那么插入的数据必须要和字段顺序相同  并且di也要写上
insert into ci_users(username,password,sex,address) values('hushaoliang',33222,2,'山东济南'),('hushaoliang',33222,2,'山东济南');#指定字段插入数据记录也可以一次性插入多条；

-- 简单查询
select * from ci_users;
select username,password from ci_users where id = 1;

-- 简单修改
update ci_users set sex = 1 where id = 3;
-- 下边这种修改也是比较常见的
update bd_class set c_id = c_id + 100 where id = 1;

--  简单的数据删除
delete from ci_users where id = 3;

-- 字符集编码问题
show character set; #查看所有的服务器支持的字符集编码有哪些；  一共有39种字符集 相当于39种中国的方言这玩意都会识别；  服务器是万能的 任何字符集都支持；

-- 查看服务器默认的字符集是什么
show variables like 'character_set%';
我们发现返回的是
  character_set_client     | utf8                              |    这个表示默认接收客户端数据的时候的字符集是utf8;
| character_set_connection | utf8                              |    这个表示连阶层 不先懂
| character_set_database   | utf8                              |    这个表示当前数据库的字符集
| character_set_filesystem | binary                            |     二进制文本处理
| character_set_results    | utf8                              |    服务器默认的给外部的数据的字符集是utf8  
| character_set_server     | utf8                              |
| character_set_system     | utf8                              |
| character_sets_dir       | E:\phpstudy\MySQL\share\charsets\

如何设置服务器字符集 set names gbk ;
关于字符集的阐述：
一个汉字gbk下占两个字节  但那时utf8下占3个字节；  我们可以查看默认的服务器的字符集  默认接收客户端的是utf8   返回回来的也是utf8 所以才会出现我们插入数据当插入中文的时候会报错的问题 因为中文本来就是gbk形式的 并且客户端都是gbk字符集   但是服务器接收的时候是utf8 就会报错；
在读取的时候客户端默认是gbk读取  但是默认返回的是utf8  所以客户端查看的时候就会出现乱码；
这都取决于服务器上的接收时候的字符集以及输出时候的字符集；
我们可以通过set names gbk来设置服务器接收的传出数据时候的字符集为gbk 那么这样客户端因为默认的就是gbk就可以在插入的时候以及查询的时候都能够正常显示汉字了！
两外这只是接收和传出  至于数据库是怎么存储数据的 得看表的选项当中的字符集了 这和前者没关系！

我们的ide一般都要是utf8的才行  因为服务器默认的就是utf8接收数据和utf8返回数据  至于表存什么样的我们就不用管了 可以是gbk也可以是utf8、

#校对集的问题
# 校对集的运用  校对集其实就是数据的比较的时候才能用到校对集 比如order by排序的时候会根据校对集来进行排序 有三种校对集的比较方法  
_bin 二进制的比较方法 一位一位的比较 区分大小写
_cs 大小写敏感 区分大小写
_ci 这个比较用的多  不区分大小写的进行比较

校对集必须在没有数据之前生明好  有了数据修改是无效的！

-- 查看数据库所有的校对集
show collation;

-- 我们可以在创建表的时候来规定校对集合  但是默认的就是ci不区分大小写的  如果你愿意写你就写好了
create table if not exists ci_users(
    name char(20) not null,
    password varchar(200) not null
)charset utf8 collate utf8_general_ci; #utf8_bin

很少去动校对集！

# 字符集编码的问题
我们知道一个网站是由客户端网页   php服务器（apache）  mysql数据库服务器 三部分组成  
客户浏览的浏览器默认的在中国是gbk编码  php服务器默认的是utf8编码  mysql数据库服务器默认的也是utf8编码 
客户看到的数据是从mysql数据库当中读取到的数据  但是如果不做任何修改的话 客户端看到的数据绝对会是乱码的  该怎么来做呢？ 这所有的一切都得要php来操作了！

php可以来修改浏览器的字符集编码  如果客户端是php文件 我们可以通过header("Content-type:text/html;charset=utf-8")来设置浏览器的字符集编码 如果是客户端的文件是html代码 那么我们可以通过 <meta charset="UTF-8"> 来设置客户端的字符集为utf8   

php服务器和mysql服务器之间都是utf8 理论上我们不需要转 但是我们还是要告诉两端服务器 使用的就是我们之前经常见到的set names utf8； 

到了mysql服务器当中 我们发现表当中是gbk2312  这个我们就不用管了 那么数据库内部的事情了 它支持39种字符集 所以我们不用管他！反正告诉数据库服务器给你的是utf8 你往回返的也是utf8就足够了！

自此 也就明白了header("")的作用 以及  <meta charset="UTF-8">  的作用了！


-- 接下来我们讲数据类型
数据类型：对数据进行统一的分类 从系统的校对出发能够进行统一的管理 更好的利用有限的空间
sql的分类 主要有三大类：  数字类型 字符串类型 时间类型
具体详情参考有道云数据库mysql部分里面的数据类型介绍

-- 数据库警告 
有时候我们在执行数据库操作的时候会得到一个数据库警告 如何查看数据库警告呢
show warnings;



-- 一对一
一个表当中的一条记录对应着两外表当中的一条记录  反过来 另外一张表的一条记录对应着这张表当中的一条记录  这就是一对一；
-- 一对多
一个表当中的一条记录对应另外一张表当中的多条记录  反过来 另外一张表当中的一条记录对应这张表当中的一条记录  这就是一对多；（在多的表当中增加外键）
-- 多对多
一个表当中的一条记录对应着另外一张表当中的多条记录  反过来 另外一张表当中的一条记录对应着前一张表当中的多条记录  那么这就是多对多的关系（多对多的关系需要第三张表作为关联表）


-- 解决主键冲突的问题
# 我们在平时操作的时候很容易产生主键冲突的问题 解决主键冲突的问题有两种方法
第一种就是更新 比较麻烦 意思就是只更新要更新的字段  主键不做任何的改动
第二种就是替换 比较简单 意思就是先干掉之前的 然后再插入现在的
所以两种发生执行的话那么受影响的行数都是两条！
现在我们重点讲解一下第二种方法替换：
-- 我们只是把平时用到的insert into 替换成了 replace into 而已！  那么在执行操作的时候首先会干掉之前存在的主键对应的记录  然后在执行插入操作  如果没有找到主键对应的记录 那么就会直接执行插入操作！
REPLACE INTO bd_wechat_token (id,token,update_time,expires_time) values (3,'zhelishitoken',1506581302,1506581302) ;


--获取一个表的表结构
## 非常简单的一个方法  直接获取到表结构 一条命令搞定哦！
create table bd_copy_user like 库.bd_user;  --相当于创建新的表  复制了bd_user表当中的表结构出来！

--蠕虫复制
# 我们既然获取到了表结构 那么我们照样可以获取到表当中的内容 使用蠕虫赋值即可！
蠕虫复制有两层含义：
                A：复制一个表当中的所有的数据到另外的表当中  只是赋值数据哦！
                B：使表当中的数据能够成倍的增加  翻倍的增加！
//复制别的表当中的数据到新建的表当中去；  复合A层含义
insert into bd_copy_user select * from bd_user;
//复制自己表当中的内容 实现数据的翻倍增长 用来做压力测试等
//一定要注意的一个事情就是主键冲突问题  在复制的时候一定要保证主键自增 另外复制的时候不要复制主键哦！
insert into bd_wechat_copy_token (token,update_time,expires_time) select token,update_time,expires_time from bd_wechat_copy_token;

//高级更新语句  限制更新的条数
#情景： 比如我们只给成绩满100分的 前三个人发送奖品 后边满足的不发放奖品  那么我们就需要使用到限制更新条数
update bd_wechat_copy_token set token = 'hushaoliang' where id < 20 limit 3;

//高级删除语句  限制删除的条数  类似于高级更新语句

//清空表 并且重置子增长
truncate  bd_user;

//查询所有的  等同于select * from bd_user;
select all * from bd_user;
//查询去除重复的  只有查询出来的记录的没个字段都相同的时候我们才认为是重复的  才可以进行去重操作；
//去除重复值针对整条记录而言的 而不是该条记录当中的某个字段！
select DISTINCT token,update_time,expires_time from bd_wechat_copy_user;

//字段别名
select id,username as name,sex from bd_user;//加上as 表示别名
select id,username name,sex from bd_user;//不加as 也可以表示别名

//where的深入理解：
where 语句当中不能存在统计函数 count  max  min 等统计函数；
where是唯一一个直接从磁盘获取数据的时候就开始判断的条件：从磁盘取出一条记录，开始进行where判断；判断如果成立保存到内存，如果失败则放弃；所以这样保证了内存的使用率 不会占用太多内存，保证存入到内存当中的绝对是有效数据！
查询五子句包含 where group by  order by  limit having
//随机的去改变一个字段的值：
UPDATE bd_wechat_copy_user set token = floor(rand()*20+20) where id = 1;#rand()在sql语句当中只能是0-1之间的数字 * 20 + 20 表示是20到40之间的随机数字  floor()表示向下取整！


select * from bd_wechat_copy_user where token  = 30 || token = 32 || token = 34;
--上边的写法可以简化成下边的写法  使用in()关键字来简化sql语句
select * from bd_wechat_copy_user where token in(30,32,34);

select * from bd_wechat_copy_user where token >=30 and token <=34;
--上边的写法我们可以简化成下边的写法  使用between()关键字来简化sql语句
select * from bd_wechat_copy_user where token BETWEEN 30 and 34;

--where 1表示返回true   我们上边讲过where条件返回的是0 和 1 先从磁盘当中都去  如果读取到把数据保存到内存当中返回1  如果查询不到那么直接终止返回0   这里的where 1 表示的是返回true 表示满足所有的条件  只是为了在某些特定的情况下保证sql语句的完整性！
select * from bd_user where 1;

--group by  分组
一定要明确一点就是group by 是用来进行分组的 而不是用来进行排序的  我们使用group by 进行分组完成之后 可以通过count()  max() min() 等函数进行数据的统计；
-- 比如这个案例  按照token进行分组  按照什么分组 那么要查看的字段最好写上该字段  可以清晰看到按照token分了几组；  然后count()  max() min() 这些函数都是针对分组完成之后的在本组内的统计情况！
-- 比如count(*) 表示的就是分组完成之后该分组下的记录的数量  max(update_time)表示的就是分组完成之后该分组下的update_time字段最大的的值统计出来！ 都是按照分组完成之后的在该组内部的数据进行统计！
-- 分组会自动排序 排序的规则就是根据排序的字段  按照升序来排序 排序是对分组的整体结果进行排序 不干涉内部的事情
-- group by token desc; 表示按照降序排序  不用再写order by token desc;
select token,count(*),count(token),max(update_time),avg(update_time) from bd_wechat_copy_user group by token desc; #这里我们改成了降序排序

--多字段分组
# 这里表示先按照c_id 表示是先按照班级进行排序  然后在按照性别进行排序； 这样子就可以统计处没个班级内的男女人数；
select c_id,sex,count(sex) from bd_class group by c_id,sex;
--分组完成之后如果我们想要知道该分组当中对应的学生都有谁呢？那么我们可以使用group_concat()方法
# group_concat() 可以对分组下的某个字段进行字符串连接（保留该组所有的某个字段）
select c_id,count(c_id),sex,GROUP_CONCAT(studentname),count(sex) from bd_class group by c_id,sex;

我们不要试图通过分组来获取到表记录当中的某个字段的具体的值；因为这样子是获取不到的  分组之后都是按照group by  后边的字段进行升序的排序； 所以就算是获取某个字段的值也是按照升序排序获取到一部分 而不是全部的；所以使用group by的时候我们最好是做统计处理 或者使用group_concat()方法获取到某个字段的字符串集合；

--分组当中比较高级的回溯统计
-- with ROLLUP 比如这里count(c_id) 那么回溯统计会计算出所有的总的记录数  另外GROUP_CONCAT(studentname) 也会统计出所有的学生的名称  所以回溯还是比较有用的  注意回溯统计当中按照哪个字段排序他是为null的！
select c_id,count(c_id),GROUP_CONCAT(studentname) from bd_class group by c_id with ROLLUP;


-- having()
having 和 where 都是条件语句； 不同的是where是从磁盘当中读取数据  但是having是从内存当中读取数据；所以having可以做where大部分的工作  但是where却做不了having的工作
比如group by 分组就是需要在内存当中进行的操作  所以必须使用having才行；
--计算出所有班级人数大于2的学生人生  那么首先要根据班级进行分组 就要用到group by   分组完成之后 条件就是没个分组的记录数大于等于2  就要是使用到having();
select c_id,count(*),GROUP_CONCAT(studentname) from bd_class group by c_id HAVING count(*) >= 2;


having 可以使用字段別名  但是 where 不能使用字段别名称  因为字段别名是要在内存当中使用到的  where只是去查找磁盘当中的数据  保证存储到内存当中的数据的有效性！
-- cc
select c_id,count(*) as cc,GROUP_CONCAT(studentname) from bd_class group by c_id HAVING cc >= 2;
-- ss
select sex as ss from bd_class where ss = '男';


-- 排序 order by
排序不必多讲 关键是按照多个字段进行排序的时候需要注意的地方就是 ： 首先会按照第一个字段进行排序 第二个字段的排序是建立在第一个字段排序的结果基础上的；比如先按照班级进行排序  然后按照性别进行排序  那么首先会先按照班级进行排序  然后在这个结果上在根据性别进行排序；

-- limit
select * from aa where id > 3 limit 2;
select * from aa where id > 3 limit 0,2;  # limit 0,2 这里的0表示从第一条数据开始查找 2表示查找的记录数量;



-- 链接查询
链接查询都会有 join关键字  在join的左边叫做左表 在join的右边叫做右表
sql当中链接查询分为四类：内链接 外连接 自然链接 交叉连接

交叉连接(CROSS JOIN )： 其实就是笛卡儿积  没什么卵用！

内链接(inner join)：
内鏈接要求左表和右表当中的关联数据必须都存在 如果有一方不存在 那么就放弃该条记录；
-- 可以省略inner join 当中的inner  直接使用join即可！ 这里的on 可以使用where代替  但是效率会比较慢  所以尽量不要使用where；
select c.*,t.token as tt from bd_class as c inner join bd_wechat_copy_token as t on c.c_id = t.token;

外链接(outer join)
分为 left join 和 right join
left join 的时候左边的表为主表  会拿着左边的表去和右边的表做匹配 如果副表当中不存在的话那么就会把右表当中的数据置空;
right join 的时候右边的表为主表 会用右的表去和左边的表做匹配 只是匹配主表右边的表的数据  至于左边多出来的没什么卵用！

虽然左右链接会有左表和右表之分 但是查询出来的数据还是左表的数据在前 右表的数据在后；

自然链接： 没什么卵用！


--php操作数据库   本身php是无法操作数据库  但是可以通过php扩展来操作数据库  php操作数据库的扩展有三个 mysql(面向过程)  mysqli(面向过程+面向对象)  pdo(面向对象)


外键：外边的键  不在自己的表当中 如果一个表当中的字段（非主键） 指向另外一张表当中的主键 那么这个字段称之为外键;
php的开发过程中我们很少使用到外键 因为外键约束降低了php对数据的可控性；

--联合查询
联合查询其实就是把多个select 语句执行的结构通过union拼接到一块  前提是必须保证每条select语句查询的字段的个数一样多  不在乎数据类型是啥；
比如：
-- union默认是去除重复的  类似于select的第二个属性 DISTINCT  如果不想要去除重复的那么我们可以使用union all 这样就不会去除重复的记录了；
select c_id,sex,studentname from bd_class
UNION
SELECT token,update_time,expires_time from bd_wechat_copy_token;

-- 联合查询当中的select语句如果要用到order by  那么必须满足两个条件：
A:每条select 语句必须用括号括起来
B:order by 必须搭配 limit 使用
案例如下：
(select c_id,sex,studentname from bd_class order by c_id desc limit 99999999)
UNION
(SELECT token,update_time,expires_time from bd_wechat_copy_token order by token desc limit 99999999);

-- 子查询
查询是在某个查询结果之上进行的（一条select 语句内部包含了另外的一条select 语句）

子查询分为很多种：
A：标量子查询：（子查询当中获取到的结果是一行一列 一行一别不就是某个字段的值嘛 是的）
-- 标量子查询
select * from bd_wechat_copy_token where token  = (select id from bd_class where c_id = 3);

B:列子查询：(子查询当中获取到的结果是一列多行  一列多行不就是某个字段多个值嘛 是的)  列子查询我们需要使用关键字 in;
-- 列子查询
select * from bd_wechat_copy_token where token  in (select id from bd_class where c_id >1);

C:行子查询：（子查询语句当中查询出来的可以是一行一列 也可以是一列多行）

-- 行子查詢 第一种写法
select * from bd_wechat_copy_token where token = (select MAX(token) from bd_wechat_copy_token)
AND
update_time = (select MAX(update_time) from bd_wechat_copy_token);

-- 行子查询 第二种写法  比较简化的写法
select * from bd_wechat_copy_token where (token,update_time) = (select MAX(token),MAX(update_time) from bd_wechat_copy_token);

d：表子查询  又可以叫做from 子查询  写在from的后边 作为数据源   所以这个子查询必须查询出的是多行多列 也可以理解成结果返回的是一张表
-- 另外需要注意的是from 后边必须跟的是表名称 所以 我们需要为子查询写一个表别名 as 表名称；
select * from  (select * from bd_class where c_id >1) as classname where c_id > 3;


视图：
视图是一种有结构（有行有列）但是没结果（结构中不存放真实数据）的虚拟表，虚拟表的结构来源不是自己定义，而是从对应的基表当中产生的（视图的数据来源）

创建视图：
基本语法： Create view 视图名称 as select语句;   （这里的select语句可以是普通查询 也可以是链表查询 也可以是联合查询 也可以是子查询）
创建单表视图（基表只有一个）
创建多表视图（基本至少有两个）
案例：
create view my_v1 select * from bd_class;--创建单表视图
create view my_v2 select c.*,s.username,s.password  from bd_class as c left join bd_student as s on c.id = s.c_id;--创建多表视图

查看视图结构：
desc my_v1;
show create view my_v1;
试用于表的一些查看语句 一样试用于视图；

使用视图：
-- 我们可以把视图当作表一样来查询即可    视图是不存储数据的  它其实就是一个经销商  使用的时候直接从基表当中拿货  自己不存货也不生产货；  视图主要是用来做查询使用；
select * from my_v1;

修改视图：
视图本身不可修改 但是视图的数据来源可以修改   修改视图其实就是在修改视图数据的来源；
alter view 视图名称 as 新的select语句;

删除视图：
-- 视图可以删除 但是表不能轻易的删除  视图删除了之后我们可以根据表来再次创建视图  但是复杂的视图还是最好不要删除 因为此视图有可能是根据负责的业务逻辑组装出来的一条sql语句；
drop view my_v1;

使用视图的意义：
A：视图可以节省sql语句  将一条复杂的查询语句使用视图进行保存，以后可以直接对视图进行操作
B: 数据安全 视图操作都是针对查询的，如果对视图结构进行了处理（删除），不会影响基表数据（相对安全）
C: 视图往往在大项目当中使用 而且是多系统使用，可以对外提供有用的数据，但是隐藏关键的数据 保证数据安全；
D: 视图可以对外提供友好型 不同的视图提供不同的数据 对外好像我们专门为他设计的一样；
E： 视图可以更好的（容易）的进行权限控制

往视图当中插入数据：
必须要满足两个条件：
A:多表视图不能插入数据
B：单表视图可以插入数据  但是单表视图当中必须包含基表当中所有不能为空的字段 或者说 视图当中必须包含所有基表当中没有默认值的字段
如果满足以上两个条件 那么往视图当中插入数据是可以改变基表当中的数据的   但是我们提供视图都是为了查询来用  我们也不会允许用户通过视图去往基表当中插入数据  我们可以设置账户权限；
insert into my_v1 values(........);

删除视图当中的数据
必须满足的条件：
A:多表视图不能删除数据
B:单表视图可以删除数据
一旦删除单表视图当中的数据 那么基表当中的数据也会删除掉！  不过我们可以设置权限  禁止视图删除操作！
delete from my_v1 where id = 3;

修改视图当中的数据
没啥条件可以满足的  可以直接进行修改 不管是单表视图 还是 多表视图都可以直接进行修改 并且会影响到基表；

视图当中的算法：
什么时候使用算法：如果视图的select当中包含一个查询字句（查询五子句包含 where group by  order by  limit having ）的时候  一定要使用临时表算法  其他的可以不用指定（默认即可！）
-- 不要忘记加上algorithe = temptable  不然即使创建好了视图 但是在后期的查询过程当中也会报错！一起是遇到group by或者order by查询五字句的情况下最容易报错！
create algorithe = temptable view my_v2 as select * from my_user order by id desc;


--  事务的讲解
事务分为两种：自动事务（默认） 和 手动事务
事物事务的前提是 数据库的存储引擎必须是Inonodb
我们重点讲解手动事务：
1.开启事务：告诉系统一下所有的写操作不要直接写入到数据表  而是先存放到事务日志当中去；
start transaction;
2.进行各种操作
insert into bd_user values();
3.提交事物或者回滚事物（提交事物直接入库并清空事物日志文件  回滚则是清空事物日志文件）
COMMIT  -- 提交事务
rollback  -- 发生错误回滚事务

--  事务操作的原理
事务开启之后 所有的操作都保存到临时事务日志文件当中 事务日志只有在得到commit命令才会同步到数据表 在其他任何情况下都会清空（roolback 断电 断开连接）

--  事物回滚点
我们可以设置事务的回滚点  在执行发生错误的时候指定会滚到上边设置好的某个回滚点  从而不用将上边之前所有的操作全部回滚回去  只是会滚到指定的某个操作即可！  可惜CI当中貌似没有这个功能！具体如何操作百度吧！

--  自动事务
mysql当中默认的都是自动事务  也就是我们执行某条sql语句之后会里面看到数据表当中的变化  都是自动事物   平时我们也需要自动事物  但是我们可以设置不是自动事物  而是手动事物 也就是说你每次执行sql语句不会立马去改变数据库  而是每次需要提交事物才能更新数据库 好麻烦哦！ 不如直接开启自动事物！
show variables like "autocommit";  通过该sql可以查看自动事物是否开启 ON
set autocommint = off 或者 0  那么表示设置事物为手动
一般不要设置为手动 因为那样每次的sql执行你都要提交 费劲了可！

--  事务操作需要注意的地方
假设我们开启了事务
并且我们执行了update的语句  修改了money的值 在原有的基础上加上了500
那么我们在commit提交事务之前如果执行select 语句  那么查询到的结果是 原有的值+500 ;
但是  实际上数据表当中的值还是 原来的值
这是为什么呢？
原理就是 在开启事务之后 我们执行update操作 然后再执行select的操作  首先会去数据库当中查看原来的值 因为此时update的值已经存储到了事务日志文件当中 然后把查到的值放到事务日志文件当中进行处理  那么当我们select的时候就是我们修改之后的值  但是实际的数据表当中的值是没有发生任何变化的！
所以 事务在没有提交之前的所有的判断都是无意义的！

-- 事务的四大特性
A：atomic 原子性  事务的整个操作是一个整体 不可分割 要么全部成功 要么全部失败；
B：consistency 一致性 事物操作的前后 数据表当中的数据没有变化  只有commint之后才会产生效果；
C:隔离性质 事务操作是相互隔离不受影响的；
这个需要好好的解释一下：
比如小明和小王同时对数据表当中的记录进行事务处理;小明对id = 1的记录的money 加上500块钱   小王对id = 2 的记录的money - 500 操作；
小明开启事物  并且执行update语句之后 进行select查询 那么看到的是原有基础上+500;
小王开启事物  并且执行update语句之后 进行select查询  那么看到的是有的基础上-500;
这个时候小王提交了事物  那么数据表当中的数据就发生了变化；
然后 小明还是select 查看全表  但是看到的id = 2的值仍然是没有-500之前的数值；
这是为什么呢？
因为小明在开启事物之后 在第一次select的时候就已经把表当中的数据放到了事物日志当中 接下来的update操作是经过了事物日志的处理的； 所以在小明没有提交事物或者rollback回滚事物之前 查看到的都是第一次select 放到事物日志当中的数据；
这就证明 事物和事物之间是相互独立的 不受彼此任何影响的！

但是  不管是两个事物同时操作一条记录还是平时的一条sql语句操作同一条记录  InnoDB引擎下 那么都会存在行锁；  只有一方操作完毕 另外一方才能继续操作！
这就又引出另外的问题：
innodb默认就是行锁，但是如果在事务的操作过程当中，没有使用到索引，比如修改没有使用到主键或者唯一键或者普通索引  那么系统会自动全表检索数据，自动升级为表锁；
一旦自动升级为表锁  那么在该事务没有被释放（提交commit 或者rollback） 之前 其他任何人对该表当中的任何数据的操作都是无效的！ 需要排队等待哦！

D:通过事物进行的数据操作 一旦提交就是永久性的了  不能在修改！


