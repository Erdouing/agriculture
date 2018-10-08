/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : shop1

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-10-08 13:29:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for shop_admin
-- ----------------------------
DROP TABLE IF EXISTS `shop_admin`;
CREATE TABLE `shop_admin` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `random` char(32) NOT NULL COMMENT '管理员id',
  `username` varchar(30) DEFAULT NULL COMMENT '管理员名称',
  `password` char(32) DEFAULT NULL COMMENT '管理员密码',
  `timecreated` bigint(10) DEFAULT NULL COMMENT '创建时间',
  `timemodified` bigint(10) DEFAULT NULL COMMENT '修改时间',
  `status` smallint(1) DEFAULT '0' COMMENT '0：正常 1：删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_admin
-- ----------------------------
INSERT INTO `shop_admin` VALUES ('1', '8E665BC086E15069A49467EF94E348D0', 'admin', 'c81e728d9d4c2f636f067f89cc14862c', '1537368071', '1538192534', '0');
INSERT INTO `shop_admin` VALUES ('2', '5403CB0065FA841D2C9BECD19BC41352', 'cbw', 'c4ca4238a0b923820dcc509a6f75849b', '1537413440', '1538192707', '0');

-- ----------------------------
-- Table structure for shop_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `shop_auth_group`;
CREATE TABLE `shop_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `statement` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0：启用 1：禁止',
  `rules` char(80) NOT NULL DEFAULT '' COMMENT '规则集合',
  `timecreated` bigint(20) DEFAULT NULL COMMENT '创建时间',
  `timemodified` bigint(20) DEFAULT NULL COMMENT '修改时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '0：正常 1：删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_auth_group
-- ----------------------------
INSERT INTO `shop_auth_group` VALUES ('1', '超级管理员', '0', '1,2,3,4,5,6,7,8,11,12,9,10,13,14,15,16,17,18,19,20,21,22', null, '1537417987', '0');
INSERT INTO `shop_auth_group` VALUES ('2', '普通管理员', '0', '1,4,9,10,18,19,20,21,22', '1537413415', '1537419171', '0');

-- ----------------------------
-- Table structure for shop_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `shop_auth_group_access`;
CREATE TABLE `shop_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_auth_group_access
-- ----------------------------
INSERT INTO `shop_auth_group_access` VALUES ('1', '1');
INSERT INTO `shop_auth_group_access` VALUES ('2', '1');

-- ----------------------------
-- Table structure for shop_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `shop_auth_rule`;
CREATE TABLE `shop_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '控制器/方法',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '权限名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0：正常 1：删除',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '情况说明',
  `pid` mediumint(9) DEFAULT '0' COMMENT '上级栏目',
  `level` tinyint(1) DEFAULT '0' COMMENT '权限等级',
  `sort` int(5) DEFAULT '50' COMMENT '排序',
  `timecreated` bigint(20) DEFAULT NULL COMMENT '创建时间',
  `timemodified` bigint(20) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_auth_rule
-- ----------------------------
INSERT INTO `shop_auth_rule` VALUES ('1', 'admin', '管理员', '1', '0', '', '0', '0', '50', '1537413159', '1537413260');
INSERT INTO `shop_auth_rule` VALUES ('2', 'admin/lst', '管理员显示', '1', '0', '', '1', '1', '50', '1537413180', null);
INSERT INTO `shop_auth_rule` VALUES ('3', 'admin/add', '管理员新增', '1', '0', '', '1', '1', '50', '1537413213', null);
INSERT INTO `shop_auth_rule` VALUES ('4', 'admin/edit', '管理员编辑', '1', '0', '', '1', '1', '50', '1537413231', null);
INSERT INTO `shop_auth_rule` VALUES ('5', 'admin/del', '管理员删除', '1', '0', '', '1', '1', '50', '1537413247', null);
INSERT INTO `shop_auth_rule` VALUES ('6', 'auth_group', '用户组', '1', '0', '', '0', '0', '50', '1537413318', null);
INSERT INTO `shop_auth_rule` VALUES ('7', 'AuthGroup/lst', '用户组显示', '1', '0', '', '6', '1', '50', '1537413357', null);
INSERT INTO `shop_auth_rule` VALUES ('8', 'AuthGroup/add', '用户组新增', '1', '0', '', '6', '1', '50', '1537413375', null);
INSERT INTO `shop_auth_rule` VALUES ('9', 'index', '后台', '1', '0', '', '0', '0', '50', '1537414116', null);
INSERT INTO `shop_auth_rule` VALUES ('10', 'index/index', '后台首页', '1', '0', '', '9', '1', '50', '1537414135', null);
INSERT INTO `shop_auth_rule` VALUES ('11', 'AuthGroup/edit', '用户组编辑', '1', '0', '', '6', '1', '50', '1537414854', null);
INSERT INTO `shop_auth_rule` VALUES ('12', 'AuthGroup/del', '用户组删除', '1', '0', '', '6', '1', '50', '1537414869', '1537414923');
INSERT INTO `shop_auth_rule` VALUES ('13', 'AuthRule', '权限', '1', '0', '', '0', '0', '50', '1537414963', null);
INSERT INTO `shop_auth_rule` VALUES ('14', 'AuthRule/lst', '权限显示', '1', '0', '', '13', '1', '50', '1537414985', null);
INSERT INTO `shop_auth_rule` VALUES ('15', 'AuthRule/add', '权限新增', '1', '0', '', '13', '1', '50', '1537415006', null);
INSERT INTO `shop_auth_rule` VALUES ('16', 'AuthRule/edit', '权限编辑', '1', '0', '', '13', '1', '50', '1537415022', null);
INSERT INTO `shop_auth_rule` VALUES ('17', 'AuthRule/del', '权限删除', '1', '0', '', '13', '1', '50', '1537415036', null);
INSERT INTO `shop_auth_rule` VALUES ('18', 'Cate', '栏目管理', '1', '0', '', '0', '0', '50', '1537415575', null);
INSERT INTO `shop_auth_rule` VALUES ('19', 'Cate/lst', '栏目显示', '1', '0', '', '18', '1', '50', '1537415604', null);
INSERT INTO `shop_auth_rule` VALUES ('20', 'Cate/add', '栏目新增', '1', '0', '', '18', '1', '50', '1537415634', null);
INSERT INTO `shop_auth_rule` VALUES ('21', 'Cate/edit', '栏目编辑', '1', '0', '', '18', '1', '50', '1537415662', null);
INSERT INTO `shop_auth_rule` VALUES ('22', 'Cate/del', '栏目删除', '1', '0', '', '18', '1', '50', '1537417937', null);
