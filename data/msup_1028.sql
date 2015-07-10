-- MySQL dump 10.13  Distrib 5.6.16, for osx10.9 (x86_64)
--
-- Host: localhost    Database: msup
-- ------------------------------------------------------
-- Server version	5.6.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `msup_address`
--

DROP TABLE IF EXISTS `msup_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL COMMENT '地址',
  `status` int(1) DEFAULT NULL COMMENT '收件地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='地址通讯录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_address`
--

LOCK TABLES `msup_address` WRITE;
/*!40000 ALTER TABLE `msup_address` DISABLE KEYS */;
INSERT INTO `msup_address` VALUES (1,1,'湖北 黄石 西塞山区',0),(2,1,'辽宁 沈阳 新民市',0),(3,2,'北京 通州区',0),(4,2,'辽宁 沈阳 康平县',0),(5,2,'天津 和平区',0),(6,2,'北京 通州区',0),(7,2,'辽宁 沈阳 康平县',0),(8,2,'天津 和平区',1),(9,1,'浙江 杭州 上城区',0),(10,1,'浙江 杭州 上城区',0),(11,1,'天津 河北区',0),(12,1,'浙江 杭州 上城区',0),(13,1,'天津 河北区',0),(14,1,'福建 厦门 思明区',0),(15,1,'浙江 杭州 上城区',0),(16,1,'天津 河北区',0),(17,1,'北京 东城区',0),(18,1,'天津 河东区',0),(19,1,'湖北 孝感 汉川市',1);
/*!40000 ALTER TABLE `msup_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_auth_assignment`
--

DROP TABLE IF EXISTS `msup_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `msup_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `msup_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_assignment`
--

LOCK TABLES `msup_auth_assignment` WRITE;
/*!40000 ALTER TABLE `msup_auth_assignment` DISABLE KEYS */;
INSERT INTO `msup_auth_assignment` VALUES ('backend\\controllers\\auth-item\\create','0',NULL),('backend\\controllers\\auth-item\\delete','0',NULL),('backend\\controllers\\auth-item\\index','0',NULL),('backend\\controllers\\auth-item\\update','0',NULL),('教练编辑','1',NULL);
/*!40000 ALTER TABLE `msup_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_auth_item`
--

DROP TABLE IF EXISTS `msup_auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_item` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `msup_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `msup_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_item`
--

LOCK TABLES `msup_auth_item` WRITE;
/*!40000 ALTER TABLE `msup_auth_item` DISABLE KEYS */;
INSERT INTO `msup_auth_item` VALUES ('backend\\controllers\\auth-item\\create',2,'编辑','authRule','编辑',NULL,1414419547),('backend\\controllers\\auth-item\\delete',2,'创建了编辑3角色','authRule',NULL,1414386392,1414386392),('backend\\controllers\\auth-item\\index',2,'创建了呵呵角色','authRule','',1414386512,1414419679),('backend\\controllers\\auth-item\\update',2,'创建了编辑4角色','authRule',NULL,1414386424,1414386424),('backend\\controllers\\auth-item\\view',2,'','authRule','',1414419380,1414419714),('教练编辑',1,'编辑教练','authRule',NULL,1414418884,1414418884);
/*!40000 ALTER TABLE `msup_auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_auth_item_child`
--

DROP TABLE IF EXISTS `msup_auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `msup_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `msup_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `msup_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `msup_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_item_child`
--

LOCK TABLES `msup_auth_item_child` WRITE;
/*!40000 ALTER TABLE `msup_auth_item_child` DISABLE KEYS */;
INSERT INTO `msup_auth_item_child` VALUES ('教练编辑','backend\\controllers\\auth-item\\create'),('教练编辑','backend\\controllers\\auth-item\\delete'),('教练编辑','backend\\controllers\\auth-item\\index'),('教练编辑','backend\\controllers\\auth-item\\update'),('教练编辑','backend\\controllers\\auth-item\\view');
/*!40000 ALTER TABLE `msup_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_auth_role`
--

DROP TABLE IF EXISTS `msup_auth_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_role`
--

LOCK TABLES `msup_auth_role` WRITE;
/*!40000 ALTER TABLE `msup_auth_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `msup_auth_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_auth_rule`
--

DROP TABLE IF EXISTS `msup_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_rule` (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_admin` int(11) DEFAULT NULL,
  `updated_admin` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限规则';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_rule`
--

LOCK TABLES `msup_auth_rule` WRITE;
/*!40000 ALTER TABLE `msup_auth_rule` DISABLE KEYS */;
INSERT INTO `msup_auth_rule` VALUES ('auth-rule/delete','O:19:\"app\\models\\BaseRule\":3:{s:4:\"name\";s:16:\"auth-rule/delete\";s:9:\"createdAt\";i:1414395544;s:9:\"updatedAt\";i:1414395544;}',1414395544,1414395544,NULL,NULL),('auth-rule/update','O:19:\"app\\models\\BaseRule\":3:{s:4:\"name\";s:16:\"auth-rule/update\";s:9:\"createdAt\";i:1414395476;s:9:\"updatedAt\";i:1414395476;}',1414395476,1414395476,NULL,NULL),('authRule','O:19:\"app\\models\\BaseRule\":3:{s:4:\"name\";s:8:\"authRule\";s:9:\"createdAt\";i:1414396478;s:9:\"updatedAt\";i:1414396478;}',1414396478,1414396478,NULL,NULL);
/*!40000 ALTER TABLE `msup_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_directory`
--

DROP TABLE IF EXISTS `msup_directory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_directory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL COMMENT '教练ID',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号/座机',
  `status` int(1) DEFAULT NULL COMMENT '是否正在使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='号码簿';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_directory`
--

LOCK TABLES `msup_directory` WRITE;
/*!40000 ALTER TABLE `msup_directory` DISABLE KEYS */;
INSERT INTO `msup_directory` VALUES (1,1,'18500232114',0),(2,1,'18500232113',0),(3,1,'15023241114',0),(4,1,'15023241114',0),(5,1,'15023241114',0),(6,1,'15023241114',0),(7,1,'15023241114',0),(8,1,'15023241114',0),(9,1,'15023241114',0),(10,1,'15023241114',0),(11,1,'15023241114',0),(12,1,'15023241112',0),(13,1,'15023241113',0),(14,1,'15023241114',0),(15,1,'15023241112',0),(16,1,'15023241113',0),(17,1,'15023241114',0),(18,2,'18500232456',0),(19,2,'18500232456',1),(20,1,'18500232455',0),(21,1,'18500232458',0),(22,1,'18500232455',0),(23,1,'18500232458',0),(24,1,'18500232455',0),(25,1,'18500232458',0),(26,1,'18500232455',0),(27,1,'18500232458',0),(28,1,'18500232457',0),(29,1,'18500232452',1),(30,1,'18500232453',0),(31,1,'18500232454',0);
/*!40000 ALTER TABLE `msup_directory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_lecturer`
--

DROP TABLE IF EXISTS `msup_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_lecturer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '教练名称',
  `phone` varchar(20) DEFAULT NULL COMMENT '教练手机',
  `email` varchar(30) DEFAULT NULL COMMENT 'Email',
  `qq` varchar(20) DEFAULT NULL COMMENT 'QQ',
  `wecat` varchar(30) DEFAULT NULL COMMENT '微信',
  `company` varchar(100) DEFAULT NULL COMMENT '现任职公司',
  `position` varchar(100) DEFAULT NULL COMMENT '现任职位',
  `referee` varchar(100) DEFAULT NULL COMMENT '推荐人',
  `penName` varchar(100) DEFAULT NULL COMMENT '笔名',
  `leadSource` varchar(100) DEFAULT NULL COMMENT '来源',
  `thumbs` varchar(100) DEFAULT NULL COMMENT '头像',
  `signature` varchar(1000) DEFAULT NULL COMMENT '签名',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '最后更新',
  `create_admin` int(11) DEFAULT NULL COMMENT '添加管理员',
  `update_admin` varchar(300) DEFAULT NULL COMMENT '更新管理员',
  `status` int(11) DEFAULT NULL COMMENT '教练状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_lecturer`
--

LOCK TABLES `msup_lecturer` WRITE;
/*!40000 ALTER TABLE `msup_lecturer` DISABLE KEYS */;
INSERT INTO `msup_lecturer` VALUES (1,'未来','185002345859','','410345759','','腾讯','CTO','','','','','',NULL,1414486558,NULL,'1',1),(2,'12312','123213','','','','213','123123','','','','','',NULL,1414485584,NULL,'1',1),(3,'张三','18500232455','410345759@qq.com','','','新浪','PHP','','','','','',NULL,1414401108,NULL,'1',NULL),(4,'李四','18500021111','','','','百度','PHP','','','','','',1414401177,1414402681,1,'1',2),(5,'王五','15021231231','123@qq.com','','','腾讯','架构','','','','','呵呵',1414402840,1414417507,1,'2',1);
/*!40000 ALTER TABLE `msup_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_migration`
--

DROP TABLE IF EXISTS `msup_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='数据迁移版本表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_migration`
--

LOCK TABLES `msup_migration` WRITE;
/*!40000 ALTER TABLE `msup_migration` DISABLE KEYS */;
INSERT INTO `msup_migration` VALUES ('m000000_000000_base',1414325777),('m140209_132017_init',1414325778),('m140403_174025_create_account_table',1414325778),('m140504_113157_update_tables',1414325779),('m140504_130429_create_token_table',1414325779),('m140506_102106_rbac_init',1414325823),('m140830_171933_fix_ip_field',1414325779),('m140830_172703_change_account_table_name',1414325779);
/*!40000 ALTER TABLE `msup_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_profile`
--

DROP TABLE IF EXISTS `msup_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `msup_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_profile`
--

LOCK TABLES `msup_profile` WRITE;
/*!40000 ALTER TABLE `msup_profile` DISABLE KEYS */;
INSERT INTO `msup_profile` VALUES (1,NULL,NULL,'2312@qq.com','b61279b74213a42d143cabe65b2d6ce5',NULL,NULL,NULL),(2,NULL,NULL,'123@qq.com','487f87505f619bf9ea08f26bb34f8118',NULL,NULL,NULL);
/*!40000 ALTER TABLE `msup_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_social_account`
--

DROP TABLE IF EXISTS `msup_social_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `msup_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_social_account`
--

LOCK TABLES `msup_social_account` WRITE;
/*!40000 ALTER TABLE `msup_social_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `msup_social_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_task`
--

DROP TABLE IF EXISTS `msup_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_task` (
  `taskid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '任务id',
  `taskname` varchar(255) NOT NULL DEFAULT '' COMMENT '任务标题',
  `userid` int(11) unsigned DEFAULT '0' COMMENT '创建任务的用户id',
  `time` int(11) unsigned DEFAULT '0' COMMENT '任务创建的时间',
  PRIMARY KEY (`taskid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COMMENT='打印任务记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_task`
--

LOCK TABLES `msup_task` WRITE;
/*!40000 ALTER TABLE `msup_task` DISABLE KEYS */;
INSERT INTO `msup_task` VALUES (1,'111',10,0),(2,'任务标题',10,133322),(3,'任务标题',10,133322),(4,'任务标题',10,133322),(5,'任务标题',10,133322),(6,'任务标题',10,133322),(7,'任务标题',10,133322),(8,'任务标题',10,133322),(9,'任务标题',10,133322),(10,'任务标题',10,133322),(11,'任务标题',10,133322),(12,'任务标题',10,133322),(13,'任务标题',10,133322),(14,'任务标题',10,133322),(15,'任务标题',10,133322),(16,'任务标题',10,133322),(17,'任务标题',10,133322),(18,'任务标题',10,133322),(19,'任务标题',10,133322),(20,'任务标题',10,133322),(21,'任务标题',10,133322),(22,'任务标题',10,133322),(23,'任务标题',10,133322),(24,'任务标题',10,133322),(25,'任务标题',10,133322),(26,'任务标题',10,133322),(27,'任务标题',10,133322),(28,'任务标题',10,133322),(29,'任务标题',10,133322),(30,'任务标题',10,133322),(31,'任务标题',10,133322),(32,'任务标题',10,133322),(33,'任务标题',10,133322),(34,'任务标题',10,133322),(35,'任务标题',10,133322),(36,'任务标题',10,133322),(37,'任务标题',10,133322),(38,'任务标题',10,133322),(39,'任务标题',10,133322),(40,'任务标题',10,133322),(41,'任务标题',10,133322),(42,'任务标题',10,133322),(43,'任务标题',10,133322),(44,'任务标题',10,133322),(45,'任务标题',10,133322),(46,'任务标题',10,133322),(47,'任务标题',10,133322),(48,'任务标题',10,133322),(49,'任务标题',10,133322),(50,'任务标题',10,133322),(51,'任务标题',10,133322),(52,'任务标题',10,133322),(53,'任务标题',10,133322),(54,'任务标题',10,133322),(55,'任务标题',10,133322),(56,'任务标题',10,133322),(57,'任务标题',10,133322),(58,'任务标题',10,133322),(59,'任务标题',10,133322),(60,'任务标题',10,133322),(61,'任务标题',10,133322),(62,'任务标题',10,133322),(63,'任务标题',10,133322),(64,'任务标题',10,133322),(65,'任务标题',10,133322),(66,'任务标题',10,133322),(67,'任务标题',10,133322),(68,'任务标题',10,133322),(69,'任务标题',10,133322),(70,'任务标题',10,133322),(71,'任务标题',10,133322),(72,'任务标题',10,133322),(73,'任务标题',10,133322),(74,'任务标题',10,133322),(75,'任务标题',10,133322),(76,'任务标题',10,133322),(77,'任务标题',10,133322),(78,'任务标题',10,133322),(79,'任务标题',10,133322),(80,'任务标题',10,133322),(81,'任务标题',10,133322),(82,'任务标题',10,133322),(83,'任务标题',10,133322),(84,'任务标题',10,133322),(85,'任务标题',10,133322),(86,'任务标题',10,133322),(87,'任务标题',11,133322),(88,'任务标题',11,133322),(89,'任务标题',11,133322),(90,'任务标题',11,133322),(91,'任务标题',11,133322),(92,'任务标题',11,133322),(93,'任务标题',11,133322),(94,'任务标题',11,133322),(95,'任务标题',11,133322),(96,'任务标题',11,133322),(97,'任务标题',11,133322);
/*!40000 ALTER TABLE `msup_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_task_record`
--

DROP TABLE IF EXISTS `msup_task_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_task_record` (
  `recordid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `taskid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的任务的id',
  `lecturer_id` int(11) unsigned DEFAULT '0' COMMENT '教练的id',
  `time` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`recordid`),
  KEY `taskid` (`taskid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='任务详细记录表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_task_record`
--

LOCK TABLES `msup_task_record` WRITE;
/*!40000 ALTER TABLE `msup_task_record` DISABLE KEYS */;
INSERT INTO `msup_task_record` VALUES (1,86,4,1414460605);
/*!40000 ALTER TABLE `msup_task_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_token`
--

DROP TABLE IF EXISTS `msup_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `msup_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_token`
--

LOCK TABLES `msup_token` WRITE;
/*!40000 ALTER TABLE `msup_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `msup_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_user`
--

DROP TABLE IF EXISTS `msup_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `registration_ip` bigint(20) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_user`
--

LOCK TABLES `msup_user` WRITE;
/*!40000 ALTER TABLE `msup_user` DISABLE KEYS */;
INSERT INTO `msup_user` VALUES (1,'admin21','2312@qq.com','$2y$10$.fMM9nZcNDRJQO7UfUgTceuKF0PnCi8AZA2Y/ctRIFF5c96R1pwd2','BTJtryHuGC06vBA_MbONgn_jnU-sIEhv',1414325830,NULL,1414419832,'1',2130706433,1414325830,1414325830,0),(2,'admin2','123@qq.com','$2y$10$OaotEbxvfPm6dcNzdkPPxOOJQRXjPjUXjBXY/80ogzsNACJik9bjK','u8_T20f9fYIJ43-U-cu4fKFEpv08QHJP',1414417473,NULL,1414419825,NULL,2130706433,1414417473,1414417473,0);
/*!40000 ALTER TABLE `msup_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-28 17:06:12
