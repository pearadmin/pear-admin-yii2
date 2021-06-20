/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : pear

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2021-06-20 21:44:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yp_user
-- ----------------------------
DROP TABLE IF EXISTS `yp_user`;
CREATE TABLE `yp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '昵称',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `head_pic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of yp_user
-- ----------------------------
INSERT INTO `yp_user` VALUES ('1', 'tangsan', '唐三', '', '$2y$13$wf63BXPyUzwXtmhK.pIF9.HOSkRlTlbytkTO.0imGu8QrjCSn5Evu', null, '2', '', '10', '0', '1620833707', null, null);
INSERT INTO `yp_user` VALUES ('2', 'xiaowu', '小舞', null, '$2y$13$wf63BXPyUzwXtmhK.pIF9.HOSkRlTlbytkTO.0imGu8QrjCSn5Evu', null, '3', null, '10', '1615995639', '1620833713', null, null);
INSERT INTO `yp_user` VALUES ('3', 'daimubai', '戴沐白', null, '$2y$13$MP/bbW5TgnTfO6DED1IkGu9dD5Xv.P6Eq1X7PDuJ2jb.0X20d7oOe', null, '4', null, '10', '1615995749', '1620833719', null, null);
INSERT INTO `yp_user` VALUES ('4', 'aosika', '奥斯卡', null, '$2y$13$wf63BXPyUzwXtmhK.pIF9.HOSkRlTlbytkTO.0imGu8QrjCSn5Evu', null, '7', null, '10', '1615995767', '1620833726', null, null);
INSERT INTO `yp_user` VALUES ('5', 'mahongjun', '马红俊', null, '$2y$13$R8sRSP40eolhIJXt3dxScO6jeGQqYW8lvU4bQxj8B2wPRQPDYmlHO', null, '8', null, '10', '1615995801', '1620833732', null, null);
INSERT INTO `yp_user` VALUES ('6', 'ningrongrong', '宁荣荣', null, '$2y$13$1/HIoD6zHcjCr3lJbbaTYuveR4dd7AUB3PuNZcR9mJnRfa5BiIl0G', null, '10', null, '10', '1615996430', '1620833737', null, null);
INSERT INTO `yp_user` VALUES ('24', 'bibidong', '比比东', null, '$2y$13$mjfvsIVBgl3zWujzpdFQouY12SMxkSwVfI91QWz2Gitq2a9bO4Tre', null, '1', null, '10', '1620744289', '1620744289', null, null);
INSERT INTO `yp_user` VALUES ('25', 'yueguang', '月关', null, '$2y$13$FlIadJj1W379IXJtkh9sF.hCc3NENXIxvWyW7AKm1hVfJxdGK8qJG', null, '1', null, '10', '1620744319', '1620744319', null, null);
INSERT INTO `yp_user` VALUES ('26', 'guimei', '鬼魅', null, '$2y$13$80cNT49XEzqFhe91T.p71OKaRGWEwFg.fgaJirOF5sIvedPR1NlzK', null, '1', null, '10', '1620744345', '1624026411', null, null);
INSERT INTO `yp_user` VALUES ('27', 'huliena', '胡列娜', null, '$2y$13$p8AAL/imutwSyTc/cEAI9ObnEDewqChAkMdfy4D365E8vaKeuLvda', null, '1', null, '10', '1620744363', '1620744363', null, null);
INSERT INTO `yp_user` VALUES ('28', 'qianrenxue', '千仞雪', null, '$2y$13$zkiitsCArpkLLCrZ00Arwu3xG3tVpAsZvCTFVIbE6Hqn3P8.nNuQm', null, '1', null, '10', '1620744375', '1620744375', null, null);
INSERT INTO `yp_user` VALUES ('29', 'qiandaoliu', '千道流', null, '$2y$13$ZD2tml3KWYpbSrPrbvU2xOGzEKDlCSV5KUec.TLRFnGuD7bDDfwlC', null, '1', null, '10', '1620744394', '1620744394', null, null);
INSERT INTO `yp_user` VALUES ('30', 'earnest', 'earnest', null, '$2y$13$xFwm7cmjqUAiuHbgjnBEj.XQswelo4zS4nV/wZYweHvVyaDXpdbvS', null, '1', null, '10', '1623510548', '1623510565', null, null);

