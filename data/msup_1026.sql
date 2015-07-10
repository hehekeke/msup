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
-- Table structure for table `msup_auth_assignment`
--

DROP TABLE IF EXISTS `msup_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `msup_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `msup_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_assignment`
--

LOCK TABLES `msup_auth_assignment` WRITE;
/*!40000 ALTER TABLE `msup_auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `msup_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_auth_item`
--

DROP TABLE IF EXISTS `msup_auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `msup_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `msup_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_item`
--

LOCK TABLES `msup_auth_item` WRITE;
/*!40000 ALTER TABLE `msup_auth_item` DISABLE KEYS */;
INSERT INTO `msup_auth_item` VALUES ('编辑',2,'创建了编辑许可',NULL,NULL,1414332073,1414332073);
/*!40000 ALTER TABLE `msup_auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `msup_auth_item_child`
--

DROP TABLE IF EXISTS `msup_auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msup_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `msup_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `msup_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `msup_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `msup_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_item_child`
--

LOCK TABLES `msup_auth_item_child` WRITE;
/*!40000 ALTER TABLE `msup_auth_item_child` DISABLE KEYS */;
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
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_auth_rule`
--

LOCK TABLES `msup_auth_rule` WRITE;
/*!40000 ALTER TABLE `msup_auth_rule` DISABLE KEYS */;
INSERT INTO `msup_auth_rule` VALUES ('编辑','',1,1);
/*!40000 ALTER TABLE `msup_auth_rule` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_profile`
--

LOCK TABLES `msup_profile` WRITE;
/*!40000 ALTER TABLE `msup_profile` DISABLE KEYS */;
INSERT INTO `msup_profile` VALUES (1,NULL,NULL,'2312@qq.com','b61279b74213a42d143cabe65b2d6ce5',NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `msup_user`
--

LOCK TABLES `msup_user` WRITE;
/*!40000 ALTER TABLE `msup_user` DISABLE KEYS */;
INSERT INTO `msup_user` VALUES (1,'admin21','2312@qq.com','$2y$10$.fMM9nZcNDRJQO7UfUgTceuKF0PnCi8AZA2Y/ctRIFF5c96R1pwd2','BTJtryHuGC06vBA_MbONgn_jnU-sIEhv',1414325830,NULL,NULL,NULL,2130706433,1414325830,1414325830,0);
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

-- Dump completed on 2014-10-26 23:26:09
