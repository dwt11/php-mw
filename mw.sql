/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1_3306
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : 127.0.0.1:3306
 Source Schema         : mw

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 27/10/2020 15:57:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dede_archives
-- ----------------------------
DROP TABLE IF EXISTS `dede_archives`;
CREATE TABLE `dede_archives`  (
  `id` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `typeid` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目ID',
  `sortrank` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序内容 保存置顶时间加发布的时间',
  `flag` set('c','h','p','b') CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL COMMENT '自定义属性值 头条[h]推荐[c]幻灯[f]特荐[a]滚动[s]加粗[b]图片[p]跳转',
  `issend` smallint(6) NOT NULL DEFAULT 0 COMMENT '是否审核,0无需审核或审核通过，1需要待审核，-1审核不通过，-2删除后到回收站',
  `channelid` smallint(6) NOT NULL DEFAULT 1,
  `deptype` int(10) NOT NULL DEFAULT 0 COMMENT '可以浏览的部门，0:无需登录全部可浏览，-1全员可浏览但需要登录，多个部门的话 分隔查询（除0外都要记录浏览人员的ID）',
  `click` mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击数',
  `title` char(60) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `color` char(7) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '' COMMENT '颜色',
  `senddate` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发布时间',
  `userid` mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发布者',
  `ispost` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论选项（0：不许评论,1可以评论）',
  `userhistory` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL COMMENT '与grouptype关联的 记录浏览人员的ID',
  `litpic` char(100) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sortrank`(`sortrank`) USING BTREE,
  INDEX `mainindex`(`deptype`, `typeid`, `channelid`, `flag`, `userid`) USING BTREE,
  INDEX `lastpost`(`ispost`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_archives
-- ----------------------------

-- ----------------------------
-- Table structure for dede_archives_addonarticle
-- ----------------------------
DROP TABLE IF EXISTS `dede_archives_addonarticle`;
CREATE TABLE `dede_archives_addonarticle`  (
  `aid` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `typeid` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目ID',
  `body` mediumtext CHARACTER SET gbk COLLATE gbk_chinese_ci NULL COMMENT '内容',
  PRIMARY KEY (`aid`) USING BTREE,
  INDEX `typeid`(`typeid`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_archives_addonarticle
-- ----------------------------

-- ----------------------------
-- Table structure for dede_archives_arcatt
-- ----------------------------
DROP TABLE IF EXISTS `dede_archives_arcatt`;
CREATE TABLE `dede_archives_arcatt`  (
  `sortid` smallint(6) NOT NULL DEFAULT 0,
  `att` char(10) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `attname` char(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`att`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dede_archives_arcatt
-- ----------------------------
INSERT INTO `dede_archives_arcatt` VALUES (1, 'h', '头条');
INSERT INTO `dede_archives_arcatt` VALUES (2, 'c', '推荐');
INSERT INTO `dede_archives_arcatt` VALUES (4, 'p', '图片');
INSERT INTO `dede_archives_arcatt` VALUES (3, 'b', '加粗');

-- ----------------------------
-- Table structure for dede_archives_arctiny
-- ----------------------------
DROP TABLE IF EXISTS `dede_archives_arctiny`;
CREATE TABLE `dede_archives_arctiny`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `typeid` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目ID',
  `issend` varchar(6) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '0' COMMENT '是否审核,0无需审核或审核通过，1需要待审核，-1审核不通过，-2删除后到回收站',
  `channelid` smallint(5) NOT NULL DEFAULT 1 COMMENT '内容模型',
  `senddate` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发布日期',
  `sortrank` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  `userid` mediumint(8) UNSIGNED NOT NULL COMMENT '发布人ID',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sortrank`(`sortrank`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 780 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_archives_arctiny
-- ----------------------------

-- ----------------------------
-- Table structure for dede_archives_channeltype
-- ----------------------------
DROP TABLE IF EXISTS `dede_archives_channeltype`;
CREATE TABLE `dede_archives_channeltype`  (
  `id` smallint(6) NOT NULL DEFAULT 0,
  `nid` varchar(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `typename` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `maintable` varchar(50) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT 'dede_archives',
  `addtable` varchar(50) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `addcon` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `mancon` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `editcon` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `useraddcon` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `usermancon` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `usereditcon` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `fieldset` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL,
  `listfields` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL,
  `allfields` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL,
  `issystem` smallint(6) NOT NULL DEFAULT 0,
  `isshow` smallint(6) NOT NULL DEFAULT 1,
  `issend` smallint(6) NOT NULL DEFAULT 0,
  `arcsta` smallint(6) NOT NULL DEFAULT -1,
  `usertype` char(10) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `sendrank` smallint(6) NOT NULL DEFAULT 10,
  `isdefault` smallint(6) NOT NULL DEFAULT 0,
  `needdes` tinyint(1) NOT NULL DEFAULT 1,
  `needpic` tinyint(1) NOT NULL DEFAULT 1,
  `titlename` varchar(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '标题',
  `onlyone` smallint(6) NOT NULL DEFAULT 0,
  `dfcid` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `nid`(`nid`, `isshow`, `arcsta`, `sendrank`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_archives_channeltype
-- ----------------------------
INSERT INTO `dede_archives_channeltype` VALUES (1, 'article', '普通文章', 'dede_archives', 'dede_archives_addonarticle', 'article_add.php', 'content_list.php', 'article_edit.php', 'article_add.php', 'content_list.php', 'article_edit.php', '<field:body itemname=\"文章内容\" autofield=\"0\" notsend=\"0\" type=\"htmltext\" isnull=\"true\" islist=\"1\" default=\"\"  maxlength=\"\" page=\"split\">	\n</field:body>	\n', '', '', 1, 1, 1, -1, '', 10, 0, 1, 1, '标题', 0, 0);

-- ----------------------------
-- Table structure for dede_archives_type
-- ----------------------------
DROP TABLE IF EXISTS `dede_archives_type`;
CREATE TABLE `dede_archives_type`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reid` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级栏目',
  `topid` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '顶级栏目',
  `sortrank` smallint(5) UNSIGNED NOT NULL DEFAULT 50 COMMENT '栏目排序',
  `typename` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '' COMMENT '栏目名',
  `issend` smallint(6) NOT NULL DEFAULT 0 COMMENT '是否审核（0：不审核；1：审核）',
  `channeltype` smallint(6) NULL DEFAULT 1 COMMENT '所属频道ID',
  `ispart` smallint(6) NOT NULL DEFAULT 0 COMMENT '栏目属性（0：最终列表栏目；1：频道封面；）',
  `tempindex` varchar(50) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '' COMMENT '封面模板',
  `templist` varchar(50) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '' COMMENT '列表模板',
  `temparticle` varchar(50) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '' COMMENT '内容模板',
  `modname` varchar(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `ishidden` smallint(6) NOT NULL DEFAULT 0 COMMENT '是否隐藏栏目（0：显示  1:显示）',
  `content` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL COMMENT '介绍内容',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `reid`(`reid`, `channeltype`, `ispart`, `topid`, `ishidden`) USING BTREE,
  INDEX `sortrank`(`sortrank`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_archives_type
-- ----------------------------

-- ----------------------------
-- Table structure for dede_checkin
-- ----------------------------
DROP TABLE IF EXISTS `dede_checkin`;
CREATE TABLE `dede_checkin`  (
  `kq_id` int(11) NOT NULL AUTO_INCREMENT,
  `kq_empid` int(11) NULL DEFAULT NULL COMMENT '本系统的员工ID 自增加',
  `kq_hw_CARDID` int(11) NULL DEFAULT NULL COMMENT '导入的汉王考勤的ID(自增加)，用于判断是否已经导入记录',
  `kq_hw_emptime` datetime NULL DEFAULT NULL COMMENT '导入的员工考勤时间',
  `kq_hw_devname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '导入的汉王的设备名称',
  `kq_hw_devip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '导入的汉王的设备IP',
  `kq_hw_empid` int(11) NULL DEFAULT NULL COMMENT '导入的汉王的员工id---这个应该没有用',
  `kq_hw_empname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '导入的员工姓名',
  `kq_hw_empcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '导入的汉王的员工编号',
  `kq_markdate` datetime NULL DEFAULT NULL,
  `kq_integralid` int(11) NULL DEFAULT 0 COMMENT '考勤如果迟到早退，则手动记入积分，这里保存积分的ID。如果有ID则表示已经记入积分',
  `kq_salaryid` int(11) NULL DEFAULT 0 COMMENT '考勤如果迟到早退，则手动记入工资，这里保存考勤的ID。如果有ID则表示已经记入工资',
  `kq_czy` int(11) NULL DEFAULT NULL COMMENT '操作员',
  `kq_zt` int(11) NULL DEFAULT NULL COMMENT '考勤状态：0为导入后 未确认状态 100为正常 。1一级迟到 2二级迟到 3三级迟到  11一级早退 12二级早退 13三级早退  21 旷工半天 22旷工一天',
  PRIMARY KEY (`kq_id`) USING BTREE,
  UNIQUE INDEX `IDX_checkin_UNIQUE`(`kq_hw_emptime`, `kq_hw_CARDID`, `kq_hw_devip`) USING BTREE,
  INDEX `IDX_checkin_CARDTIME`(`kq_hw_emptime`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 136410 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_checkin
-- ----------------------------

-- ----------------------------
-- Table structure for dede_checkin_config
-- ----------------------------
DROP TABLE IF EXISTS `dede_checkin_config`;
CREATE TABLE `dede_checkin_config`  (
  `id` int(11) NOT NULL,
  `yjcd` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为一级迟到',
  `ejcd` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为二级迟到',
  `sjcd` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为三级迟到',
  `yjzt` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为一级早退',
  `ejzt` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为二级早退',
  `sjzt` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为三级早退',
  `kgbt` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为旷工半天',
  `kgyt` int(11) NULL DEFAULT NULL COMMENT '超过多少分钟为旷工一天',
  `djorxj` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '冬季还是夏季时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_checkin_config
-- ----------------------------
INSERT INTO `dede_checkin_config` VALUES (1, 5, 10, 15, 5, 10, 15, 0, 0, '冬季');

-- ----------------------------
-- Table structure for dede_emp
-- ----------------------------
DROP TABLE IF EXISTS `dede_emp`;
CREATE TABLE `dede_emp`  (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_code` int(11) NULL DEFAULT NULL COMMENT '员工编号',
  `emp_realname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `emp_sfz` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '身份证',
  `emp_csdate` datetime NULL DEFAULT NULL COMMENT '出生日期',
  `emp_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `emp_sex` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '性别',
  `emp_ste` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '状态 离职 在职',
  `emp_rzdate` datetime NULL DEFAULT NULL COMMENT '入职日期',
  `emp_lzdate` datetime NULL DEFAULT NULL COMMENT '离职日期',
  `emp_update` datetime NULL DEFAULT NULL COMMENT '最后更新日期',
  `emp_csxl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '初始学历',
  `emp_dqxl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '当前学历',
  `emp_dep` int(11) NULL DEFAULT NULL,
  `emp_worktype` int(11) NULL DEFAULT NULL,
  `emp_integralA` double(5, 2) NULL DEFAULT NULL,
  `emp_integralB` double(8, 2) NULL DEFAULT NULL COMMENT '当前积分B',
  `emp_integralC` double(8, 2) NULL DEFAULT NULL COMMENT '当前积分C',
  `emp_isdel` int(255) NULL DEFAULT NULL COMMENT '是否删除1为删除 0为正常',
  `emp_photo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '照片',
  `emp_hy` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '婚姻',
  `emp_add` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '住址',
  `emp_bb` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '班别：常白班/倒班',
  `emp_bx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '保险',
  PRIMARY KEY (`emp_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 648 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_emp
-- ----------------------------

-- ----------------------------
-- Table structure for dede_emp_dep
-- ----------------------------
DROP TABLE IF EXISTS `dede_emp_dep`;
CREATE TABLE `dede_emp_dep`  (
  `dep_id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dep_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dep_topid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`dep_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_emp_dep
-- ----------------------------
INSERT INTO `dede_emp_dep` VALUES (1, '生产车间', NULL, 0);
INSERT INTO `dede_emp_dep` VALUES (2, '后勤处', NULL, 0);
INSERT INTO `dede_emp_dep` VALUES (3, '杂工组', NULL, 0);
INSERT INTO `dede_emp_dep` VALUES (4, '库房', NULL, 0);
INSERT INTO `dede_emp_dep` VALUES (5, '锅炉', NULL, 0);
INSERT INTO `dede_emp_dep` VALUES (6, '电工', NULL, 0);
INSERT INTO `dede_emp_dep` VALUES (7, '维修', NULL, 0);
INSERT INTO `dede_emp_dep` VALUES (8, '设备', '666', 0);
INSERT INTO `dede_emp_dep` VALUES (9, '蒸馍', '', 1);
INSERT INTO `dede_emp_dep` VALUES (10, '包装', NULL, 1);
INSERT INTO `dede_emp_dep` VALUES (11, '烤馍', NULL, 1);
INSERT INTO `dede_emp_dep` VALUES (12, '监控员', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (13, '司机', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (14, '销售办', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (15, '卫生组', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (16, '灶房', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (17, '程序运转中心', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (18, '综合办', '', 2);
INSERT INTO `dede_emp_dep` VALUES (19, '财务办', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (20, '门卫', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (21, '化验员', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (22, '送货员', NULL, 2);
INSERT INTO `dede_emp_dep` VALUES (23, '俊田组', NULL, 9);
INSERT INTO `dede_emp_dep` VALUES (24, '王波组', NULL, 9);
INSERT INTO `dede_emp_dep` VALUES (25, '金凤组', NULL, 10);
INSERT INTO `dede_emp_dep` VALUES (27, '小龙组', NULL, 9);
INSERT INTO `dede_emp_dep` VALUES (28, '美霞组', NULL, 11);
INSERT INTO `dede_emp_dep` VALUES (29, '翠玲组', NULL, 11);
INSERT INTO `dede_emp_dep` VALUES (30, '亚丽组', NULL, 11);
INSERT INTO `dede_emp_dep` VALUES (31, '爱换组', NULL, 10);
INSERT INTO `dede_emp_dep` VALUES (32, '翠红组', NULL, 10);
INSERT INTO `dede_emp_dep` VALUES (33, '材料库', NULL, 4);
INSERT INTO `dede_emp_dep` VALUES (34, '原料库', NULL, 4);
INSERT INTO `dede_emp_dep` VALUES (35, '成品库', NULL, 6);
INSERT INTO `dede_emp_dep` VALUES (36, '杂物库', '', 4);
INSERT INTO `dede_emp_dep` VALUES (37, '成品库', '', 4);
INSERT INTO `dede_emp_dep` VALUES (38, '质检员', '', 1);
INSERT INTO `dede_emp_dep` VALUES (39, '主管', '', 38);
INSERT INTO `dede_emp_dep` VALUES (40, '员工', '', 38);
INSERT INTO `dede_emp_dep` VALUES (41, '生产主管', '', 1);
INSERT INTO `dede_emp_dep` VALUES (42, '车间主任', '', 0);
INSERT INTO `dede_emp_dep` VALUES (43, '申亚斌', '', 41);
INSERT INTO `dede_emp_dep` VALUES (44, '王叶亮', '', 41);
INSERT INTO `dede_emp_dep` VALUES (45, '秦为忠', '', 41);
INSERT INTO `dede_emp_dep` VALUES (46, '验馍员', '', 1);
INSERT INTO `dede_emp_dep` VALUES (47, '验馍员', '', 0);
INSERT INTO `dede_emp_dep` VALUES (48, '安检员', '', 0);

-- ----------------------------
-- Table structure for dede_emp_worktype
-- ----------------------------
DROP TABLE IF EXISTS `dede_emp_worktype`;
CREATE TABLE `dede_emp_worktype`  (
  `worktype_id` int(11) NOT NULL AUTO_INCREMENT,
  `worktype_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `worktype_info` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `worktype_topid` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`worktype_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_emp_worktype
-- ----------------------------
INSERT INTO `dede_emp_worktype` VALUES (1, '生产类', '生产类', 0);
INSERT INTO `dede_emp_worktype` VALUES (2, '后勤类', '后勤类', 0);
INSERT INTO `dede_emp_worktype` VALUES (3, '库房类', '库房类', 0);
INSERT INTO `dede_emp_worktype` VALUES (4, '维修类', '维修类', 0);
INSERT INTO `dede_emp_worktype` VALUES (5, '主管', '主管', 1);
INSERT INTO `dede_emp_worktype` VALUES (6, '员工', '员工', 1);
INSERT INTO `dede_emp_worktype` VALUES (7, '组长', '组长', 1);
INSERT INTO `dede_emp_worktype` VALUES (8, '安检员', '安检员', 1);
INSERT INTO `dede_emp_worktype` VALUES (9, '质检员', '质检员', 1);
INSERT INTO `dede_emp_worktype` VALUES (10, '验馍员', '验馍员', 1);
INSERT INTO `dede_emp_worktype` VALUES (11, '车间主任', '车间主任', 1);
INSERT INTO `dede_emp_worktype` VALUES (12, '主管', '主管', 4);
INSERT INTO `dede_emp_worktype` VALUES (13, '员工', '员工', 2);
INSERT INTO `dede_emp_worktype` VALUES (14, '员工', '员工', 3);
INSERT INTO `dede_emp_worktype` VALUES (15, '其他', '杂工 锅炉等', 0);
INSERT INTO `dede_emp_worktype` VALUES (16, '员工', '员工', 15);
INSERT INTO `dede_emp_worktype` VALUES (17, '44', '44', 0);
INSERT INTO `dede_emp_worktype` VALUES (18, '主管', '', 0);
INSERT INTO `dede_emp_worktype` VALUES (20, '主管', '', 2);

-- ----------------------------
-- Table structure for dede_integral
-- ----------------------------
DROP TABLE IF EXISTS `dede_integral`;
CREATE TABLE `dede_integral`  (
  `integral_id` int(11) NOT NULL AUTO_INCREMENT,
  `integral_empid` int(11) NULL DEFAULT NULL COMMENT '员工id',
  `integral_date` datetime NULL DEFAULT NULL COMMENT '积分日期或月份',
  `integral_gzid` int(11) NULL DEFAULT NULL COMMENT '适用规则',
  `integral_class` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '积分类型',
  `integral_aors` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '积分增或减',
  `integral_fz` double(5, 2) NULL DEFAULT NULL COMMENT '分值',
  `integral_bz` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注说明',
  `integral_markdate` datetime NULL DEFAULT NULL COMMENT '生成日期',
  `integral_czy` int(11) NULL DEFAULT NULL COMMENT '操作员',
  PRIMARY KEY (`integral_id`) USING BTREE,
  INDEX `integral_empid`(`integral_empid`, `integral_date`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7154 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_integral
-- ----------------------------

-- ----------------------------
-- Table structure for dede_integral_checkinconfig
-- ----------------------------
DROP TABLE IF EXISTS `dede_integral_checkinconfig`;
CREATE TABLE `dede_integral_checkinconfig`  (
  `id` int(11) NOT NULL,
  `yjcd` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为一级迟到',
  `ejcd` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为二级迟到',
  `sjcd` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为三级迟到',
  `yjzt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为一级早退',
  `ejzt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为二级早退',
  `sjzt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为三级早退',
  `kgbt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为旷工半天',
  `kgyt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为旷工一天',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dede_integral_checkinconfig
-- ----------------------------
INSERT INTO `dede_integral_checkinconfig` VALUES (1, 1.00, 2.00, 3.00, 1.00, 2.00, 3.00, 0.00, 0.00);
INSERT INTO `dede_integral_checkinconfig` VALUES (2, 1.00, 2.00, 3.00, 1.00, 2.00, 3.00, 0.00, 0.00);
INSERT INTO `dede_integral_checkinconfig` VALUES (3, 1.00, 2.00, 3.00, 1.00, 2.00, 3.00, 0.00, 0.00);
INSERT INTO `dede_integral_checkinconfig` VALUES (4, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);
INSERT INTO `dede_integral_checkinconfig` VALUES (5, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);
INSERT INTO `dede_integral_checkinconfig` VALUES (6, 55.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);
INSERT INTO `dede_integral_checkinconfig` VALUES (7, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);
INSERT INTO `dede_integral_checkinconfig` VALUES (8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `dede_integral_checkinconfig` VALUES (9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for dede_integral_guizhe
-- ----------------------------
DROP TABLE IF EXISTS `dede_integral_guizhe`;
CREATE TABLE `dede_integral_guizhe`  (
  `gz_id` int(11) NOT NULL AUTO_INCREMENT,
  `gz_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名称',
  `gz_ms` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '描述 ',
  `gz_class` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '父分类ID',
  `gz_aors` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '加还是减',
  `gz_fz` double(10, 2) NULL DEFAULT NULL COMMENT '分值',
  PRIMARY KEY (`gz_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 44 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_integral_guizhe
-- ----------------------------
INSERT INTO `dede_integral_guizhe` VALUES (31, '员工出勤8小时', '基础奖分（出勤分）', 'b', 'add', 8.00);
INSERT INTO `dede_integral_guizhe` VALUES (32, '组长出勤8小时', '基础奖分（出勤分）', 'b', 'add', 16.00);
INSERT INTO `dede_integral_guizhe` VALUES (33, '车间主任出勤8小时', '基础奖分（出勤分）', 'b', 'add', 24.00);
INSERT INTO `dede_integral_guizhe` VALUES (34, '组长出勤12小时', '基础奖分（出勤分）', 'b', 'add', 32.00);
INSERT INTO `dede_integral_guizhe` VALUES (35, '员工出勤12小时', '基础奖分（出勤分）', 'b', 'add', 16.00);
INSERT INTO `dede_integral_guizhe` VALUES (36, '车间主任出勤12小时', '基础奖分（出勤分）', 'b', 'add', 48.00);
INSERT INTO `dede_integral_guizhe` VALUES (38, '1', '迟到扣分', 'b', 'sub', 5.00);
INSERT INTO `dede_integral_guizhe` VALUES (39, '1', '口罩', 'b', 'sub', 5.00);
INSERT INTO `dede_integral_guizhe` VALUES (42, '2323232', '23232', 'a', 'add', 32.00);
INSERT INTO `dede_integral_guizhe` VALUES (43, '444', '444', 'f', 'add', 444.00);

-- ----------------------------
-- Table structure for dede_salary
-- ----------------------------
DROP TABLE IF EXISTS `dede_salary`;
CREATE TABLE `dede_salary`  (
  `salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_empid` int(11) NULL DEFAULT NULL COMMENT '员工编号',
  `salary_yf` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '月份',
  `salary_jb` double(5, 2) NULL DEFAULT 0.00 COMMENT '基本工资',
  `salary_jbsm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '基本工资说明',
  `salary_jj` double(5, 2) NULL DEFAULT 0.00 COMMENT '资金',
  `salary_jjsm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '资金说明',
  `salary_hs` double NULL DEFAULT 0 COMMENT '伙食',
  `salary_hssm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '伙食说明',
  `salary_kq` double(5, 2) NULL DEFAULT 0.00 COMMENT '考勤',
  `salary_kqsm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '考勤说明',
  `salary_qtsub` double(5, 2) NULL DEFAULT 0.00 COMMENT '其它减项',
  `salary_qtsubsm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '减项说明',
  `salary_qtadd` double(5, 2) NULL DEFAULT 0.00 COMMENT '其它增加',
  `salary_qtaddsm` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '增加说明 ',
  `salary_czy` int(11) NULL DEFAULT NULL COMMENT '操作员',
  `salary_markdate` datetime NULL DEFAULT NULL COMMENT '生成日期',
  `salary_lqdate` datetime NULL DEFAULT NULL COMMENT '领取日期',
  `salary_lqname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '领取人',
  `salary_yfmoney` double NULL DEFAULT NULL COMMENT '应发金额',
  `salary_sf` double NULL DEFAULT NULL COMMENT '实发金额 ',
  PRIMARY KEY (`salary_id`) USING BTREE,
  INDEX `IDX_salary_UNIQUE`(`salary_empid`, `salary_yf`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4882 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_salary
-- ----------------------------

-- ----------------------------
-- Table structure for dede_salary_config
-- ----------------------------
DROP TABLE IF EXISTS `dede_salary_config`;
CREATE TABLE `dede_salary_config`  (
  `id` int(11) NOT NULL,
  `yjcd` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为一级迟到',
  `ejcd` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为二级迟到',
  `sjcd` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为三级迟到',
  `yjzt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为一级早退',
  `ejzt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为二级早退',
  `sjzt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为三级早退',
  `kgbt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为旷工半天',
  `kgyt` double(11, 2) NULL DEFAULT NULL COMMENT '超过多少分钟为旷工一天',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dede_salary_config
-- ----------------------------
INSERT INTO `dede_salary_config` VALUES (1, 2.00, 9.00, 8.00, 2.00, 3.00, 4.00, 10.00, 20.00);

-- ----------------------------
-- Table structure for dede_sys_admin
-- ----------------------------
DROP TABLE IF EXISTS `dede_sys_admin`;
CREATE TABLE `dede_sys_admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usertype` float UNSIGNED NULL DEFAULT 0 COMMENT '权限ID',
  `userName` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `pwd` varchar(32) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `logintime` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录日期',
  `loginip` varchar(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '' COMMENT '最后登录 IP',
  `empid` int(11) NULL DEFAULT 0 COMMENT '员工ID',
  `loginnumb` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_sys_admin
-- ----------------------------
INSERT INTO `dede_sys_admin` VALUES (1, 10, 'admin', 'c3949ba59abbe56e057f', 1603783945, '127.0.0.1', 0, 531);
INSERT INTO `dede_sys_admin` VALUES (2, 10, '33333', 'c3949ba59abbe56e057f', 0, '', 0, 0);
INSERT INTO `dede_sys_admin` VALUES (3, 10, '333', '41f12de6341fba65b0ad', 0, '', 0, 0);
INSERT INTO `dede_sys_admin` VALUES (5, 9, 'jf', 'c3949ba59abbe56e057f', 1422687432, '127.0.0.1', 0, 27);

-- ----------------------------
-- Table structure for dede_sys_admintype
-- ----------------------------
DROP TABLE IF EXISTS `dede_sys_admintype`;
CREATE TABLE `dede_sys_admintype`  (
  `rank` float NOT NULL DEFAULT 1,
  `typename` varchar(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `web_role` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL COMMENT '页面权限',
  `department_role` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL COMMENT '部门数据权限',
  `Remark` varchar(255) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  PRIMARY KEY (`rank`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_sys_admintype
-- ----------------------------
INSERT INTO `dede_sys_admintype` VALUES (9, '积分滚动浏览', 'integral/trundle_maina.php|integral/trundle_mainb.php|integral/trundle_mainc.php|integral/integral_query.php', '0|0|0|0', '');
INSERT INTO `dede_sys_admintype` VALUES (10, '超级管理员', 'admin_AllowAll', 'admin_AllowAll', '所有功能和所有数据');

-- ----------------------------
-- Table structure for dede_sys_enum
-- ----------------------------
DROP TABLE IF EXISTS `dede_sys_enum`;
CREATE TABLE `dede_sys_enum`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ename` char(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `evalue` char(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '0',
  `reevalue` char(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `egroup` char(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `disorder` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `issign` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 103 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dede_sys_enum
-- ----------------------------
INSERT INTO `dede_sys_enum` VALUES (49, '初中以上', '初中以上', NULL, 'education', 1, 1);
INSERT INTO `dede_sys_enum` VALUES (50, '高中/中专', '高中/中专', NULL, 'education', 2, 1);
INSERT INTO `dede_sys_enum` VALUES (51, '大学专科', '大学专科', NULL, 'education', 3, 1);
INSERT INTO `dede_sys_enum` VALUES (52, '大学本科', '大学本科', NULL, 'education', 4, 1);
INSERT INTO `dede_sys_enum` VALUES (55, '仅用于判断缓存是否存在', '0', NULL, 'system', 0, 1);
INSERT INTO `dede_sys_enum` VALUES (78, '未婚', '未婚', NULL, 'marital', 1, 1);
INSERT INTO `dede_sys_enum` VALUES (79, '已婚', '已婚', NULL, 'marital', 2, 1);
INSERT INTO `dede_sys_enum` VALUES (80, '离异', '离异', NULL, 'marital', 3, 1);
INSERT INTO `dede_sys_enum` VALUES (94, '22', '22', NULL, '11', 1, 0);
INSERT INTO `dede_sys_enum` VALUES (95, '33', '33', NULL, '11', 2, 0);
INSERT INTO `dede_sys_enum` VALUES (96, '55', '55', NULL, '11', 3, 0);
INSERT INTO `dede_sys_enum` VALUES (97, '66', '66', NULL, '11', 4, 0);
INSERT INTO `dede_sys_enum` VALUES (100, '111', '111', NULL, '', 1, 0);
INSERT INTO `dede_sys_enum` VALUES (102, '77', '77', NULL, '11', 5, 0);

-- ----------------------------
-- Table structure for dede_sys_function
-- ----------------------------
DROP TABLE IF EXISTS `dede_sys_function`;
CREATE TABLE `dede_sys_function`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topid` int(11) NULL DEFAULT 0 COMMENT '上级ID',
  `urladd` varchar(50) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NULL DEFAULT NULL COMMENT '外部地址',
  `groups` varchar(255) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NULL DEFAULT NULL COMMENT '分组',
  `title` varchar(50) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NULL DEFAULT NULL COMMENT '功能名称',
  `disorder` smallint(11) NULL DEFAULT NULL COMMENT '排序',
  `ishidden` tinyint(4) NULL DEFAULT 0 COMMENT '是否隐藏',
  `isshartcut` tinyint(4) NULL DEFAULT 0 COMMENT '是否快捷',
  `isputred` tinyint(4) NULL DEFAULT 0 COMMENT '是否加红',
  `remark` varchar(255) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NULL DEFAULT NULL COMMENT '备注',
  `isbasefuc` smallint(6) NULL DEFAULT 0 COMMENT '是否系统基本功能，1是基本功能，不允许删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 88 CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_sys_function
-- ----------------------------
INSERT INTO `dede_sys_function` VALUES (3, 0, '#', '', '考勤管理', 2, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (4, 0, '#', '', '员工管理', 1, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (5, 0, '#', '', '积分管理', 3, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (6, 3, 'checkin/c_check.php', '', '考勤审核', 2, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (8, 3, 'checkin/c_config.php', '考勤配置', '考勤规则', 1, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (9, 3, 'checkin/c_input.php', '', '考勤导入', 1, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (11, 3, 'checkin/c_list.php', '', '考勤记录', 3, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (16, 4, 'emp/dep.php', '基础信息配置', '部门管理', 1, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (17, 4, 'emp/emp.php', '', '员工管理', 1, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (25, 4, 'emp/worktype.php', '基础信息配置', '工种管理', 3, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (27, 5, 'integral/integral.php', '', '积分管理', 1, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (29, 5, 'integral/integral_checkinConfig.php', '积分配置', '考勤扣分规则', 1, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (31, 5, 'integral/integral_guizhe.php', '积分配置', '积分规则', 2, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (34, 5, 'integral/integral_input.php', '', '考勤批量扣分导入', 4, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (36, 5, 'integral/integral_query.php', '积分统计', '积分查询报表', 1, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (37, 0, '#', '', '工资管理', 4, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (38, 37, 'salary/salary.php', '', '工资管理', 1, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (40, 37, 'salary/salary_config.php', '工资配置', '工资考勤扣款规则', 1, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (41, 37, 'salary/salary_day.php', '查询报表', '工资每日报表', 1, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (44, 37, 'salary/salary_t.php', '查询报表', '工资报表打印', 1, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (45, 0, '#', '', '系统管理', 5, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (47, 45, 'sys/log.php', '', '系统日志管理', 4, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (48, 45, 'sys/sys_user.php', '功能权限用户', '系统用户管理', 4, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (51, 45, 'sys/sys_cache_up.php', '', '缓存清空', 5, 0, 1, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (52, 45, 'sys/sys_function.php', '功能权限用户', '系统功能管理', 1, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (54, 45, 'sys/sys_stepselect.php', '', '数据字典', 3, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (56, 45, 'sys/sys_data.php', '数据库管理', '数据库备份', 0, 0, 1, 1, '', 0);
INSERT INTO `dede_sys_function` VALUES (58, 45, 'sys/sys_data_revert.php', '数据库管理', '数据库还原', 0, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (59, 45, 'sys/sys_group.php', '功能权限用户', '用户组管理', 2, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (62, 45, 'sys/sys_info.php', '', '系统参数', 0, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (76, 5, 'integral/trundle_mainb.php', '积分统计', 'B积分滚动显示', 4, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (77, 5, 'integral/trundle_mainc.php', '积分统计', 'C积分滚动显示', 5, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (78, 5, 'integral/trundle_maina.php', '积分统计', 'A积分滚动显示', 3, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (79, 5, 'integral/integral_add.php', '', '积分添加', 2, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (80, 37, 'salary/salary_add.php', '', '工资添加', 2, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (81, 5, 'integral/integral_day.php', '积分统计', '积分每日报表', 2, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (82, 5, 'integral/trundle_maind.php', '积分统计', 'D积分滚动显示', 6, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (83, 5, 'integral/trundle_maine.php', '积分统计', 'E积分滚动显示', 7, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (84, 5, 'integral/trundle_mainf.php', '积分统计', 'F积分滚动显示', 8, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (85, 5, 'integral/trundle_maing.php', '积分统计', 'G积分滚动显示', 9, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (86, 5, 'integral/trundle_mainh.php', '积分统计', 'H积分滚动显示', 10, 0, 0, 0, '', 0);
INSERT INTO `dede_sys_function` VALUES (87, 5, 'integral/trundle_maini.php', '积分统计', 'I积分滚动显示', 11, 0, 0, 0, '', 0);

-- ----------------------------
-- Table structure for dede_sys_log
-- ----------------------------
DROP TABLE IF EXISTS `dede_sys_log`;
CREATE TABLE `dede_sys_log`  (
  `lid` mediumint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `adminid` smallint(8) UNSIGNED NOT NULL DEFAULT 0,
  `filename` char(60) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `method` char(10) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `query` char(200) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `cip` char(15) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `dtime` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`lid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 189339 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dede_sys_log
-- ----------------------------
INSERT INTO `dede_sys_log` VALUES (189335, 1, 'trundle.do.php', 'GET', 'class=a', '127.0.0.1', 1603785387);
INSERT INTO `dede_sys_log` VALUES (189336, 1, 'trundle.do.php', 'GET', 'class=a', '127.0.0.1', 1603785397);
INSERT INTO `dede_sys_log` VALUES (189337, 1, 'trundle.do.php', 'GET', 'class=a', '127.0.0.1', 1603785407);
INSERT INTO `dede_sys_log` VALUES (189338, 1, 'trundle.do.php', 'GET', 'class=a', '127.0.0.1', 1603785417);

-- ----------------------------
-- Table structure for dede_sys_stepselect
-- ----------------------------
DROP TABLE IF EXISTS `dede_sys_stepselect`;
CREATE TABLE `dede_sys_stepselect`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `itemname` char(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `egroup` char(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  `issign` tinyint(1) UNSIGNED NULL DEFAULT 0,
  `issystem` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否系统',
  `description` char(30) CHARACTER SET gbk COLLATE gbk_chinese_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dede_sys_stepselect
-- ----------------------------
INSERT INTO `dede_sys_stepselect` VALUES (6, '教育程度', 'education', 1, 1, NULL);
INSERT INTO `dede_sys_stepselect` VALUES (9, '婚姻', 'marital', 1, 1, NULL);
INSERT INTO `dede_sys_stepselect` VALUES (12, '系统缓存标识', 'system', 1, 1, NULL);
INSERT INTO `dede_sys_stepselect` VALUES (13, '1122', '11', 0, 0, NULL);

-- ----------------------------
-- Table structure for dede_sys_sysconfig
-- ----------------------------
DROP TABLE IF EXISTS `dede_sys_sysconfig`;
CREATE TABLE `dede_sys_sysconfig`  (
  `aid` smallint(8) UNSIGNED NOT NULL DEFAULT 0,
  `varname` varchar(20) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `info` varchar(100) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `groupid` smallint(6) NOT NULL DEFAULT 1,
  `type` varchar(10) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT 'string',
  `value` text CHARACTER SET gbk COLLATE gbk_chinese_ci NULL,
  PRIMARY KEY (`varname`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dede_sys_sysconfig
-- ----------------------------
INSERT INTO `dede_sys_sysconfig` VALUES (4, 'cfg_cookie_encode', 'cookie加密码', 1, 'string', 'JfDHf7926J');
INSERT INTO `dede_sys_sysconfig` VALUES (5, 'cfg_indexurl', '网页主页链接', 1, 'string', '/');
INSERT INTO `dede_sys_sysconfig` VALUES (3, 'cfg_backup_dir', '数据备份目录（在data目录内）', 1, 'string', 'xiaoyang');
INSERT INTO `dede_sys_sysconfig` VALUES (1, 'cfg_softname', '系统名称', 1, 'string', '综合管理系统');
INSERT INTO `dede_sys_sysconfig` VALUES (2, 'cfg_powerby', '版权信息', 1, 'string', '版权所有:食品有限责任公司');
INSERT INTO `dede_sys_sysconfig` VALUES (7, 'cfg_imgtype', '图片浏览器文件类型', 2, 'string', 'jpg|gif|png');
INSERT INTO `dede_sys_sysconfig` VALUES (8, 'cfg_softtype', '允许上传的软件类型', 2, 'bstring', 'zip|gz|rar|iso|doc|xsl|ppt|wps');
INSERT INTO `dede_sys_sysconfig` VALUES (9, 'cfg_mediatype', '允许的多媒体文件类型', 2, 'bstring', 'swf|mpg|mp3|rm|rmvb|wmv|wma|wav|mid|mov');
INSERT INTO `dede_sys_sysconfig` VALUES (10, 'cfg_rm_remote', '远程图片本地化', 2, 'bool', 'Y');
INSERT INTO `dede_sys_sysconfig` VALUES (11, 'cfg_arc_autopic', '提取第一张图片作为缩略图', 2, 'bool', 'Y');
INSERT INTO `dede_sys_sysconfig` VALUES (6, 'cfg_medias_dir', '图片/上传文件默认路径', 2, 'string', '/uploads');
INSERT INTO `dede_sys_sysconfig` VALUES (12, 'cfg_search_time', '搜索间隔时间(秒/对网站所有用户)', 1, 'number', '3');
INSERT INTO `dede_sys_sysconfig` VALUES (13, 'cfg_upload_switch', '删除数据的同时删除相关附件文件', 2, 'bool', 'Y');
INSERT INTO `dede_sys_sysconfig` VALUES (14, 'cfg_puccache_time', '需缓存内容全局缓存时间(秒)', 1, 'number', '36000');
INSERT INTO `dede_sys_sysconfig` VALUES (15, 'cfg_addon_savetype', '附件保存形式(按data函数日期参数)', 2, 'string', 'Ym');
INSERT INTO `dede_sys_sysconfig` VALUES (16, 'cfg_tplcache_dir', '模板缓存目录', 1, 'string', '/data/tplcache');
INSERT INTO `dede_sys_sysconfig` VALUES (17, 'cfg_dede_log', '系统操作日志是否启用', 1, 'bool', 'Y');
INSERT INTO `dede_sys_sysconfig` VALUES (18, 'cfg_cli_time', '服务器时区', 1, 'number', '8');
INSERT INTO `dede_sys_sysconfig` VALUES (0, 'cfg_install_path', '系统安装位置', 1, 'string', '');
INSERT INTO `dede_sys_sysconfig` VALUES (1000, 'reg_computer_code', '机器码', 1, 'string', '6868535255545271515471495');
INSERT INTO `dede_sys_sysconfig` VALUES (1001, 'reg_reg_code', '注册码', 1, 'string', '');
INSERT INTO `dede_sys_sysconfig` VALUES (2000, 'run_numb', '运行次数', 1, 'string', '19');
INSERT INTO `dede_sys_sysconfig` VALUES (2001, 'run_startdate', '开始日期', 1, 'int', '1603783706');

-- ----------------------------
-- Table structure for dede_uploads
-- ----------------------------
DROP TABLE IF EXISTS `dede_uploads`;
CREATE TABLE `dede_uploads`  (
  `aid` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(60) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `url` char(80) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `mediatype` char(6) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '1' COMMENT '附件类型:IMG DOC DOCX',
  `width` char(10) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `height` char(10) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `playtime` char(10) CHARACTER SET gbk COLLATE gbk_chinese_ci NOT NULL DEFAULT '',
  `filesize` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `uptime` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `mid` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`aid`) USING BTREE,
  INDEX `memberid`(`mid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 452 CHARACTER SET = gbk COLLATE = gbk_chinese_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of dede_uploads
-- ----------------------------

-- ----------------------------
-- Function structure for getDepChildList
-- ----------------------------
DROP FUNCTION IF EXISTS `getDepChildList`;
delimiter ;;
CREATE FUNCTION `getDepChildList`(rootId INT)
 RETURNS varchar(1000) CHARSET utf8
BEGIN 
       DECLARE sTemp VARCHAR(1000); 
       DECLARE sTempChd VARCHAR(1000); 
     
       SET sTemp = ''; 
       SET sTempChd =cast(rootid as CHAR); 
     
       WHILE sTempChd is not null DO 
         SET sTemp = concat(sTemp,',',sTempChd); 
         SELECT group_concat(dep_id) INTO sTempChd FROM dede_emp_dep where FIND_IN_SET(dep_topid,sTempChd)>0; 
       END WHILE; 
       RETURN sTemp; 
     END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