-- ----------------------------
-- Table structure for yp_system
-- ----------------------------
DROP TABLE IF EXISTS `yp_system`;
CREATE TABLE `yp_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo_title` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tab_max` int(4) DEFAULT NULL,
  `keep_load` int(4) DEFAULT NULL,
  `index_title` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `index_href` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `links_title` tinytext CHARACTER SET utf8,
  `links_href` tinytext CHARACTER SET utf8,
  `links_icon` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `session` tinyint(2) DEFAULT NULL,
  `muilt_tab` tinyint(2) DEFAULT NULL,
  `verify_code` tinyint(2) DEFAULT NULL,
  `file_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `menu_control` tinyint(2) DEFAULT NULL,
  `menu_accordion` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of yp_system
-- ----------------------------
INSERT INTO `yp_system` VALUES ('1', 'Pear Admin', '20', '0', '首页', '/site/content', '[\"\\u5b98\\u65b9\\u7f51\\u7ad9\",\"\\u5f00\\u53d1\\u6587\\u6863\",\"\\u5f00\\u6e90\\u5730\\u5740\",\"\\u95ee\\u7b54\\u793e\\u533a\"]', '[\"http:\\/\\/www.pearadmin.com\",\"http:\\/\\/www.pearadmin.com\\/doc\\/\",\"https:\\/\\/gitee.com\\/pear-admin\\/\",\"http:\\/\\/forum.pearadmin.com\\/\"]', '[\"layui-icon layui-icon-rate\",\"layui-icon layui-icon-rate-solid\",\"layui-icon layui-icon-fonts-code\",\"layui-icon layui-icon-survey\"]', '1', '1', '1', '/plugins/admin/images/logo/logo_bak.png', '0', '1');

-- ----------------------------
-- Table structure for yp_order_copy
-- ----------------------------
DROP TABLE IF EXISTS `yp_order_copy`;
CREATE TABLE `yp_order_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_num` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pay_status` tinyint(2) DEFAULT '0' COMMENT '0: 未支付 1：已支付',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of yp_order_copy
-- ----------------------------
INSERT INTO `yp_order_copy` VALUES ('1', '92001123', '1', '0');
INSERT INTO `yp_order_copy` VALUES ('2', '92001124', '1', '0');
INSERT INTO `yp_order_copy` VALUES ('3', '92001125', '1', '0');

-- ----------------------------
-- Table structure for yp_order
-- ----------------------------
DROP TABLE IF EXISTS `yp_order`;
CREATE TABLE `yp_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_num` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pay_status` tinyint(2) DEFAULT '0' COMMENT '0: 未支付 1：已支付',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of yp_order
-- ----------------------------
INSERT INTO `yp_order` VALUES ('1', '92001123', '1', '0');
INSERT INTO `yp_order` VALUES ('2', '92001124', '1', '0');
INSERT INTO `yp_order` VALUES ('3', '92001125', '1', '0');

-- ----------------------------
-- Table structure for yp_migration
-- ----------------------------
DROP TABLE IF EXISTS `yp_migration`;
CREATE TABLE `yp_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yp_migration
-- ----------------------------
INSERT INTO `yp_migration` VALUES ('m000000_000000_base', '1608905138');
INSERT INTO `yp_migration` VALUES ('m140506_102106_rbac_init', '1608905158');
INSERT INTO `yp_migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', '1608905159');
INSERT INTO `yp_migration` VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', '1608905159');
INSERT INTO `yp_migration` VALUES ('m200409_110543_rbac_update_mssql_trigger', '1608905160');

