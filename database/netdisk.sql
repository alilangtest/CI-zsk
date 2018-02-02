/*
Navicat MySQL Data Transfer

Source Server         : localhost3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : netdisk

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-02 12:32:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for nd_actions_logs
-- ----------------------------
DROP TABLE IF EXISTS `nd_actions_logs`;
CREATE TABLE `nd_actions_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `column` varchar(255) DEFAULT NULL,
  `executor` varchar(50) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=218 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_actions_logs
-- ----------------------------
INSERT INTO `nd_actions_logs` VALUES ('165', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 14时46分53秒成功上传了文件chrome.dll', '1512110813', null, null);
INSERT INTO `nd_actions_logs` VALUES ('166', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月01日 15时13分14秒对chrome.dll的审核为成功状态', '1512112394', null, null);
INSERT INTO `nd_actions_logs` VALUES ('163', '新增', '知识分类', '胡绍良', '胡绍良用户于2017年11月30日 14时15分35秒新增了\'php\'记录', '1512022535', '127.0.0.1', null);
INSERT INTO `nd_actions_logs` VALUES ('164', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月01日 14时46分23秒对img_3.jpg的审核为成功状态', '1512110783', null, null);
INSERT INTO `nd_actions_logs` VALUES ('156', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年11月29日 15时10分26秒成功上传了文件full_1.jpg', '1511939426', null, null);
INSERT INTO `nd_actions_logs` VALUES ('157', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年11月29日 15时14分46秒对full_1.jpg的审核为成功状态', '1511939686', null, null);
INSERT INTO `nd_actions_logs` VALUES ('158', '删除', '部门知识', '胡绍良', '胡绍良用户于2017年11月29日 15时24分23秒删除了\'333333333333333\'记录', '1511940263', '127.0.0.1', null);
INSERT INTO `nd_actions_logs` VALUES ('159', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年11月29日 16时17分26秒成功上传了文件person_9.jpg', '1511943446', null, null);
INSERT INTO `nd_actions_logs` VALUES ('160', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年11月29日 16时17分37秒对person_9.jpg的审核为成功状态', '1511943457', null, null);
INSERT INTO `nd_actions_logs` VALUES ('161', '删除', '部门云盘', '胡绍良', '胡绍良用户于2017年11月29日 16时18分10秒成功删除了文件full_1.jpg', '1511943490', null, null);
INSERT INTO `nd_actions_logs` VALUES ('162', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年11月29日 16时19分54秒成功上传了文件img_3.jpg', '1511943594', null, null);
INSERT INTO `nd_actions_logs` VALUES ('167', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 15时16分06秒成功上传了文件jquery总结.txt', '1512112566', null, null);
INSERT INTO `nd_actions_logs` VALUES ('168', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月01日 15时16分18秒对jquery总结.txt的审核为成功状态', '1512112578', null, null);
INSERT INTO `nd_actions_logs` VALUES ('169', '分享', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 15时36分30秒分享了文件jquery总结.txt到安全产品部', '1512113790', null, null);
INSERT INTO `nd_actions_logs` VALUES ('170', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 15时37分25秒成功上传了文件MyEclipse 9.0 破解汉化.rar', '1512113845', null, null);
INSERT INTO `nd_actions_logs` VALUES ('171', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月01日 15时37分34秒对MyEclipse 9.0 破解汉化.rar的审核为成功状态', '1512113854', null, null);
INSERT INTO `nd_actions_logs` VALUES ('172', '分享', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 15时37分58秒分享了文件MyEclipse 9.0 破解汉化.rar到安全产品部', '1512113878', null, null);
INSERT INTO `nd_actions_logs` VALUES ('173', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 16时37分01秒成功上传了文件jquery总结.txt', '1512117421', null, null);
INSERT INTO `nd_actions_logs` VALUES ('174', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月01日 16时40分56秒对jquery总结.txt的审核为成功状态', '1512117656', null, null);
INSERT INTO `nd_actions_logs` VALUES ('175', '分享', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 16时42分04秒分享了文件jquery总结.txt到安全产品部', '1512117724', null, null);
INSERT INTO `nd_actions_logs` VALUES ('176', '新增', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 16时49分42秒成功新建了文件夹吞吞吐吐', '1512118182', null, null);
INSERT INTO `nd_actions_logs` VALUES ('177', '分享', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 16时51分17秒分享了文件夹吞吞吐吐到安全产品部', '1512118277', null, null);
INSERT INTO `nd_actions_logs` VALUES ('178', '删除', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 17时44分34秒成功删除了文件夹吞吞吐吐', '1512121474', null, null);
INSERT INTO `nd_actions_logs` VALUES ('179', '删除', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 17时44分34秒成功删除了文件jquery总结.txt', '1512121474', null, null);
INSERT INTO `nd_actions_logs` VALUES ('180', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 17时45分49秒成功上传了文件php.chm', '1512121549', null, null);
INSERT INTO `nd_actions_logs` VALUES ('181', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月01日 17时46分05秒对php.chm的审核为成功状态', '1512121565', null, null);
INSERT INTO `nd_actions_logs` VALUES ('182', '删除', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 17时46分31秒成功删除了文件php.chm', '1512121591', null, null);
INSERT INTO `nd_actions_logs` VALUES ('183', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月01日 17时47分38秒成功上传了文件CI.php', '1512121658', null, null);
INSERT INTO `nd_actions_logs` VALUES ('184', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月01日 17时47分49秒对CI.php的审核为成功状态', '1512121669', null, null);
INSERT INTO `nd_actions_logs` VALUES ('185', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时06分57秒成功删除了文件CI.php', '1512122817', null, null);
INSERT INTO `nd_actions_logs` VALUES ('186', '上传', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时08分36秒成功上传了文件jquery总结.txt', '1512122916', null, null);
INSERT INTO `nd_actions_logs` VALUES ('187', '审核', '审核文件', '和希文', '和希文用户于2017年12月01日 18时08分48秒对jquery总结.txt的审核为成功状态', '1512122928', null, null);
INSERT INTO `nd_actions_logs` VALUES ('188', '上传', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时10分31秒成功上传了文件jquery总结.txt', '1512123031', null, null);
INSERT INTO `nd_actions_logs` VALUES ('189', '审核', '审核文件', '和希文', '和希文用户于2017年12月01日 18时10分42秒对jquery总结.txt的审核为成功状态', '1512123042', null, null);
INSERT INTO `nd_actions_logs` VALUES ('190', '分享', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时11分09秒分享了文件jquery总结.txt到平台研发部', '1512123069', null, null);
INSERT INTO `nd_actions_logs` VALUES ('191', '新增', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时11分22秒成功新建了文件夹测试', '1512123082', null, null);
INSERT INTO `nd_actions_logs` VALUES ('192', '分享', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时11分32秒分享了文件夹测试到平台研发部', '1512123092', null, null);
INSERT INTO `nd_actions_logs` VALUES ('193', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时13分03秒成功删除了文件夹测试', '1512123183', null, null);
INSERT INTO `nd_actions_logs` VALUES ('194', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时13分03秒成功删除了文件jquery总结.txt', '1512123183', null, null);
INSERT INTO `nd_actions_logs` VALUES ('195', '分享', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时16分12秒分享了文件夹测试到平台研发部', '1512123372', null, null);
INSERT INTO `nd_actions_logs` VALUES ('196', '分享', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时16分22秒分享了文件jquery总结.txt到平台研发部', '1512123382', null, null);
INSERT INTO `nd_actions_logs` VALUES ('197', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时16分57秒成功删除了文件夹测试', '1512123417', null, null);
INSERT INTO `nd_actions_logs` VALUES ('198', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时16分57秒成功删除了文件jquery总结.txt', '1512123417', null, null);
INSERT INTO `nd_actions_logs` VALUES ('199', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时25分46秒成功删除了文件夹测试', '1512123946', null, null);
INSERT INTO `nd_actions_logs` VALUES ('200', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时25分46秒成功删除了文件jquery总结.txt', '1512123946', null, null);
INSERT INTO `nd_actions_logs` VALUES ('201', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时33分03秒成功删除了文件夹测试', '1512124383', null, null);
INSERT INTO `nd_actions_logs` VALUES ('202', '删除', '部门云盘', '和希文', '和希文用户于2017年12月01日 18时33分03秒成功删除了文件jquery总结.txt', '1512124383', null, null);
INSERT INTO `nd_actions_logs` VALUES ('203', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月12日 16时17分37秒成功上传了文件2.png', '1513066657', null, null);
INSERT INTO `nd_actions_logs` VALUES ('204', '删除', '我的上传', '胡绍良', '胡绍良用户于2017年12月12日 16时18分29秒删除了2.png该文章未进行审核!', '1513066709', null, null);
INSERT INTO `nd_actions_logs` VALUES ('205', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月12日 16时18分52秒成功上传了文件1.png', '1513066732', null, null);
INSERT INTO `nd_actions_logs` VALUES ('206', '删除', '我的上传', '胡绍良', '胡绍良用户于2017年12月12日 16时19分06秒删除了1.png该文章未进行审核!', '1513066746', null, null);
INSERT INTO `nd_actions_logs` VALUES ('207', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月13日 15时25分41秒成功上传了文件1.png', '1513149941', null, null);
INSERT INTO `nd_actions_logs` VALUES ('208', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月21日 08时50分12秒成功上传了文件THINKPHP总结.docx', '1513817412', null, null);
INSERT INTO `nd_actions_logs` VALUES ('209', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月21日 15时14分13秒成功上传了文件b2bb2cc2c.txt', '1513840453', null, null);
INSERT INTO `nd_actions_logs` VALUES ('210', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月22日 08时39分22秒成功上传了文件jquery总结.txt', '1513903162', null, null);
INSERT INTO `nd_actions_logs` VALUES ('211', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月22日 08时39分48秒对jquery总结.txt的审核为成功状态', '1513903188', null, null);
INSERT INTO `nd_actions_logs` VALUES ('212', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月22日 09时10分50秒成功上传了文件常用函数总结表.xls', '1513905050', null, null);
INSERT INTO `nd_actions_logs` VALUES ('213', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月22日 09时11分21秒对常用函数总结表.xls的审核为成功状态', '1513905081', null, null);
INSERT INTO `nd_actions_logs` VALUES ('214', '上传', '部门云盘', '胡绍良', '胡绍良用户于2017年12月22日 09时16分33秒成功上传了文件day01-Java基础语法.pptx', '1513905393', null, null);
INSERT INTO `nd_actions_logs` VALUES ('215', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月22日 09时16分47秒对day01-Java基础语法.pptx的审核为成功状态', '1513905407', null, null);
INSERT INTO `nd_actions_logs` VALUES ('216', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月22日 09时30分50秒对b2bb2cc2c.txt的审核为成功状态', '1513906250', null, null);
INSERT INTO `nd_actions_logs` VALUES ('217', '审核', '审核文件', '胡绍良', '胡绍良用户于2017年12月22日 09时35分03秒对1.png的审核为成功状态', '1513906503', null, null);

-- ----------------------------
-- Table structure for nd_action_log
-- ----------------------------
DROP TABLE IF EXISTS `nd_action_log`;
CREATE TABLE `nd_action_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `msg` varchar(255) DEFAULT NULL,
  `to_deptid` varchar(255) DEFAULT NULL,
  `sfgx` int(5) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0:逻辑删除;1:正常可用;',
  `updatetime` int(11) DEFAULT NULL,
  `ly` int(3) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_action_log
-- ----------------------------
INSERT INTO `nd_action_log` VALUES ('3', '文章《333333333333333》被胡绍良管理员于2017-11-28 13:11:50任性的删除了!想要获取请重新联系胡绍良进行分享操作!', '43859148', '1', '1511845910', '127.0.0.1', null, null, '1', '13');
INSERT INTO `nd_action_log` VALUES ('4', '文章《333333333333333》被胡绍良管理员于2017-11-28 13:11:50任性的删除了!想要获取请重新联系胡绍良进行分享操作!', '43859148', '1', '1511845910', '127.0.0.1', null, null, '1', '13');

-- ----------------------------
-- Table structure for nd_articles
-- ----------------------------
DROP TABLE IF EXISTS `nd_articles`;
CREATE TABLE `nd_articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  `dpt` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `column` int(11) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `describe` text,
  `content` text,
  `status` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_articles
-- ----------------------------
INSERT INTO `nd_articles` VALUES ('8', '485', null, '-1', '个人知识3', '2', '个人知识2', '个人知识2', '<p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em style=\"font-family: \">layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em style=\"font-family: \">layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em style=\"font-family: \">layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em style=\"font-family: \">layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em style=\"font-family: \">layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em style=\"font-family: \">layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em style=\"font-family: \">layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em style=\"font-family: \">layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em style=\"font-family: \">layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em style=\"font-family: \">layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em style=\"font-family: \">layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em style=\"font-family: \">layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p>', '1', '1511148108', '127.0.0.1', '1511845371', '2', '29897246');
INSERT INTO `nd_articles` VALUES ('10', '485', null, '-1', '哇哈哈哈1111', '2', '11', '11', '<p>111111111</p>', '0', '1511154790', '127.0.0.1', '1511856096', '1', '29897246');
INSERT INTO `nd_articles` VALUES ('11', '485', null, '-1', '爽歪歪1111', '2', '111', '111', '<p>11111</p>', '1', '1511154881', '127.0.0.1', '1511926384', '1', '29897246');
INSERT INTO `nd_articles` VALUES ('13', '485', null, '1', '333333333333333', '4', '222', '222', '<p>22222</p>', '0', '1511155219', '127.0.0.1', '1511940263', '1', '29897246');
INSERT INTO `nd_articles` VALUES ('14', '485', null, '1', '测试使用', '2', '测试使用', '测试使用', '<p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em style=\"font-family: \">layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em style=\"font-family: \">layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em style=\"font-family: \">layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);\"><em style=\"font-family: \">layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<em style=\"color: rgb(51, 51, 51); text-decoration: none; font-weight: 900;\"><a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\">Fly</a></em></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>是一款近年来备受青睐的web弹层组件，她具备全方位的解决方案，致力于服务各水平段的开发人员，您的页面会轻松地拥有丰富友好的操作体验。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\">在与同类组件的比较中，<em>layer</em>总是能轻易获胜。她尽可能地在以更少的代码展现更强健的功能，且格外注重性能的提升、易用和实用性，正因如此，越来越多的开发者将媚眼投上了<em>layer</em>（已被<em style=\"font-weight: 900;\">5395393</em>人次关注）。<em>layer</em>&nbsp;甚至兼容了包括 IE6 在内的所有主流浏览器。她数量可观的接口，使得您可以自定义太多您需要的风格，每一种弹层模式各具特色，广受欢迎。当然，这种“王婆卖瓜”的陈述听起来总是有点难受，因此你需要进一步了解她是否真的如你所愿。</p><p style=\"margin-top: 0px; margin-bottom: 10px; white-space: normal; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-indent: 2em; line-height: 23px; color: rgb(55, 55, 55); font-family: 微软雅黑; font-size: 14px; background-color: rgb(255, 255, 255);\"><em>layer</em>&nbsp;采用 MIT 开源许可证，<em style=\"font-weight: 900;\">将会永久性提供无偿服务</em>。因着数年的坚持维护，截至到2017年9月13日，已运用在超过&nbsp;<em style=\"font-weight: 900;\">30万</em>&nbsp;家 Web 平台，其中不乏众多知名大型网站。目前 layer 已经成为国内乃至全世界最多人使用的 Web 弹层解决方案，并且她仍在与 Layui 一并高速发展。<a href=\"http://fly.layui.com/\" target=\"_blank\" style=\"color: rgb(51, 51, 51); text-decoration: none;\"><em style=\"font-weight: 900;\">Fly</em></a></p><p><br/></p>', '1', '1511789526', '127.0.0.1', '1511845952', '1', '29897246');
INSERT INTO `nd_articles` VALUES ('15', '485', null, '-1', '测试的', '4', '测试', '测试', '<p>测试测试</p>', '1', '1511844868', '127.0.0.1', '1511845371', '1', '29897246');
INSERT INTO `nd_articles` VALUES ('16', '485', null, '1', '部门知识1111', '3', '部门知识', '部门知识', '<p>的打发打发打发打发打发的</p>', '1', '1511845623', '127.0.0.1', '1511845952', '1', '29897246');

-- ----------------------------
-- Table structure for nd_article_share
-- ----------------------------
DROP TABLE IF EXISTS `nd_article_share`;
CREATE TABLE `nd_article_share` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `deptid` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `to_userid` varchar(255) DEFAULT NULL,
  `to_deptid` varchar(255) DEFAULT NULL,
  `share_validity` varchar(100) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0:逻辑删除;1:正常可用;',
  `updatetime` int(11) DEFAULT NULL,
  `dpt` int(11) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_article_share
-- ----------------------------
INSERT INTO `nd_article_share` VALUES ('52', '485', '29897246', '11', '', '29897246', '2000000000', '1511848215', '127.0.0.1', '1', '1511848283', '2', null);
INSERT INTO `nd_article_share` VALUES ('53', '485', '29897246', '15', '', '29897246', '2000000000', '1511848215', '127.0.0.1', '1', '1511848283', '2', null);
INSERT INTO `nd_article_share` VALUES ('54', '485', '29897246', '8', '', '29897246', '2000000000', '1511848215', '127.0.0.1', '1', '1511848283', '2', null);
INSERT INTO `nd_article_share` VALUES ('55', '485', '29897246', '11', '', '29872738', '2017-11-30 00:00:00', '1511930975', '127.0.0.1', '1', null, '2', null);
INSERT INTO `nd_article_share` VALUES ('56', '485', '29897246', '11', '', '43859148', '2017-11-30 00:00:00', '1511930982', '127.0.0.1', '1', null, '2', null);

-- ----------------------------
-- Table structure for nd_department
-- ----------------------------
DROP TABLE IF EXISTS `nd_department`;
CREATE TABLE `nd_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ding_dept_id` varchar(64) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `ding_parentid` varchar(64) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `create_dept_group` varchar(10) DEFAULT NULL,
  `auto_add_user` varchar(10) DEFAULT NULL,
  `dept_hiding` varchar(10) DEFAULT NULL,
  `dept_permits` varchar(200) DEFAULT NULL,
  `user_permits` varchar(200) DEFAULT NULL,
  `outer_dept` varchar(10) DEFAULT NULL,
  `outer_permit_depts` varchar(200) DEFAULT NULL,
  `outer_permit_users` varchar(200) DEFAULT NULL,
  `org_dept_owner` varchar(64) DEFAULT NULL,
  `dept_manager_userid_list` varchar(200) DEFAULT NULL,
  `has_sync` int(11) DEFAULT NULL,
  `is_leaf` int(11) DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_department
-- ----------------------------
INSERT INTO `nd_department` VALUES ('114', 'a1', '山东云天安全技术有限公司', '0', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('115', '29897247', '综合部', '29872740', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('116', '29895193', '财务管理部', '29872741', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('117', '29949187', '人力资源部', '29872740', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('118', '29950204', '资金管理部', '29872741', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('119', '29894176', '证券部', '29872741', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('120', '29872738', '服务平台管理中心', 'a1', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('121', '29872739', '大数据态势感知中心', 'a1', '0', '0', '0', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('122', '29872740', '行政管理中心', 'a1', '0', '0', '0', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('123', '29872741', '资本运营中心', 'a1', '0', '0', '0', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('124', '29872742', '营销中心', 'a1', '0', '0', '0', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('125', '29896209', '方案中心', '29872742', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('126', '29897246', '平台研发部', '29872738', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('127', '29899150', '销售部', '29872742', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('128', '29917155', '市场部', '29872742', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('129', '29940143', '大客户部', '29872742', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('130', '43838127', '分支中心', '29872742', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('131', '43859148', '安全产品部', '29872738', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('132', '44586025', '方案中心二部', '29872742', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('133', '44710058', '销售二部', '29872742', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('134', '45943613', '大数据运营维护中心', 'a1', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('135', '45952781', '培训部', '29872740', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('136', '45958554', '体验中心', '45943613', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('137', '45962661', '建设部', '29872739', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('138', '45965624', '运维中心', '45943613', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('139', '46000565', '呼叫中心', '45943613', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('140', '46007601', '监控中心', '45943613', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);
INSERT INTO `nd_department` VALUES ('141', '46008595', '战略部', '29872739', '0', '1', '1', null, null, null, null, null, null, null, null, '1', '0', '1', '1503997113', null);

-- ----------------------------
-- Table structure for nd_different
-- ----------------------------
DROP TABLE IF EXISTS `nd_different`;
CREATE TABLE `nd_different` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `tname` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_different
-- ----------------------------
INSERT INTO `nd_different` VALUES ('2', '477', '和希文', 'mysql', '22', null, '1510885584', '172.16.9.247', '1511931414', null);
INSERT INTO `nd_different` VALUES ('3', '477', '和希文', 'java', '3', null, '1510885602', '172.16.9.247', null, null);
INSERT INTO `nd_different` VALUES ('4', '485', '胡绍良', 'html', '4', null, '1511794617', '127.0.0.1', null, null);
INSERT INTO `nd_different` VALUES ('5', null, '胡绍良', 'php', '1', null, '1512022535', '127.0.0.1', null, '101411205632745955');

-- ----------------------------
-- Table structure for nd_directory
-- ----------------------------
DROP TABLE IF EXISTS `nd_directory`;
CREATE TABLE `nd_directory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `deptid` int(11) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_directory
-- ----------------------------
INSERT INTO `nd_directory` VALUES ('68', null, '29872738', '0', '测试', '10', '1512123082', '127.0.0.1', '0', '1512124383', '075169022121572231');

-- ----------------------------
-- Table structure for nd_download_status
-- ----------------------------
DROP TABLE IF EXISTS `nd_download_status`;
CREATE TABLE `nd_download_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) DEFAULT NULL,
  `msg` varchar(100) DEFAULT NULL COMMENT '压缩百分比',
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `request_id` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_download_status
-- ----------------------------
INSERT INTO `nd_download_status` VALUES ('3', '2', '恭喜你，文件下载成功！', '1511936127', '127.0.0.1', 'l2baMTCzLVhgkNXxouXl4jV4Mbp4L9D0');

-- ----------------------------
-- Table structure for nd_files
-- ----------------------------
DROP TABLE IF EXISTS `nd_files`;
CREATE TABLE `nd_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `deptid` int(11) DEFAULT NULL,
  `directory_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(20) DEFAULT NULL,
  `file_path` varchar(200) DEFAULT NULL,
  `file_icon` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_files
-- ----------------------------
INSERT INTO `nd_files` VALUES ('143', null, '29872738', '0', 'jquery总结.txt', '2372', 'txt', '/uploads/file/29872738/bee89ac3371195ca3f8443b4fa1daf4b.txt', '/public/images/file/txt.png', '10', '1512123031', '127.0.0.1', '-1', '1512124383', '075169022121572231');
INSERT INTO `nd_files` VALUES ('144', null, '29897246', '0', '2.png', '222850', 'png', '/uploads/file/29897246/ddc1142cc7b67a9fb3af3a17128b0629.png', '/public/images/file/png.png', '10', '1513066657', '127.0.0.1', '-1', null, '101411205632745955');
INSERT INTO `nd_files` VALUES ('145', null, '29897246', '0', '1.png', '342839', 'png', '/uploads/file/29897246/a7db1fff44640fe4660403c68eb72a5c.png', '/public/images/file/png.png', '10', '1513066732', '127.0.0.1', '-1', '1513066746', '101411205632745955');
INSERT INTO `nd_files` VALUES ('146', null, '29897246', '0', '1.png', '342839', 'png', '/uploads/file/29897246/f99b2b2013f991099bb3528a611b6e25.png', '/public/images/file/png.png', '10', '1513149941', '127.0.0.1', '2', null, '101411205632745955');
INSERT INTO `nd_files` VALUES ('147', null, '29897246', '0', 'THINKPHP总结.docx', '5226740', 'docx', '/uploads/file/29897246/196836e00a78e0aa2e74221bd85c2b31.docx', '/public/images/file/docx.png', '10', '1513817411', '127.0.0.1', '1', null, '101411205632745955');
INSERT INTO `nd_files` VALUES ('148', null, '29897246', '0', 'b2bb2cc2c.txt', '416', 'txt', '/uploads/file/29897246/911a2433659d3b846554b470cd617a6a.txt', '/public/images/file/txt.png', '10', '1513840453', '127.0.0.1', '2', null, '101411205632745955');
INSERT INTO `nd_files` VALUES ('149', null, '29897246', '0', 'jquery总结.txt', '2372', 'txt', '/uploads/file/29897246/4dd8feab420bf4d5cf0fd9157ff930e9.txt', '/public/images/file/txt.png', '10', '1513903162', '127.0.0.1', '2', null, '101411205632745955');
INSERT INTO `nd_files` VALUES ('150', null, '29897246', '0', '常用函数总结表.xls', '88576', 'xls', '/uploads/file/29897246/ce22e712774e56532a433ab21bb64d6f.xls', '/public/images/file/unknown.png', '10', '1513905050', '127.0.0.1', '2', null, '101411205632745955');
INSERT INTO `nd_files` VALUES ('151', null, '29897246', '0', 'day01-Java基础语法.pptx', '680335', 'pptx', '/uploads/file/29897246/8b0a5fa77df4000cf611284a4ec6f6d5.pptx', '/public/images/file/pptx.png', '10', '1513905393', '127.0.0.1', '2', null, '101411205632745955');

-- ----------------------------
-- Table structure for nd_intellectual_rights
-- ----------------------------
DROP TABLE IF EXISTS `nd_intellectual_rights`;
CREATE TABLE `nd_intellectual_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `deptid` int(11) DEFAULT NULL,
  `ty` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL COMMENT '按钮操作的id（1：移动；2：删除；3：审核）',
  `status` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=540 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_intellectual_rights
-- ----------------------------
INSERT INTO `nd_intellectual_rights` VALUES ('528', '485', '29897246', '1', '1', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('529', '485', '29897246', '1', '2', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('530', '485', '29897246', '1', '3', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('531', '485', '29897246', '2', '1', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('532', '485', '29897246', '2', '2', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('533', '485', '29897246', '2', '3', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('534', '485', '29897246', '2', '4', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('535', '485', '29897246', '3', '2', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('536', '485', '29897246', '3', '6', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('537', '485', '29897246', '4', '2', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('538', '485', '29897246', '4', '5', '1', '127.0.0.1', '1511856832', null);
INSERT INTO `nd_intellectual_rights` VALUES ('539', '485', '29897246', '5', '1', '1', '127.0.0.1', '1511856832', null);

-- ----------------------------
-- Table structure for nd_share
-- ----------------------------
DROP TABLE IF EXISTS `nd_share`;
CREATE TABLE `nd_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL COMMENT '文件或文件夹所属用户',
  `deptid` int(11) DEFAULT NULL COMMENT '文件或文件夹所属部门',
  `directory_id` int(11) DEFAULT NULL COMMENT '目录id',
  `file_id` int(11) DEFAULT NULL COMMENT '文件id',
  `to_userid` varchar(200) DEFAULT NULL COMMENT '分享给用户id',
  `to_deptid` varchar(200) DEFAULT NULL COMMENT '分享给部门id',
  `share_validity` int(11) DEFAULT NULL COMMENT '有效期到期时间(9999999999：表示永久有效)',
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0:逻辑删除;1:正常可用;',
  `ding_userid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_share
-- ----------------------------
INSERT INTO `nd_share` VALUES ('92', null, '29872738', '68', null, null, '29897246', '2000000000', null, null, '0', '075169022121572231');
INSERT INTO `nd_share` VALUES ('93', null, '29872738', null, '143', null, '29897246', '2000000000', null, null, '0', '075169022121572231');

-- ----------------------------
-- Table structure for nd_system_menu
-- ----------------------------
DROP TABLE IF EXISTS `nd_system_menu`;
CREATE TABLE `nd_system_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_system_menu
-- ----------------------------
INSERT INTO `nd_system_menu` VALUES ('9', '0', '全部文件', 'javascript:void(0);', '/public/images/home/img/707.png', '1', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('10', '9', '部门云盘', '/admin/file/files/files_list', '/public/images/home/img/708.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('12', '9', '共享文件', '/admin/file/files/share_list_page', '/public/images/home/img/59.png', '2', '2', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('13', '0', '知识库', 'javascript:void(0);', '/public/images/home/img/680.png', '1', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('14', '13', '知识分类', '/admin/knowledge/different/different_set', '/public/images/home/img/630.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('15', '13', '我的知识', '/admin/knowledge/intellectual/intellectual_list', '/public/images/home/img/678.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('16', '0', '回收站', 'javascript:void(0);', '/public/images/home/img/399.png', '1', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('17', '16', '网盘回收站', '/admin/file/recycle', '/public/images/home/img/848.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('18', '0', '系统管理', 'javascript:void(0);', '/public/images/home/img/21.png', '1', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('19', '18', '菜单管理', '/admin/menu', '/public/images/home/img/527.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('20', '18', '角色&权限', '/admin/permission', '/public/images/home/img/527.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('21', '18', '网盘权限分配', '/admin/user_rights', '/public/images/home/img/527.png', '2', '10', null, '1507773101', '127.0.0.1');
INSERT INTO `nd_system_menu` VALUES ('22', '9', '我的上传', '/admin/file/my_uploads', '/public/images/home/img/708.png', '2', '0', null, '1508119318', '127.0.0.1');
INSERT INTO `nd_system_menu` VALUES ('23', '9', '审核文件', '/admin/file/files/audit_page', '/public/images/home/img/708.png', '2', '1', null, '1508119991', '127.0.0.1');
INSERT INTO `nd_system_menu` VALUES ('24', '13', '公司共享', '/admin/knowledge/shareknow/share_list', '/public/images/home/img/708.png', '2', '11', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('25', '16', '知识回收站', '/admin/knowledge/recycle/recycle_list', '/public/images/home/img/708.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('26', '13', '部门知识', '/admin/knowledge/dpt_intellectual/dpt_intellectual_list', '/public/images/home/img/708.png', '2', '0', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('27', '18', '知识权限分配', '/admin/knowledge/Intellectual_rights/rights_view', '/public/images/home/img/708.png', '2', '11', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('28', '18', '用户行为日志', '/admin/knowledge/Behavior_log/behavior_list', '/public/images/home/img/708.png', '2', '12', null, null, null);
INSERT INTO `nd_system_menu` VALUES ('29', '18', '报表统计', '/admin/knowledge/Eacharts/index', '/public/images/home/img/708.png', '2', '13', null, null, null);

-- ----------------------------
-- Table structure for nd_system_role
-- ----------------------------
DROP TABLE IF EXISTS `nd_system_role`;
CREATE TABLE `nd_system_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_system_role
-- ----------------------------
INSERT INTO `nd_system_role` VALUES ('1', '普通会员', '1', '1', null, null);
INSERT INTO `nd_system_role` VALUES ('2', '超级管理员', '2', '1', null, null);
INSERT INTO `nd_system_role` VALUES ('3', '普通会员', '2', '1', null, null);

-- ----------------------------
-- Table structure for nd_system_role_rights
-- ----------------------------
DROP TABLE IF EXISTS `nd_system_role_rights`;
CREATE TABLE `nd_system_role_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_system_role_rights
-- ----------------------------
INSERT INTO `nd_system_role_rights` VALUES ('82', '3', '9', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('83', '3', '10', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('84', '3', '22', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('85', '3', '23', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('86', '3', '12', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('87', '3', '13', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('88', '3', '14', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('89', '3', '15', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('90', '3', '26', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('91', '3', '24', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('92', '3', '16', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('93', '3', '17', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('94', '3', '25', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('95', '3', '18', null, null, '1511856630');
INSERT INTO `nd_system_role_rights` VALUES ('96', '3', '28', null, null, '1511856630');

-- ----------------------------
-- Table structure for nd_user
-- ----------------------------
DROP TABLE IF EXISTS `nd_user`;
CREATE TABLE `nd_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT '0' COMMENT '用户类型',
  `openid` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `work_place` varchar(50) DEFAULT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT '0',
  `org_email` varchar(100) DEFAULT '0',
  `active` varchar(10) DEFAULT '0',
  `order_in_depts` varchar(1000) DEFAULT NULL,
  `is_admin` varchar(10) DEFAULT NULL,
  `is_boss` varchar(10) DEFAULT NULL,
  `dingid` varchar(64) DEFAULT NULL,
  `unionid` varchar(64) DEFAULT NULL,
  `is_leader_in_depts` varchar(100) DEFAULT NULL,
  `is_hide` varchar(10) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `jobnumber` varchar(10) DEFAULT NULL,
  `extattr` varchar(200) DEFAULT NULL,
  `roles` varchar(1000) DEFAULT NULL,
  `logintimes` int(11) DEFAULT '1',
  `lasttime` int(11) DEFAULT NULL,
  `lastip` varchar(20) DEFAULT NULL,
  `islock` int(11) DEFAULT NULL,
  `has_sync` int(11) DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=535 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_user
-- ----------------------------
INSERT INTO `nd_user` VALUES ('465', '3', 'OTgHOmMvxWKMSeIdOsbyygiEiE', null, '0431456943730381', '王沛', null, null, null, '18053158296', '', 'wangpei@cloudskysec.com', '1', '\"{1:195636398996051492}\"', '', '', '$:LWCP_v1:$ywTJP8yW9opLA5EeyGo5mg==', 'OTgHOmMvxWKMSeIdOsbyygiEiE', '\"{1:true}\"', '0', '[1]', '执行总裁', 'http://static.dingtalk.com/media/lADOuoYyAc0BsM0BsA_432_432.jpg', '0431456943', '[]', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352897,\"name\":\"\\u8d1f\\u8d23\\u4eba\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":157083330,\"name\":\"\\u6267\\u884c\\u603b\\u88c1\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('466', '3', 'wKpfMcrFTtJW9hqH3ii08ZAiEiE', null, '0208361617843618', '李峰', null, null, null, '13708936589', '', 'lifeng@cloudskysec.com', '1', '\"{a1:69601806055116512}\"', '', '', '$:LWCP_v1:$tUeS0j8XfpHKk4MfqlaKGA==', 'wKpfMcrFTtJW9hqH3ii08ZAiEiE', '\"{a1:false}\"', '0', '[a1]', '总裁', 'http://static.dingtalk.com/media/lADOoex7e80Bdc0BdQ_373_373.jpg', '', '', '[{\"id\":150352897,\"name\":\"\\u8d1f\\u8d23\\u4eba\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":164943504,\"name\":\"\\u8463\\u4e8b\\u957f\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('467', '3', 'K7LfGzRuPtIiE', '7363e9d0390247f8b121e1e7621488b8', '15280843780876', '张敬', null, null, null, '18678888823', '', 'zhangjing@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$KTImw4F8pfap8QIStha8dg==', 'K7LfGzRuPtIiE', '\"{a1:false}\"', '0', '[a1]', 'CTO', 'http://static.dingtalk.com/media/lADOud97b80Dpc0Dpg_934_933.jpg', '1528084378', '[]', '[{\"id\":150352897,\"name\":\"\\u8d1f\\u8d23\\u4eba\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":173262363,\"name\":\"\\u9996\\u5e2d\\u6280\\u672f\\u5b98\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '3', '1511746151', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('468', '3', '6vtz00ysJ2RW9hqH3ii08ZAiEiE', 'b756e9f4a5fa3ce70a4b00d3b86aef30', '03640039251149360', '赵梅', null, null, null, '18653166680', '', 'zhaomei@cloudskysec.com', '1', '\"{45952781:180345824175295541,29949187:180345824175295541,29897247:180345824175295541}\"', '', '', '$:LWCP_v1:$HZ2VokjeCj78TldD9wssAA==', '6vtz00ysJ2RW9hqH3ii08ZAiEiE', '\"{45952781:true,29897247:true,29949187:true}\"', '0', '[45952781,29949187,29897247]', '行政总监', 'http://static.dingtalk.com/media/lADPACOG81HGTU7NAu7NAuw_748_750.jpg', '0364003925', '[]', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352910,\"name\":\"\\u90e8\\u95e8\\u603b\\u76d1\",\"groupName\":\"\\u5c97\\u4f4d\"},{\"id\":216269158,\"name\":\"\\u5458\\u5de5\\u6d3b\\u52a8\\u57fa\\u91d1\\u7edf\\u8ba1\\u5458\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '23', '1510887210', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('469', '3', 'LhWTPPO6EbwpjgJImwcGXAiEiE', null, '1004072428680637', '刘燕', null, null, null, '13615318356', '', 'liuyan@cloudskysec.com', '1', '\"{29897247:69547253094800656}\"', '', '', '$:LWCP_v1:$iTRiwxI09MOWtP0pXoGFDg==', 'LhWTPPO6EbwpjgJImwcGXAiEiE', '\"{29897247:false}\"', '0', '[29897247]', '', 'http://static.dingtalk.com/media/lADOx-mawM0E0c0E0Q_1233_1233.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('470', '3', 'OKNXoTXDlJGiifbN0cFgbDQiEiE', null, '1005254601793544', '张雨', null, null, null, '15806616012', '', '', '1', '\"{29897247:2428311312701540}\"', '', '', '$:LWCP_v1:$PYQadP08R0qpcFuynEIFWw==', 'OKNXoTXDlJGiifbN0cFgbDQiEiE', '\"{29897247:false}\"', '0', '[29897247]', '', '', '1005254601', '', '[{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":224731721,\"name\":\"\\u8003\\u52e4\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', '1505872777', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('471', '3', 'ykHiPTyzUNHI4kfNQOMDHXAiEiE', null, '085352394429065550', '王东伟', null, null, null, '13646407078', '', 'wangdongwei@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$isVkTSzISaOHWy5iwTgetg==', 'ykHiPTyzUNHI4kfNQOMDHXAiEiE', '\"{29897247:false}\"', '0', '[29897247]', '', '', '', '', '[{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":215075670,\"name\":\"\\u516c\\u7ae0\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('472', '3', '3m8ajArHIX5cycecNxwEowiEiE', null, '086230464029622032', '田忠秀', null, null, null, '13256108295', 'tianzhongxiu@cloudskysec.com', 'tianzhongxiu@cloudskysec.com', '1', '\"{29895193:209067430028798476}\"', '', '', '$:LWCP_v1:$wM8mYwQ1SWypLb6tuLBvfQ==', '3m8ajArHIX5cycecNxwEowiEiE', '\"{29895193:true}\"', '0', '[29895193]', '财务总监', '', '0862304640', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352910,\"name\":\"\\u90e8\\u95e8\\u603b\\u76d1\",\"groupName\":\"\\u5c97\\u4f4d\"},{\"id\":173038162,\"name\":\"\\u8d22\\u52a1\\u7ecf\\u7406\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('473', '3', 'WBiSmSziSa7WXIXztkpKeVXgiEiE', null, '0741260005849877', '杨爽', null, null, null, '18306400146', '', 'yangshuang@cloudskysec.com', '1', '\"{29895193:8101600545337703}\"', '', '', '$:LWCP_v1:$XB6oRO7Nozf4wukNeW7N1w==', 'WBiSmSziSa7WXIXztkpKeVXgiEiE', '\"{29895193:false}\"', '0', '[29895193]', '', '', '0741260005', '', '[{\"id\":172977383,\"name\":\"\\u51fa\\u7eb3\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('474', '3', 'Ut6t5iirdiSEGhQANen1GpyQiEiE', null, '074124576220718501', '关冰红', null, null, null, '15628802226', '', '', '1', '\"{29949187:92101925723546640}\"', '', '', '$:LWCP_v1:$ALcNm/10uBB+Jn9KER14Bg==', 'Ut6t5iirdiSEGhQANen1GpyQiEiE', '\"{29949187:false}\"', '0', '[29949187]', '', '', '', '', '', '1', null, null, null, '1', '-1', null, null);
INSERT INTO `nd_user` VALUES ('475', '3', 'GyDzpUsaNdApjgJImwcGXAiEiE', null, '1027411628761020', '尹燕', null, null, null, '18653110506', '', '', '1', '\"{29949187:7060243609546052}\"', '', '', '$:LWCP_v1:$FeCFXDEHyBeO7WxbMz/NXg==', 'GyDzpUsaNdApjgJImwcGXAiEiE', '\"{29949187:false}\"', '0', '[29949187]', '', 'http://static.dingtalk.com/media/lADPACOG83euXTfNBNrNBNc_1239_1242.jpg', '', '', '', '5', '1510543797', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('476', '3', '08rb9Y4EiitBW9hqH3ii08ZAiEiE', '1095c418af37f8880d80984130785c90', '036400335223177584', '宋万里', null, null, null, '18363051912', '', 'songwanli@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$qQ2wpbbNcoXJFP0Y+u9H6w==', '08rb9Y4EiitBW9hqH3ii08ZAiEiE', '\"{29949187:false}\"', '0', '[29949187]', '', '', '', '', '[{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":215934241,\"name\":\"\\u53d1\\u6587\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '8', '1510726590', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('477', '2', 'nGHfuqx6UX6iifbN0cFgbDQiEiE', 'a2aa7ee54b40f7575c6fef5bf5aa5447', '075169022121572231', '和希文', null, null, null, '18653112820', '', 'hexiwen@cloudskysec.com', '1', '\"{29872738:267209984997238148}\"', '', '', '$:LWCP_v1:$ci8eN7A58BHN9AOqgR45hg==', 'nGHfuqx6UX6iifbN0cFgbDQiEiE', '\"{29872738:true}\"', '0', '[29872738]', '研发总监', 'http://static.dingtalk.com/media/lADOsD3MZs0Css0CsQ_689_690.jpg', '', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352895,\"name\":\"\\u4e3b\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352910,\"name\":\"\\u90e8\\u95e8\\u603b\\u76d1\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '38', '1512122692', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('478', '3', 'LiPvo5JTodPIiE', null, '2652104026302698', '李江涛', null, null, null, '18660191022', '', 'lijiangtao@cloudskysec.com', '1', '\"{29872739:247505031094236028,45962661:247505031094236028}\"', '', '', '$:LWCP_v1:$155quBAa1828ZvyrN54RCw==', 'LiPvo5JTodPIiE', '\"{29872739:true,45962661:true}\"', '0', '[29872739,45962661]', '技术总监', 'http://static.dingtalk.com/media/lADOvXeeis0CFM0CfA_636_532.jpg', '2652104026', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352910,\"name\":\"\\u90e8\\u95e8\\u603b\\u76d1\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('479', '3', 'sLTettuzdv73SNSxYsPZTAiEiE', null, '074108316724306723', '张洪铭', null, null, null, '13969090363', '', '', '1', '\"{29872740:180345934282888636}\"', '', '', '$:LWCP_v1:$gqFc/8bHLNuNb2LOAb2soA==', 'sLTettuzdv73SNSxYsPZTAiEiE', '\"{29872740:true}\"', '0', '[29872740]', '行政总裁', 'http://static.dingtalk.com/media/lADOmg0lFc0BZs0BZg_358_358.jpg', '', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":173379089,\"name\":\"\\u884c\\u653f\\u603b\\u88c1\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('480', '3', '4Ba7gxHx2jJNoCSiS62ZtBAiEiE', null, '043144291921412583', '周云峰', null, null, null, '13153153151', '', 'zhouyunfeng@cloudskysec.com', '1', '\"{29872741:180296047965129096}\"', '', '', '$:LWCP_v1:$N9iBX+zI+3ZJDHxvtdFWhw==', '4Ba7gxHx2jJNoCSiS62ZtBAiEiE', '\"{29872741:true}\"', '0', '[29872741]', '副总经理', 'http://static.dingtalk.com/media/lADOxA0jks0EZc0EYg_1122_1125.jpg', '0431442919', '[]', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":173181819,\"name\":\"\\u8d22\\u52a1\\u603b\\u88c1\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('481', '3', 'aRJLy8BcqXxW9hqH3ii08ZAiEiE', null, '0402612214776103', '张勇', null, null, null, '18053131000', '', 'zhangyong@cloudskysec.com', '1', '\"{29872742:180345933104040869}\"', '', '', '$:LWCP_v1:$U6etPIk0o3S0m1eDS2BhwA==', 'aRJLy8BcqXxW9hqH3ii08ZAiEiE', '\"{29872742:true}\"', '0', '[29872742]', '副总经理', '', '', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":207050206,\"name\":\"\\u8425\\u9500\\u603b\\u88c1\",\"groupName\":\"\\u5c97\\u4f4d\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('482', '3', '2biSqLfhhPM1W9hqH3ii08ZAiEiE', null, '0161660954843110', '曹政', null, null, null, '15165181871', '', '', '1', '\"{29896209:113885168997231392}\"', '', '', '$:LWCP_v1:$o+FiGDfpru6qFRYMa5V4VA==', '2biSqLfhhPM1W9hqH3ii08ZAiEiE', '\"{29896209:false}\"', '0', '[29896209]', '', 'http://static.dingtalk.com/media/lADOfF3mYs0CVM0CVA_596_596.jpg', '', '', '', '1', null, null, null, '1', '-1', null, null);
INSERT INTO `nd_user` VALUES ('483', '3', 'xm8neYfgwZhcycecNxwEowiEiE', null, '074124573025856707', '方新建', null, null, null, '18953113696', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$fmiKZ2wB8XSLcmqjvYwdww==', 'xm8neYfgwZhcycecNxwEowiEiE', '\"{29896209:false}\"', '0', '[29896209]', '', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('484', '2', 'LDfiSxGlFrds4kfNQOMDHXAiEiE', '55a6385b183c6c28c50702c4deb86545', '0429230734957399984', '夏国栋', null, null, null, '18678753015', '', 'xiaguodong@cloudskysec.com', '1', '\"{29897246:177917621779460521}\"', '', '', '$:LWCP_v1:$MT4NfvJjYQiyUdL9RjPjnQ==', 'LDfiSxGlFrds4kfNQOMDHXAiEiE', '\"{29897246:true}\"', '0', '[29897246]', '研发经理', 'http://static.dingtalk.com/media/lADOqlsmV80BIs0BIg_290_290.jpg', '0429230734', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"}]', '55', '1511785149', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('485', '2', 'SKDyJNbWEBY79d5wM6ur4QiEiE', '13975789ea7b8c8150c5e9f19d520797', '101411205632745955', '胡绍良', null, null, null, '15275411187', '', '', '1', '\"{29897246:4}\"', '', '', '$:LWCP_v1:$MkANDn0zk2+RFHeKzohtmg==', 'SKDyJNbWEBY79d5wM6ur4QiEiE', '\"{29897246:false}\"', '0', '[29897246]', 'PHP开发工程师', 'http://static.dingtalk.com/media/lADPACOG83I1AV3NASvNASs_299_299.jpg', '', '', '', '72', '1516325974', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('486', '3', 'xm8neYfgwZiiMSeIdOsbyygiEiE', null, '074124573338156785', '靳海燕', null, null, null, '15013549774', '', 'jinhaiyan@cloudskysec.com', '1', '\"{29897246:7}\"', '', '', '$:LWCP_v1:$FIIebA/aldeXTC6xHrLBCw==', 'xm8neYfgwZiiMSeIdOsbyygiEiE', '\"{29897246:false}\"', '0', '[29897246]', '高级开发工程师', '', '0741245733', '[]', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('487', '3', '6iShu2RwcgJNW9hqH3ii08ZAiEiE', '9ce9fa4b8d0f2c941b453b2d489059eb', '026561193636805201', '郑迎迎', null, null, null, '15725159501', '', 'zhengyingying@cloudskysec.com', '1', '\"{29897246:6}\"', '', '', '$:LWCP_v1:$jo5XDKxqx1y0GXmbvTvhZw==', '6iShu2RwcgJNW9hqH3ii08ZAiEiE', '\"{29897246:false}\"', '0', '[29897246]', '软件评测师', 'http://static.dingtalk.com/media/lADPACOG807bs-TNArLNArE_689_690.jpg', '12233', '', '', '39', '1510881722', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('488', '3', '2fQtiiEguJMI4kfNQOMDHXAiEiE', '165e2f021a6aa53be327dbc8fd2898d4', '095843032426071278', '李倩倩', null, null, null, '13518633330', '', 'liqianqian@cloudskysec.com', '1', '\"{29897246:5}\"', '', '', '$:LWCP_v1:$Hd8x2FS4Ffoxm4X2NOxPAg==', '2fQtiiEguJMI4kfNQOMDHXAiEiE', '\"{29897246:false}\"', '0', '[29897246]', 'PHP开发工程师', 'http://static.dingtalk.com/media/lADOwqG8zs0Cs80Csw_691_691.jpg', '0123', '', '', '23', '1510707128', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('489', '3', 'xm8neYfgwZiiiifbN0cFgbDQiEiE', null, '074124573120843950', '刘亚峰', null, null, null, '15990991021', '', 'liuyafeng@cloudskysec.com', '1', '\"{29897246:1}\"', '', '', '$:LWCP_v1:$dJTUo/Ot497gulGoGcVKew==', 'xm8neYfgwZiiiifbN0cFgbDQiEiE', '\"{29897246:false}\"', '0', '[29897246]', 'UI设计师', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('490', '3', 'XMAzFiiUEiPfc4kfNQOMDHXAiEiE', '52c42377e015e332546993d9dcc57d35', '100722524426382113', '朱立军', null, null, null, '13774952833', '', 'zhulijun@cloudskysec.com', '1', '\"{29897246:2}\"', '', '', '$:LWCP_v1:$VWL/8ULFsOq08YMDYHmG8w==', 'XMAzFiiUEiPfc4kfNQOMDHXAiEiE', '\"{29897246:false}\"', '0', '[29897246]', 'UI设计师', '', '1007225244', '', '', '4', '1510709918', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('491', '3', 'MjD5IJd2Fd3IXztkpKeVXgiEiE', '196c8608faecab6f1da61be63cdcf3bc', '08661510551175865', '邢涛', null, null, null, '13553181940', '', 'xingtao@cloudskysec.com', '1', '\"{29897246:3}\"', '', '', '$:LWCP_v1:$LkpXOrF8lV+OEVrzpzKvzg==', 'MjD5IJd2Fd3IXztkpKeVXgiEiE', '\"{29897246:false}\"', '0', '[29897246]', '前端开发工程师', '', '0866151055', '', '', '2', '1510727318', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('492', '3', 'HkvkHsSvhOY4kfNQOMDHXAiEiE', null, '074125696423417666', '孙瑞勇', null, null, null, '15169102682', '', 'sunruiyong@cloudskysec.com', '1', '\"{29897246:8}\"', '', '', '$:LWCP_v1:$lEDERZY13Px+i6GFoWxA/g==', 'HkvkHsSvhOY4kfNQOMDHXAiEiE', '\"{43859148:false,29897246:false}\"', '0', '[43859148,29897246]', '系统架构师', 'http://static.dingtalk.com/media/lADOuyiHJs0B5s0B5g_486_486.jpg', '0741256964', '', '', '4', '1510298469', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('493', '3', 'N6iPzbaT6cp3IXztkpKeVXgiEiE', null, '122001225532398736', '胡叶春', null, null, null, '13026587000', '', '', '1', '\"{29899150:87209893721297616}\"', '', '', '$:LWCP_v1:$PsGVtiAdHTVGQjEVsnK1qQ==', 'N6iPzbaT6cp3IXztkpKeVXgiEiE', '\"{29899150:false}\"', '0', '[29899150]', '', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('494', '3', 'lm1WbjD4D39W9hqH3ii08ZAiEiE', null, '011329063126192579', '李彦军', null, null, null, '18053132333', '', 'liyanjun@cloudskysec.com', '1', '\"{29899150:69535448474947312}\"', '', '', '$:LWCP_v1:$pykUGwodtzhVl6Dyv6b+4Q==', 'lm1WbjD4D39W9hqH3ii08ZAiEiE', '\"{29899150:false}\"', '0', '[29899150]', '', 'http://static.dingtalk.com/media/lADPACOG81QVlgTNBNfNBNo_1242_1239.jpg', '0113290631', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('495', '3', 'WBiSmSziSa7WU79d5wM6ur4QiEiE', null, '074126000623177745', '孙可震', null, null, null, '18668966847', '', 'sunkezhen@cloudskysec.com', '1', '\"{29899150:34353526952574004}\"', '', '', '$:LWCP_v1:$74zpPGWYkmVnHS04gPOB8A==', 'WBiSmSziSa7WU79d5wM6ur4QiEiE', '\"{29899150:false}\"', '0', '[29899150]', '', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('496', '3', 'uRVGWus3cZVW9hqH3ii08ZAiEiE', null, '023469320420224244', '伊庭海', null, null, null, '18953115717', '', 'yitinghai@cloudskysec.com', '1', '\"{29899150:7040654808845532}\"', '', '', '$:LWCP_v1:$7t1+14nFsUqrKADGye/pfA==', 'uRVGWus3cZVW9hqH3ii08ZAiEiE', '\"{29899150:false}\"', '0', '[29899150]', '', 'http://static.dingtalk.com/media/lADOvRmSq80CV80CVw_599_599.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('497', '3', 'hETkAXaT3IqhQANen1GpyQiEiE', null, '09164860221043103', '胥令', null, null, null, '15628869230', '', 'xuling@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$wYdgKIbS0HChKNyj1XU5fA==', 'hETkAXaT3IqhQANen1GpyQiEiE', '\"{29899150:false}\"', '0', '[29899150]', '', 'http://static.dingtalk.com/media/lADOwgjqdc0C7s0C7g_750_750.jpg', '0916486022', '[]', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('498', '3', 'XluL3rO4o5hW9hqH3ii08ZAiEiE', null, '30344300782339', '张欣', null, null, null, '18660196829', '', '', '1', '\"{29917155:180345933184603781}\"', '', '', '$:LWCP_v1:$PR1PbMqjo/RniK//7Hl1NA==', 'XluL3rO4o5hW9hqH3ii08ZAiEiE', '\"{29917155:true}\"', '0', '[29917155]', '', 'http://static.dingtalk.com/media/lADOvRb0xM0CVs0CVg_598_598.jpg', '', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('499', '3', 'jLeVXkU5vSpW9hqH3ii08ZAiEiE', '1dbc58da06823b2d0fc9192d48a97318', '3023136035466875', '赵全亮', null, null, null, '17686611338', '', '', '1', '\"{43859148:177917621779460516}\"', '', '', '$:LWCP_v1:$yMQMXBvdRRKTjF1SQ/18PQ==', 'jLeVXkU5vSpW9hqH3ii08ZAiEiE', '\"{43859148:true}\"', '0', '[43859148]', '产品经理，系统分析师', 'http://static.dingtalk.com/media/lADPACOG84DOTCzNA3LNA1E_849_882.jpg', '', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"}]', '12', '1510736647', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('500', '3', 'XHlEW1pzmWKiifbN0cFgbDQiEiE', null, '1208594101690608', '吴坤', null, null, null, '13668826850', '', '', '1', '\"{43859148:2}\"', '', '', '$:LWCP_v1:$2EeqhvXBVDLdZjq6mORIRw==', 'XHlEW1pzmWKiifbN0cFgbDQiEiE', '\"{43859148:false}\"', '0', '[43859148]', '大数据分析师', 'http://static.dingtalk.com/media/lADPAAAAAQhNpHbMyMzI_200_200.jpg', '', '', '', '2', '1510322621', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('501', '3', 'HoS65u3XOMDIXztkpKeVXgiEiE', null, '121535065535571526', '赵广冰', null, null, null, '13869235583', '', '', '1', '\"{43859148:1}\"', '', '', '$:LWCP_v1:$0rgwBtGTn+/s7KamvieVpw==', 'HoS65u3XOMDIXztkpKeVXgiEiE', '\"{43859148:false}\"', '0', '[43859148]', '大数据开发工程师', '', '', '', '', '5', '1510305414', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('502', '3', 'MDtiPpOb7KNKMSeIdOsbyygiEiE', null, '0451422143846306', '李杰', null, null, null, '15562502056', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$nYWVNYujlB/Or2hJGGAPtA==', 'MDtiPpOb7KNKMSeIdOsbyygiEiE', '\"{43859148:false}\"', '0', '[43859148]', '', 'http://static.dingtalk.com/media/lADPACOG81hj2v7NAlPNAlM_595_595.jpg', '', '', '', '1', null, null, null, '1', '-1', null, null);
INSERT INTO `nd_user` VALUES ('503', '3', 'wt2AMbl0DCk4kfNQOMDHXAiEiE', null, '074125693424113971', '张国印', null, null, null, '15966695957', '', '', '1', '\"{44586025:2428312561451959}\"', '', '', '$:LWCP_v1:$Bm4TCO9GiIajJCWv4Yrz2g==', 'wt2AMbl0DCk4kfNQOMDHXAiEiE', '\"{44586025:false}\"', '0', '[44586025]', '', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('504', '3', 'iSb18uoqiiIPJcycecNxwEowiEiE', null, '074223270028138243', '潘孝全', null, null, null, '13853119176', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$KvMm/SmzPbQHCO24rnKi8w==', 'iSb18uoqiiIPJcycecNxwEowiEiE', '\"{44586025:false}\"', '0', '[44586025]', '', '', '', '', '[{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('505', '3', 'iSZebKevf1c5W9hqH3ii08ZAiEiE', null, '022625123129124962', '王善军', null, null, null, '15966695005', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$6fcUULN1uu48btkv5YjzFA==', 'iSZebKevf1c5W9hqH3ii08ZAiEiE', '\"{44586025:false}\"', '0', '[44586025]', '', '', '', '', '[{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('506', '3', 'e3SlndItDHnIXztkpKeVXgiEiE', null, '0743456645661140', '任贵', null, null, null, '15066686358', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$NDYr6Z2r+4KiaYJWWuKufw==', 'e3SlndItDHnIXztkpKeVXgiEiE', '\"{44586025:false}\"', '0', '[44586025]', '', 'http://static.dingtalk.com/media/lADOmPyJXs0CgM0CgA_640_640.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('507', '3', '2XObKiPOno4T3SNSxYsPZTAiEiE', null, '115664096726202182', '杨宇超', null, null, null, '13905312457', '', '', '1', '\"{45943613:186019206062366152,46000565:186019206062366152,45958554:186019206062366152}\"', '', '', '$:LWCP_v1:$dNf5uEKljeUz2085iErNfg==', '2XObKiPOno4T3SNSxYsPZTAiEiE', '\"{45943613:true,45965624:false,45958554:true,46000565:true}\"', '0', '[45943613,46000565,45965624,45958554]', '部门总监', '', '', '', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('508', '3', 'xm8neYfgwZj3SNSxYsPZTAiEiE', '92cb93234b73c45d317e5c63e6a66bef', '0741245737788476', '张茜', null, null, null, '15866785803', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$mVC6JrlzgSg938NjZBK/ag==', 'xm8neYfgwZj3SNSxYsPZTAiEiE', '\"{45952781:false}\"', '0', '[45952781]', '', '', '', '', '', '5', '1510882372', null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('509', '3', 'Ry2biibX2FW2MSeIdOsbyygiEiE', null, '1146411353841523', '杨军', null, null, null, '15562511100', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$SQ+3uQWJDdGqMadB8dWgyA==', 'Ry2biibX2FW2MSeIdOsbyygiEiE', '\"{45958554:false}\"', '0', '[45958554]', '系统运维工程师', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('510', '3', 'iPc5ii5NJ3EJ9W9hqH3ii08ZAiEiE', null, '013227062336025126', '赵靖宇', null, null, null, '18660107074', '', '', '1', '\"{45962661:2428209807231580}\"', '', '', '$:LWCP_v1:$AgKQ8jQzRKbaQ69T7gu7Mg==', 'iPc5ii5NJ3EJ9W9hqH3ii08ZAiEiE', '\"{45962661:false}\"', '0', '[45962661]', '', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('511', '3', 'M5iia9axrg8pW9hqH3ii08ZAiEiE', null, '015911666124114753', '张善营', null, null, null, '13969054662', '', 'zhangshanying@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$4rOZMyEAmgBld9dAbzsX7Q==', 'M5iia9axrg8pW9hqH3ii08ZAiEiE', '\"{45962661:false}\"', '0', '[45962661]', '', 'http://static.dingtalk.com/media/lADO163W1c0CAM0CAA_512_512.jpg', '0159116661', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('512', '3', 'iS2GCQbMvT4k4kfNQOMDHXAiEiE', null, '093057074425985513', '曹伯广', null, null, null, '18660136211', '', 'caoboguang@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$XjwrBZETUdd7VDQHM0AYow==', 'iS2GCQbMvT4k4kfNQOMDHXAiEiE', '\"{45962661:false}\"', '0', '[45962661]', '', 'http://static.dingtalk.com/media/lADOvRgeNs0Cfs0Cfg_638_638.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('513', '3', 'PVHk4iPsjiihyiifbN0cFgbDQiEiE', null, '120310125120365146', '于群杰', null, null, null, '17660416110', '', 'yuqunjie@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$etl8dH9kwaxd28t7M6Bhfg==', 'PVHk4iPsjiihyiifbN0cFgbDQiEiE', '\"{45962661:false}\"', '0', '[45962661]', '', 'http://static.dingtalk.com/media/lADPACOG82SQ30DNBNrNBNc_1239_1242.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('514', '3', 'B2uEhD8oq6pW9hqH3ii08ZAiEiE', null, '3023135732838291', '臧汕倡', null, null, null, '18905415988', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$rQA9xZGZI+k2feDmyhcSCA==', 'B2uEhD8oq6pW9hqH3ii08ZAiEiE', '\"{45962661:false}\"', '0', '[45962661]', '', 'http://static.dingtalk.com/media/lADOvRy7Oc0C7M0C7A_748_748.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('515', '3', 'fxaZhVMPMbFW9hqH3ii08ZAiEiE', null, '023752404139031267', '马群涛', null, null, null, '13953166421', '', 'maquntao@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$UENKyeYlPYm2jwCBiv76ZQ==', 'fxaZhVMPMbFW9hqH3ii08ZAiEiE', '\"{45962661:false}\"', '0', '[45962661]', '', 'http://static.dingtalk.com/media/lADOvRV9eM0C7M0C7A_748_748.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('516', '3', '8KzUREZR0tpW9hqH3ii08ZAiEiE', null, '020863005420869388', '刘军振', null, null, null, '18265973297', '', 'liujunzhen@cloudskysec.com', '1', '\"{}\"', '', '', '$:LWCP_v1:$OFZtJa4nOsTTolXfXM+4kw==', '8KzUREZR0tpW9hqH3ii08ZAiEiE', '\"{45962661:false}\"', '0', '[45962661]', '', 'http://static.dingtalk.com/media/lADOvipjYs0BC80BCw_267_267.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('517', '3', 'eZlmiSghoSwmiifbN0cFgbDQiEiE', null, '104000244121992925', '周雪生', null, null, null, '18954185121', '', '', '1', '\"{45965624:2378428767600168}\"', '', '', '$:LWCP_v1:$/avPGp+Lf06obsAG2RNkNg==', 'eZlmiSghoSwmiifbN0cFgbDQiEiE', '\"{45965624:false}\"', '0', '[45965624]', '', '', '001', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('518', '3', 'AEq4P71lWU5NoCSiS62ZtBAiEiE', null, '096143246924195572', '崔鹏鹏', null, null, null, '13181727677', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$k1bPLSlIFnh1V7VUoqvWTA==', 'AEq4P71lWU5NoCSiS62ZtBAiEiE', '\"{46000565:false}\"', '0', '[46000565]', '坐席主管', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('519', '3', 'XDvAXpfgOtQpjgJImwcGXAiEiE', null, '0825570958779402', '徐刚', null, null, null, '18653121950', '', 'xugang@cloudskysec.com', '1', '\"{46007601:188253741736076516}\"', '', '', '$:LWCP_v1:$Ix96IglmFYyGCeUJogeQxg==', 'XDvAXpfgOtQpjgJImwcGXAiEiE', '\"{46007601:true}\"', '0', '[46007601]', '', 'http://static.dingtalk.com/media/lADOwBXxJ80CgM0CgA_640_640.jpg', '0825570958', '[]', '[{\"id\":150352898,\"name\":\"\\u4e3b\\u7ba1\",\"groupName\":\"\\u9ed8\\u8ba4\"},{\"id\":150352896,\"name\":\"\\u5b50\\u7ba1\\u7406\\u5458\",\"groupName\":\"\\u9ed8\\u8ba4\"}]', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('520', '3', 'Pun51uHHsZqhQANen1GpyQiEiE', null, '06156662421177648', '辛鑫', null, null, null, '17686842961', '', '', '1', '\"{46007601:11868902388029764}\"', '', '', '$:LWCP_v1:$Y44i69M/iE4muMsOOWnZfA==', 'Pun51uHHsZqhQANen1GpyQiEiE', '\"{46007601:false}\"', '0', '[46007601]', '', 'http://static.dingtalk.com/media/lADOm5NUL80C7s0C7A_748_750.jpg', '', '', '', '1', null, null, null, '1', '-1', null, null);
INSERT INTO `nd_user` VALUES ('521', '3', 'hTAfCXNwfSr3SNSxYsPZTAiEiE', null, '123618072720218770', '伊廷伟', null, null, null, '17862936176', '', '', '1', '\"{46007601:7040654780530505}\"', '', '', '$:LWCP_v1:$uI7N0cno8api0saXgU9k3w==', 'hTAfCXNwfSr3SNSxYsPZTAiEiE', '\"{46007601:false}\"', '0', '[46007601]', '', '', '132', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('522', '3', 'zBrZPdIE6GDIXztkpKeVXgiEiE', null, '130314445524189492', '张志栋', null, null, null, '15865295337', '', '', '1', '\"{46007601:2428311268613314}\"', '', '', '$:LWCP_v1:$CMB8KIBBn+RhggNPCUCJ3Q==', 'zBrZPdIE6GDIXztkpKeVXgiEiE', '\"{46007601:false}\"', '0', '[46007601]', '', '', '11', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('523', '3', 'UT9F5nRZDxVNoCSiS62ZtBAiEiE', null, '045713126924441267', '张翠平', null, null, null, '13806408300', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$RNjgIu2xYpBHmmcBJo5bew==', 'UT9F5nRZDxVNoCSiS62ZtBAiEiE', '\"{46007601:false}\"', '0', '[46007601]', '', 'http://static.dingtalk.com/media/lADOvROC9s0CV80CVw_599_599.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('524', '3', 'O1lA1c4WgkGiifbN0cFgbDQiEiE', null, '085167426124149740', '张子夜', null, null, null, '13808925322', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$3MkrMcaQEPHb13j/FlPGWg==', 'O1lA1c4WgkGiifbN0cFgbDQiEiE', '\"{46007601:false}\"', '0', '[46007601]', '', 'http://static.dingtalk.com/media/lADPACOG81UEZR3MyMzI_200_200.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('525', '3', 'UXbmh8gp9N6iifbN0cFgbDQiEiE', null, '101002581126484233', '李艳虎', null, null, null, '17615847223', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$tHoqTl1tPkmacHJjBFRncw==', 'UXbmh8gp9N6iifbN0cFgbDQiEiE', '\"{46007601:false}\"', '0', '[46007601]', '', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('526', '3', 'qRqAIQ1LhHL3SNSxYsPZTAiEiE', null, '101039631730711237', '程凤连', null, null, null, '18766191091', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$l/oWprg7jLebJstjufkhjg==', 'qRqAIQ1LhHL3SNSxYsPZTAiEiE', '\"{46007601:false}\"', '0', '[46007601]', '', '', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('527', '3', 's51K3lXK7SAiE', null, '2529293029412748', '王禹博', null, null, null, '15662662598', '', '', '1', '\"{46008595:17718753029226292}\"', '', '', '$:LWCP_v1:$DaT5ao3t3jMoXUYKyPjO0A==', 's51K3lXK7SAiE', '\"{46008595:false}\"', '0', '[46008595]', '', 'http://static.dingtalk.com/media/lADPACOG83QQx4DNAu7NAuw_748_750.jpg', '', '', '', '1', null, null, null, '1', null, null, null);
INSERT INTO `nd_user` VALUES ('528', '3', null, null, '131627582838836013', '马李敏', null, null, null, '13361021660', '', '', '1', '\"{29897247:65811463446355648}\"', '', '', '$:LWCP_v1:$drPRGGXW8icpI6ZPpS+nmQ==', 'IWAAZDzL8o0pjgJImwcGXAiEiE', '\"{29897247:false}\"', null, '[29897247]', '', 'http://static.dingtalk.com/media/lADPACOG83vuxu3NAu7NAuw_748_750.jpg', '', '', '', '1', '1504140574', null, '0', '1', '1', '1504140574', null);
INSERT INTO `nd_user` VALUES ('529', '3', null, null, '0336046820772632', '康凯', null, null, null, '15668495868', '', '', '1', '\"{46008595:75421802791613024}\"', '', '', '$:LWCP_v1:$x2j5FDvEHxvjEOFBKb78UQ==', 'JxLzY1mNucxW9hqH3ii08ZAiEiE', '\"{46008595:false}\"', null, '[46008595]', '', '', '', '', '', '1', '1504140624', null, '0', '1', '-1', '1504140624', null);
INSERT INTO `nd_user` VALUES ('530', '3', null, null, '114433381623129233', '孙仲琪', null, null, null, '13325140291', '', '', '1', '\"{45965624:34352096028671560}\"', '', '', '$:LWCP_v1:$JXKcxGGZXNyENx3Xp5t1hg==', 'FiS3raE2nFdY79d5wM6ur4QiEiE', '\"{45965624:false}\"', null, '[45965624]', '', 'http://static.dingtalk.com/media/lADPACOG82Gx2nLNAtTNAtQ_724_724.jpg', '', '', '', '1', '1504228096', null, '0', '1', '-1', '1504228096', null);
INSERT INTO `nd_user` VALUES ('531', '3', null, null, '132121026724240000', '张有义', null, null, null, '15098848643', '', '', '1', '\"{45965624:2428311324201769}\"', '', '', '$:LWCP_v1:$tLBPMfdftMxGwjTKs1A31g==', 'YxaFYsU9Jwn3SNSxYsPZTAiEiE', '\"{45965624:false}\"', null, '[45965624]', '', '', '', '', '', '1', '1504487332', null, '0', '1', '1', '1504487332', null);
INSERT INTO `nd_user` VALUES ('532', '3', null, null, '052228212029095270', '王兴宏', null, null, null, '15610153053', '', '', '1', '\"{45965624:17718756405020540}\"', '', '', '$:LWCP_v1:$2M+1ERjOduVqe+ECQQEoBQ==', 'qV1RIxpmxPZcycecNxwEowiEiE', '\"{45965624:false}\"', null, '[45965624]', '', '', '', '', '', '1', '1504775440', null, '0', '1', '1', '1504775440', null);
INSERT INTO `nd_user` VALUES ('533', '3', null, null, '0315520424837446', '曹伟', null, null, null, '15054137177', '', '', '1', '\"{29895193:113885461189213840}\"', '', '', '$:LWCP_v1:$t9ETP5ggx02wl9Slolbong==', 'p5ZzZWwATX1W9hqH3ii08ZAiEiE', '\"{29895193:false}\"', null, '[29895193]', '', '', '', '', '', '1', '1505265497', null, '0', '1', '1', '1505265497', null);
INSERT INTO `nd_user` VALUES ('534', '3', null, '1', '0104090124882491', '沈勃', null, null, null, '13210228517', '', '', '1', '\"{}\"', '', '', '$:LWCP_v1:$MMxPyRKUz4eED8OnubDFkw==', 'ZiiS520vW3llW9hqH3ii08ZAiEiE', '\"{46007601:false}\"', null, '[46007601]', '', '', '', '', '', '1', '1505716068', null, '0', '1', '1', '1505716068', null);

-- ----------------------------
-- Table structure for nd_user_dept_rights
-- ----------------------------
DROP TABLE IF EXISTS `nd_user_dept_rights`;
CREATE TABLE `nd_user_dept_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `deptid` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL COMMENT '按钮操作的id（1：移动；2：删除；3：审核）',
  `status` int(11) DEFAULT NULL,
  `addip` varchar(20) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `ding_userid` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nd_user_dept_rights
-- ----------------------------
INSERT INTO `nd_user_dept_rights` VALUES ('173', null, '29897246', '1', '1', null, '1512022288', '101411205632745955');
INSERT INTO `nd_user_dept_rights` VALUES ('174', null, '29897246', '2', '1', null, '1512022288', '101411205632745955');
INSERT INTO `nd_user_dept_rights` VALUES ('175', null, '29897246', '3', '1', null, '1512022288', '101411205632745955');
INSERT INTO `nd_user_dept_rights` VALUES ('176', null, '29897246', '4', '1', null, '1512022288', '101411205632745955');
INSERT INTO `nd_user_dept_rights` VALUES ('177', null, '29897246', '5', '1', null, '1512022288', '101411205632745955');
INSERT INTO `nd_user_dept_rights` VALUES ('178', null, '29897246', '6', '1', null, '1512022288', '101411205632745955');
INSERT INTO `nd_user_dept_rights` VALUES ('179', null, '29872738', '1', '1', null, '1512122729', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('180', null, '29872738', '2', '1', null, '1512122729', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('181', null, '29872738', '3', '1', null, '1512122729', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('182', null, '29872738', '4', '1', null, '1512122729', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('183', null, '29872738', '5', '1', null, '1512122729', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('184', null, '29872738', '6', '1', null, '1512122729', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('191', null, '29897246', '1', '1', null, '1512122788', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('192', null, '29897246', '2', '1', null, '1512122788', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('193', null, '29897246', '3', '1', null, '1512122788', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('194', null, '29897246', '4', '1', null, '1512122788', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('195', null, '29897246', '5', '1', null, '1512122788', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('196', null, '29897246', '6', '1', null, '1512122788', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('197', null, '43859148', '1', '1', null, '1512122805', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('198', null, '43859148', '2', '1', null, '1512122805', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('199', null, '43859148', '3', '1', null, '1512122805', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('200', null, '43859148', '4', '1', null, '1512122805', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('201', null, '43859148', '5', '1', null, '1512122805', '075169022121572231');
INSERT INTO `nd_user_dept_rights` VALUES ('202', null, '43859148', '6', '1', null, '1512122805', '075169022121572231');
