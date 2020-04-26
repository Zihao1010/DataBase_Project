-- MySQL dump 10.13  Distrib 5.5.47, for Win32 (x86)
--
-- Host: localhost    Database: flight_system
-- ------------------------------------------------------
-- Server version	5.5.47

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
-- Table structure for table `flight`
--

DROP TABLE IF EXISTS `flight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flight` (
  `Flight` varchar(10) NOT NULL DEFAULT '' COMMENT '航班号',
  `Start` varchar(40) DEFAULT NULL COMMENT '始发机场',
  `Terminus` varchar(40) DEFAULT NULL COMMENT '目的机场',
  `Start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '出发时间',
  `End_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '到达时间',
  `Company` varchar(30) DEFAULT NULL COMMENT '航空公司',
  `Flight_type` varchar(50) DEFAULT NULL COMMENT '飞机类型',
  `Passenger_num` int(11) DEFAULT NULL COMMENT '旅客数量',
  `Remain` int(11) DEFAULT NULL COMMENT '座位余量',
  `Status` varchar(10) DEFAULT NULL COMMENT '当前状态',
  `Price` float(8,2) DEFAULT NULL COMMENT '机票价格'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flight`
--

LOCK TABLES `flight` WRITE;
/*!40000 ALTER TABLE `flight` DISABLE KEYS */;
INSERT INTO `flight` VALUES ('SG1234','上海','广州','2016-05-20 08:30:00','2016-05-21 12:30:00','XX航空公司','客机',0,180,'故障暂停',2000.00),('LG12314','兰州','北京','2016-05-20 08:30:00','2016-05-21 12:30:00','XX航空公司','客机',0,180,'正常',1999.00);
/*!40000 ALTER TABLE `flight` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passengers`
--

DROP TABLE IF EXISTS `passengers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passengers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `Flight` varchar(10) DEFAULT NULL COMMENT '航班号',
  `Certificate` varchar(30) DEFAULT NULL COMMENT '证件号',
  `Phone` varchar(20) DEFAULT NULL COMMENT '电话号',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10003 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passengers`
--

LOCK TABLES `passengers` WRITE;
/*!40000 ALTER TABLE `passengers` DISABLE KEYS */;
INSERT INTO `passengers` VALUES (10000,'韩超',NULL,'220802147895655','12121222222'),(10001,'李四',NULL,'111111111111','1111111111'),(10002,'王五',NULL,'12312311111111111','12312312313');
/*!40000 ALTER TABLE `passengers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket` (
  `Flight` varchar(10) NOT NULL DEFAULT '' COMMENT '航班号',
  `Name` varchar(50) DEFAULT NULL COMMENT '乘客姓名',
  `Start_time` varchar(40) DEFAULT NULL COMMENT '出发时间',
  `End_time` varchar(40) DEFAULT NULL COMMENT '到达时间',
  `Start` varchar(40) DEFAULT NULL COMMENT '始发机场',
  `Terminus` varchar(40) DEFAULT NULL COMMENT '目的机场',
  `Company` varchar(30) DEFAULT NULL COMMENT '航空公司',
  `Price` float(8,2) DEFAULT NULL COMMENT '机票价格',
  `Flight_type` varchar(50) DEFAULT NULL COMMENT '飞机类型',
  `Sit` varchar(10) DEFAULT NULL COMMENT '座位'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES ('BS1155','韩超','2016-05-25 22:30:00','2016-05-26 22:30:00','北京','上海','XX航空公司',899.00,NULL,'200'),('BS1155','韩超','2016-05-25 22:30:00','2016-05-26 22:30:00','北京','上海','XX航空公司',899.00,NULL,'199');
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) DEFAULT NULL,
  `Password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10003 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10000,'管理员','123456'),(10001,'韩超','123456'),(10002,'王五','123123');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-27 10:30:19