-- ----------------------------
-- Table structure for yp_menu
-- ----------------------------
DROP TABLE IF EXISTS `yp_menu`;
CREATE TABLE `yp_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT '99',
  `icon` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `parent` (`parent`) USING BTREE,
  CONSTRAINT `yp_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yp_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of yp_menu
-- ----------------------------
INSERT INTO `yp_menu` VALUES ('2', '权限管理', null, '', '1', 'layui-icon layui-icon-vercode');
INSERT INTO `yp_menu` VALUES ('26', '菜单管理', '2', '/rbac/menu/index', '6', '');
INSERT INTO `yp_menu` VALUES ('27', '路由配制', '2', '/rbac/rbac/routes', '4', '');
INSERT INTO `yp_menu` VALUES ('28', '用户管理', '2', '/rbac/user/user-list', '1', '');
INSERT INTO `yp_menu` VALUES ('29', '角色列表', '2', '/rbac/rbac/role-list', '2', '');
INSERT INTO `yp_menu` VALUES ('30', '权限分配', '2', '/rbac/rbac/perms-list', '3', '');
INSERT INTO `yp_menu` VALUES ('31', '部门管理', '2', '/rbac/dept/index', '5', '');
INSERT INTO `yp_menu` VALUES ('32', '系统管理', null, '', '2', 'layui-icon layui-icon-set');
INSERT INTO `yp_menu` VALUES ('33', '文件管理', '32', '/rbac/system/index', '1', '');
INSERT INTO `yp_menu` VALUES ('34', '系统设置', '32', '/rbac/system/sys-set', '2', '');

-- ----------------------------
-- Table structure for yp_dept
-- ----------------------------
DROP TABLE IF EXISTS `yp_dept`;
CREATE TABLE `yp_dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `parent` tinyint(1) DEFAULT '0',
  `order` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of yp_dept
-- ----------------------------
INSERT INTO `yp_dept` VALUES ('1', '上海总公司', '0', '2');
INSERT INTO `yp_dept` VALUES ('2', '总经办', '1', '2');
INSERT INTO `yp_dept` VALUES ('3', '产品部', '1', '2');
INSERT INTO `yp_dept` VALUES ('4', '信息部', '1', '3');
INSERT INTO `yp_dept` VALUES ('5', '苏州分公司', '0', '0');
INSERT INTO `yp_dept` VALUES ('6', '运营中心', '5', '1');
INSERT INTO `yp_dept` VALUES ('7', '操作部', '6', '2');
INSERT INTO `yp_dept` VALUES ('8', '卡车部', '6', '3');
INSERT INTO `yp_dept` VALUES ('9', '客服中心', '5', '4');
INSERT INTO `yp_dept` VALUES ('10', '售前部', '9', '5');
INSERT INTO `yp_dept` VALUES ('11', '售后部', '9', '6');

-- ----------------------------
-- Table structure for yp_customer
-- ----------------------------
DROP TABLE IF EXISTS `yp_customer`;
CREATE TABLE `yp_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0:正常 1：删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of yp_customer
-- ----------------------------
INSERT INTO `yp_customer` VALUES ('1', '李斯', '0');
INSERT INTO `yp_customer` VALUES ('2', '韩非', '1');

-- ----------------------------
-- Table structure for yp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `yp_auth_rule`;
CREATE TABLE `yp_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '规则名称',
  `data` blob COMMENT '规则数据',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of yp_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for yp_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `yp_auth_item_child`;
CREATE TABLE `yp_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `yp_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yp_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yp_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yp_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of yp_auth_item_child
-- ----------------------------
INSERT INTO `yp_auth_item_child` VALUES ('超级管理员', '/*');
INSERT INTO `yp_auth_item_child` VALUES ('人员管理', '/menu/*');
INSERT INTO `yp_auth_item_child` VALUES ('人员管理', '/rbac/dept/get-depts');
INSERT INTO `yp_auth_item_child` VALUES ('人员管理', '/rbac/dept/get-slt-depts');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/rbac/menu/get-menus');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/compressed-file');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/create');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/del');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/download');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/get-folder-size');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/get-links');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/index');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/remove');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/rename');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/sys-set');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/update-perms');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/rbac/system/upload');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/rbac/user/logout');
INSERT INTO `yp_auth_item_child` VALUES ('人员管理', '/rbac/user/user-list');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/site/content');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/site/error403');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/site/error404');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/site/error500');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/site/index');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/site/login');
INSERT INTO `yp_auth_item_child` VALUES ('基础权限', '/site/logout');
INSERT INTO `yp_auth_item_child` VALUES ('系统管理', '/system/*');
INSERT INTO `yp_auth_item_child` VALUES ('管理员', '人员管理');
INSERT INTO `yp_auth_item_child` VALUES ('人员管理', '基础权限');
INSERT INTO `yp_auth_item_child` VALUES ('管理员', '基础权限');
INSERT INTO `yp_auth_item_child` VALUES ('管理员', '系统管理');

-- ----------------------------
-- Table structure for yp_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `yp_auth_item`;
CREATE TABLE `yp_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色或权限名称',
  `type` smallint(6) NOT NULL COMMENT '1:角色 2.权限',
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '规则名称',
  `data` blob COMMENT '规则数据',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `yp_idx-auth_item-type` (`type`),
  CONSTRAINT `yp_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `yp_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of yp_auth_item
-- ----------------------------
INSERT INTO `yp_auth_item` VALUES ('/*', '2', '/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/common/*', '2', '/common/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/dept/*', '2', '/dept/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/menu/*', '2', '/menu/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/*', '2', '/rbac/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/create', '2', '/rbac/dept/create', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/delete', '2', '/rbac/dept/delete', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/delete-all', '2', '/rbac/dept/delete-all', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/get-depts', '2', '/rbac/dept/get-depts', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/get-slt-depts', '2', '/rbac/dept/get-slt-depts', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/get-table-depts', '2', '/rbac/dept/get-table-depts', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/index', '2', '/rbac/dept/index', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/dept/update', '2', '/rbac/dept/update', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/menu/create', '2', '/rbac/menu/create', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/menu/delete', '2', '/rbac/menu/delete', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/menu/get-menu-list', '2', '/rbac/menu/get-menu-list', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/menu/get-menus', '2', '/rbac/menu/get-menus', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/menu/index', '2', '/rbac/menu/index', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/menu/update', '2', '/rbac/menu/update', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/menu/view', '2', '/rbac/menu/view', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/add-perms', '2', '/rbac/rbac/add-perms', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/get-perms-list', '2', '/rbac/rbac/get-perms-list', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/get-role-list', '2', '/rbac/rbac/get-role-list', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/init', '2', '/rbac/rbac/init', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/item-update', '2', '/rbac/rbac/item-update', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/perms-list', '2', '/rbac/rbac/perms-list', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/role-list', '2', '/rbac/rbac/role-list', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/routes', '2', '/rbac/rbac/routes', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/update-child', '2', '/rbac/rbac/update-child', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/update-item', '2', '/rbac/rbac/update-item', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/update-permissions', '2', '/rbac/rbac/update-permissions', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/update-role', '2', '/rbac/rbac/update-role', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/updateroutes', '2', '/rbac/rbac/updateroutes', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/rbac/updateroutes_bak', '2', '/rbac/rbac/updateroutes_bak', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/role/createrole', '2', '/rbac/role/createrole', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/compressed-file', '2', '/rbac/system/compressed-file', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/create', '2', '/rbac/system/create', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/del', '2', '/rbac/system/del', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/download', '2', '/rbac/system/download', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/get-folder-size', '2', '/rbac/system/get-folder-size', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/get-links', '2', '/rbac/system/get-links', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/getdirs', '2', '/rbac/system/getdirs', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/index', '2', '/rbac/system/index', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/remove', '2', '/rbac/system/remove', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/rename', '2', '/rbac/system/rename', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/sys-set', '2', '/rbac/system/sys-set', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/update-perms', '2', '/rbac/system/update-perms', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/system/upload', '2', '/rbac/system/upload', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/test/ts', '2', '/rbac/test/ts', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/delete-all', '2', '/rbac/user/delete-all', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/insert', '2', '/rbac/user/insert', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/login', '2', '/rbac/user/login', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/logout', '2', '/rbac/user/logout', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/update', '2', '/rbac/user/update', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/update-user-child', '2', '/rbac/user/update-user-child', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/user-list', '2', '/rbac/user/user-list', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/rbac/user/user-update', '2', '/rbac/user/user-update', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/role/*', '2', '/role/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/site/*', '2', '/site/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/site/content', '2', '/site/content', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/site/error403', '2', '/site/error403', null, null, '1623424016', '1623424016');
INSERT INTO `yp_auth_item` VALUES ('/site/error404', '2', '/site/error404', null, null, '1623424016', '1623424016');
INSERT INTO `yp_auth_item` VALUES ('/site/error500', '2', '/site/error500', null, null, '1623424016', '1623424016');
INSERT INTO `yp_auth_item` VALUES ('/site/index', '2', '/site/index', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/site/login', '2', '/site/login', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/site/logout', '2', '/site/logout', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/site/s', '2', '/site/s', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/system/*', '2', '/system/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/tools/*', '2', '/tools/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/tools/icon', '2', '/tools/icon', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('/user/*', '2', '/user/*', null, null, '1623341677', '1623341677');
INSERT INTO `yp_auth_item` VALUES ('人员管理', '2', '菜单名：人员管理', null, null, '1623424286', '1623513265');
INSERT INTO `yp_auth_item` VALUES ('基础权限', '2', '默认权限，不可删除或修改', null, null, '1623344661', '1623514568');
INSERT INTO `yp_auth_item` VALUES ('操作员', '1', 'operator', null, null, '1623155818', '1623155818');
INSERT INTO `yp_auth_item` VALUES ('权限管理', '2', '权限管理', null, null, '1611674427', '1623424266');
INSERT INTO `yp_auth_item` VALUES ('游客', '1', 'guest', null, null, '1623155790', '1623155790');
INSERT INTO `yp_auth_item` VALUES ('管理员', '1', 'admin', null, null, '1623154265', '1623154265');
INSERT INTO `yp_auth_item` VALUES ('系统管理', '2', '系统管理', null, null, '1621436683', '1623424269');
INSERT INTO `yp_auth_item` VALUES ('超级管理员', '1', 'superadmin', null, null, '1615991598', '1623154273');

-- ----------------------------
-- Table structure for yp_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `yp_auth_assignment`;
CREATE TABLE `yp_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色或权限',
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户ID',
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `yp_idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `yp_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yp_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of yp_auth_assignment
-- ----------------------------
INSERT INTO `yp_auth_assignment` VALUES ('基础权限', '29', '1623945084');
INSERT INTO `yp_auth_assignment` VALUES ('基础权限', '30', '1623513968');
INSERT INTO `yp_auth_assignment` VALUES ('基础权限', '36', '1623514667');
INSERT INTO `yp_auth_assignment` VALUES ('基础权限', '37', '1623517055');
INSERT INTO `yp_auth_assignment` VALUES ('权限管理', '1', '1616219246');
INSERT INTO `yp_auth_assignment` VALUES ('管理员', '2', '1623254994');
INSERT INTO `yp_auth_assignment` VALUES ('系统管理', '1', '1621436732');
INSERT INTO `yp_auth_assignment` VALUES ('超级管理员', '1', '1616219246');
