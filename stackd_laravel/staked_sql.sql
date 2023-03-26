/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.11-MariaDB : Database - loveria
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


/*Table structure for table `abuse_reports` */

DROP TABLE IF EXISTS `abuse_reports`;

CREATE TABLE `abuse_reports` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `for_users__id` int(10) unsigned NOT NULL,
  `by_users__id` int(10) unsigned NOT NULL,
  `reason` varchar(255) NOT NULL,
  `moderator_remarks` varchar(255) DEFAULT NULL,
  `moderated_by_users__id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_abuse_reports_users1_idx` (`for_users__id`),
  KEY `fk_abuse_reports_users2_idx` (`by_users__id`),
  KEY `fk_abuse_reports_users3_idx` (`moderated_by_users__id`),
  CONSTRAINT `fk_abuse_reports_users1` FOREIGN KEY (`for_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_abuse_reports_users2` FOREIGN KEY (`by_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_abuse_reports_users3` FOREIGN KEY (`moderated_by_users__id`) REFERENCES `users` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `abuse_reports` */

/*Table structure for table `activity_logs` */

DROP TABLE IF EXISTS `activity_logs`;

CREATE TABLE `activity_logs` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `__data` text DEFAULT NULL,
  `entity_type` tinyint(3) unsigned DEFAULT NULL,
  `project_id` int(10) unsigned DEFAULT NULL COMMENT 'Short description',
  `action_type` tinyint(3) unsigned DEFAULT NULL COMMENT 'Create, Update, Delete',
  `entity_id` int(10) unsigned DEFAULT NULL,
  `user_role_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8;

/*Data for the table `activity_logs` */

insert  into `activity_logs`(`_id`,`created_at`,`user_id`,`__data`,`entity_type`,`project_id`,`action_type`,`entity_id`,`user_role_id`) values 
(1,'2021-10-25 13:35:00',1,'loveria Admin upload new photos.',NULL,NULL,NULL,NULL,NULL),
(2,'2021-10-25 13:36:21',1,'loveria Admin upload new photos.',NULL,NULL,NULL,NULL,NULL),
(3,'2021-10-25 13:37:06',1,'loveria Admin upload new photos.',NULL,NULL,NULL,NULL,NULL),
(4,'2021-10-27 03:12:45',1,'Site configuration settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(5,'2021-10-27 03:17:17',25,'  update profile picture.',NULL,NULL,NULL,NULL,NULL),
(6,'2021-10-27 03:19:11',25,'  update cover picture.',NULL,NULL,NULL,NULL,NULL),
(7,'2021-10-27 08:53:18',1,'Site configuration settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(8,'2021-10-27 11:17:42',1,'Site configuration settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(9,'2021-10-27 11:46:26',1,'Site configuration settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(10,'2021-10-27 11:59:14',NULL,'  update own location.',NULL,NULL,NULL,NULL,NULL),
(11,'2021-10-27 12:12:46',1,'Site configuration settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(12,'2021-10-28 02:34:57',NULL,'  update own location.',NULL,NULL,NULL,NULL,NULL),
(13,'2021-10-28 02:35:41',50,'  update cover picture.',NULL,NULL,NULL,NULL,NULL),
(14,'2021-10-28 02:40:42',NULL,'  update own location.',NULL,NULL,NULL,NULL,NULL),
(15,'2021-10-28 02:46:20',51,'  update cover picture.',NULL,NULL,NULL,NULL,NULL),
(16,'2021-10-28 02:55:48',51,'User settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(17,'2021-10-28 02:56:03',51,'User settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(18,'2021-10-28 02:56:12',51,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(19,'2021-10-28 02:57:29',51,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(20,'2021-10-28 03:50:27',51,'User settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(21,'2021-10-28 06:49:51',50,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(22,'2021-10-28 06:50:55',50,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(23,'2021-10-28 06:50:58',50,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(24,'2021-10-28 06:51:00',50,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(25,'2021-10-28 06:51:06',50,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(26,'2021-10-28 06:51:11',50,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(27,'2021-10-28 06:52:22',50,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(28,'2021-11-01 00:28:36',1,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(29,'2021-11-01 00:28:59',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(30,'2021-11-01 00:29:52',1,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(31,'2021-11-01 00:29:57',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(32,'2021-11-01 00:31:11',50,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(33,'2021-11-01 00:32:20',50,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(34,'2021-11-01 00:34:01',50,'User settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(35,'2021-11-01 00:36:11',34,'123 123 update cover picture.',NULL,NULL,NULL,NULL,NULL),
(36,'2021-11-01 00:36:32',34,'  update own location.',NULL,NULL,NULL,NULL,NULL),
(37,'2021-11-01 00:36:46',50,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(38,'2021-11-01 00:36:59',34,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(39,'2021-11-01 00:37:03',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(40,'2021-11-01 00:37:47',50,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(41,'2021-11-01 01:04:00',34,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(42,'2021-11-01 01:09:50',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(43,'2021-11-01 01:09:54',34,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(44,'2021-11-01 01:10:00',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(45,'2021-11-01 01:35:38',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(46,'2021-11-01 23:49:37',1,'  update profile picture.',NULL,NULL,NULL,NULL,NULL),
(47,'2021-11-02 03:39:57',1,'User settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(48,'2021-11-02 03:40:19',1,'User settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(49,'2021-11-02 06:45:34',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(50,'2021-11-02 06:45:44',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(51,'2021-11-02 06:48:52',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(52,'2021-11-02 06:49:04',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(53,'2021-11-02 06:50:07',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(54,'2021-11-02 06:50:24',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(55,'2021-11-02 06:50:30',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(56,'2021-11-02 06:50:36',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(57,'2021-11-02 08:01:04',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(58,'2021-11-02 08:02:33',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(59,'2021-11-02 08:02:38',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(60,'2021-11-02 08:08:47',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(61,'2021-11-02 08:10:05',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(62,'2021-11-02 08:12:05',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(63,'2021-11-02 08:17:57',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(64,'2021-11-02 08:18:25',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(65,'2021-11-02 08:18:49',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(66,'2021-11-02 08:19:03',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(67,'2021-11-02 08:20:07',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(68,'2021-11-02 08:24:48',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(69,'2021-11-02 08:24:55',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(70,'2021-11-02 08:25:41',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(71,'2021-11-02 08:26:43',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(72,'2021-11-02 08:26:48',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(73,'2021-11-02 08:29:15',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(74,'2021-11-02 08:29:21',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(75,'2021-11-02 08:29:33',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(76,'2021-11-02 08:29:40',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(77,'2021-11-02 08:29:44',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(78,'2021-11-02 08:29:47',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(79,'2021-11-02 08:29:50',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(80,'2021-11-02 09:19:44',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(81,'2021-11-02 09:19:45',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(82,'2021-11-02 09:19:46',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(83,'2021-11-02 09:19:48',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(84,'2021-11-02 09:19:49',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(85,'2021-11-02 09:20:14',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(86,'2021-11-02 09:20:16',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(87,'2021-11-02 09:20:17',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(88,'2021-11-02 09:22:29',1,'Site configuration settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(89,'2021-11-02 09:23:20',1,'Site configuration settings stored / updated.',NULL,NULL,NULL,NULL,NULL),
(90,'2021-11-02 09:24:04',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(91,'2021-11-02 09:24:05',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(92,'2021-11-02 09:24:06',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(93,'2021-11-02 09:24:07',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(94,'2021-11-02 09:24:08',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(95,'2021-11-02 09:24:10',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(96,'2021-11-02 09:24:11',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(97,'2021-11-02 09:24:12',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(98,'2021-11-02 09:24:13',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(99,'2021-11-02 09:24:15',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(100,'2021-11-02 09:24:37',1,'  upload new photos.',NULL,NULL,NULL,NULL,NULL),
(103,'2021-11-02 09:33:40',1,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(104,'2021-11-02 10:24:40',1,'  update profile picture.',NULL,NULL,NULL,NULL,NULL),
(105,'2021-11-02 10:25:22',1,'  update profile picture.',NULL,NULL,NULL,NULL,NULL),
(106,'2021-11-05 07:05:54',68,'asd asd update cover picture.',NULL,NULL,NULL,NULL,NULL),
(107,'2021-11-05 08:18:48',68,'Liu 123123 update own user info.',NULL,NULL,NULL,NULL,NULL),
(108,'2021-11-05 08:18:56',68,'Liu 123123 update own user profile.',NULL,NULL,NULL,NULL,NULL),
(109,'2021-11-05 08:19:06',68,'Liu 123123 update own user profile.',NULL,NULL,NULL,NULL,NULL),
(110,'2021-11-05 08:31:37',68,'Liu 1233123 update own user info.',NULL,NULL,NULL,NULL,NULL),
(111,'2021-11-05 09:08:44',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(112,'2021-11-05 09:08:50',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(113,'2021-11-05 09:08:54',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(114,'2021-11-05 09:08:55',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(115,'2021-11-05 09:08:56',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(116,'2021-11-05 09:08:58',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(117,'2021-11-05 09:08:59',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(118,'2021-11-05 09:09:00',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(119,'2021-11-05 09:09:01',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(120,'2021-11-05 09:09:02',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(121,'2021-11-05 09:09:04',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(122,'2021-11-05 09:09:21',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(123,'2021-11-05 09:09:22',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(124,'2021-11-05 09:09:23',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(125,'2021-11-05 09:09:25',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(126,'2021-11-05 09:09:26',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(127,'2021-11-05 09:09:28',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(128,'2021-11-05 09:09:41',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(129,'2021-11-05 09:09:42',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(130,'2021-11-05 09:09:43',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(131,'2021-11-05 09:09:44',68,'asd asd update own user settings.',NULL,NULL,NULL,NULL,NULL),
(132,'2021-11-05 09:10:41',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(133,'2021-11-05 09:10:45',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(134,'2021-11-05 09:11:44',68,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(135,'2021-11-05 09:16:04',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(136,'2021-11-05 09:19:33',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(137,'2021-11-05 09:20:02',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(138,'2021-11-05 09:27:21',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(139,'2021-11-05 09:27:43',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(140,'2021-11-05 09:28:36',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(141,'2021-11-05 09:28:43',68,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(142,'2021-11-05 09:29:02',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(143,'2021-11-05 09:48:52',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(144,'2021-11-05 09:48:56',68,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(145,'2021-11-05 09:49:01',68,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(146,'2021-11-05 09:49:05',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(147,'2021-11-05 09:49:09',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(148,'2021-11-05 09:49:12',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(149,'2021-11-05 09:49:23',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(150,'2021-11-05 09:49:26',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(151,'2021-11-05 09:49:29',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(152,'2021-11-05 09:49:31',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(153,'2021-11-05 09:49:50',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(154,'2021-11-05 09:50:19',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(155,'2021-11-05 09:50:25',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(156,'2021-11-05 09:50:32',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(157,'2021-11-05 10:00:47',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(158,'2021-11-05 10:02:16',34,'Liu 1233123 profile visited.',NULL,NULL,NULL,NULL,NULL),
(159,'2021-11-05 10:02:23',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(160,'2021-11-05 10:03:03',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(161,'2021-11-05 10:03:24',68,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(162,'2021-11-05 10:03:28',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(163,'2021-11-05 10:03:47',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(164,'2021-11-05 10:05:00',68,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(165,'2021-11-05 10:05:03',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(166,'2021-11-05 10:07:30',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(167,'2021-11-05 10:25:41',68,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(168,'2021-11-05 10:25:44',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(169,'2021-11-05 10:25:47',68,'  profile Disliked.',NULL,NULL,NULL,NULL,NULL),
(170,'2021-11-05 10:25:49',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(171,'2021-11-05 10:27:02',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(172,'2021-11-05 10:27:12',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(173,'2021-11-05 10:32:16',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(174,'2021-11-05 10:32:20',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(175,'2021-11-05 10:32:22',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(176,'2021-11-05 10:32:24',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(177,'2021-11-05 10:32:26',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(178,'2021-11-05 10:32:28',68,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(179,'2021-11-05 10:37:13',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(180,'2021-11-05 10:37:46',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(181,'2021-11-05 10:37:51',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(182,'2021-11-05 10:38:00',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(183,'2021-11-05 10:38:02',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(184,'2021-11-05 10:39:01',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(185,'2021-11-05 10:39:03',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(186,'2021-11-05 10:39:05',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(187,'2021-11-05 10:39:07',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(188,'2021-11-05 10:44:00',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(189,'2021-11-05 10:44:04',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(190,'2021-11-05 10:44:06',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(191,'2021-11-05 10:44:09',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(192,'2021-11-05 10:50:38',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(193,'2021-11-05 10:51:29',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(194,'2021-11-05 10:51:35',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(195,'2021-11-05 11:24:40',34,'adsf asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(196,'2021-11-05 11:24:40',34,'adsf asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(197,'2021-11-05 11:29:00',34,'adsf asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(198,'2021-11-05 11:32:15',34,'testtest asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(199,'2021-11-05 12:39:20',34,'asdfasdf asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(200,'2021-11-05 12:40:30',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(201,'2021-11-05 12:55:14',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(202,'2021-11-05 12:55:26',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(203,'2021-11-05 12:57:11',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(204,'2021-11-05 12:58:37',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(205,'2021-11-05 12:59:19',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(206,'2021-11-05 13:01:41',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(207,'2021-11-05 13:01:55',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(208,'2021-11-05 13:01:55',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(209,'2021-11-05 13:02:19',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(210,'2021-11-05 13:02:19',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(211,'2021-11-05 13:02:30',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(212,'2021-11-05 13:02:46',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(213,'2021-11-05 13:02:46',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(214,'2021-11-05 13:03:07',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(215,'2021-11-05 13:03:20',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(216,'2021-11-05 13:03:28',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(217,'2021-11-05 13:03:42',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(218,'2021-11-05 13:03:42',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(219,'2021-11-05 13:04:25',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(220,'2021-11-05 13:04:46',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(221,'2021-11-05 13:13:07',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(222,'2021-11-05 13:13:20',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(223,'2021-11-05 13:13:40',34,'qqqq asdf update own user profile.',NULL,NULL,NULL,NULL,NULL),
(224,'2021-11-05 13:15:27',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(225,'2021-11-05 13:17:13',34,'qqqq asdf update own user info.',NULL,NULL,NULL,NULL,NULL),
(226,'2021-11-05 13:24:12',34,'qqqq asdf adf adf update own user info.',NULL,NULL,NULL,NULL,NULL),
(227,'2021-11-05 13:24:44',34,'qqqq lastname update own user info.',NULL,NULL,NULL,NULL,NULL),
(228,'2021-11-05 13:25:54',34,'qqqq lastname update own location.',NULL,NULL,NULL,NULL,NULL),
(229,'2021-11-05 13:26:16',34,'qqqq lastname update own location.',NULL,NULL,NULL,NULL,NULL),
(230,'2021-11-05 23:44:02',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(231,'2021-11-05 23:45:08',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(232,'2021-11-05 23:45:09',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(233,'2021-11-05 23:45:11',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(234,'2021-11-05 23:45:13',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(235,'2021-11-05 23:45:17',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(236,'2021-11-05 23:45:19',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(237,'2021-11-05 23:45:53',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(238,'2021-11-05 23:45:55',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(239,'2021-11-05 23:46:00',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(240,'2021-11-05 23:46:04',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(241,'2021-11-05 23:51:45',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(242,'2021-11-05 23:51:51',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(243,'2021-11-05 23:51:54',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(244,'2021-11-05 23:51:58',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(245,'2021-11-05 23:52:00',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(246,'2021-11-05 23:52:12',34,'ddddsdf 123 update own user settings.',NULL,NULL,NULL,NULL,NULL),
(247,'2021-11-05 23:52:36',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(248,'2021-11-05 23:53:13',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(249,'2021-11-05 23:53:13',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(250,'2021-11-05 23:53:14',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(251,'2021-11-05 23:53:15',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(252,'2021-11-05 23:53:15',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(253,'2021-11-05 23:53:16',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(254,'2021-11-05 23:53:17',34,'ddddsdf 123 upload new photos.',NULL,NULL,NULL,NULL,NULL),
(255,'2021-11-05 23:54:34',34,'qqqq lastname update own location.',NULL,NULL,NULL,NULL,NULL),
(256,'2021-11-05 23:54:51',34,'qqqq lastname update own location.',NULL,NULL,NULL,NULL,NULL),
(257,'2021-11-05 23:56:24',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(258,'2021-11-05 23:56:26',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(259,'2021-11-05 23:56:31',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(260,'2021-11-05 23:59:15',34,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(261,'2021-11-05 23:59:17',34,'Liu 1233123 profile liked.',NULL,NULL,NULL,NULL,NULL),
(262,'2021-11-05 23:59:40',34,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(263,'2021-11-06 00:01:36',34,'ddddsdf 123 update profile picture.',NULL,NULL,NULL,NULL,NULL),
(264,'2021-11-06 04:58:37',1,'loveria Admin update own user profile.',NULL,NULL,NULL,NULL,NULL),
(265,'2021-11-06 05:01:55',1,'qqqq lastname profile visited.',NULL,NULL,NULL,NULL,NULL),
(266,'2021-11-06 05:10:38',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(267,'2021-11-06 05:10:44',1,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(268,'2021-11-06 09:00:51',NULL,'  update own location.',NULL,NULL,NULL,NULL,NULL),
(269,'2021-11-06 09:01:29',69,'qqqq lastname profile visited.',NULL,NULL,NULL,NULL,NULL),
(270,'2021-11-06 09:01:48',69,'  profile visited.',NULL,NULL,NULL,NULL,NULL),
(271,'2021-11-06 09:01:57',69,'  profile liked.',NULL,NULL,NULL,NULL,NULL),
(272,'2021-11-06 09:03:10',69,' latst update own user info.',NULL,NULL,NULL,NULL,NULL),
(273,'2021-11-06 09:03:10',69,' latst update own user profile.',NULL,NULL,NULL,NULL,NULL),
(274,'2021-11-06 09:03:34',69,' latst update own location.',NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `chats` */

DROP TABLE IF EXISTS `chats`;

CREATE TABLE `chats` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL COMMENT 'Sent,delivered,seen/read',
  `message` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `type` tinyint(3) unsigned NOT NULL COMMENT 'Text,image,emoji,video,audio, audio call init, video call init, giphy, accept message. Declined message',
  `from_users__id` int(10) unsigned NOT NULL,
  `to_users__id` int(10) unsigned NOT NULL,
  `items__id` int(10) unsigned DEFAULT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `integrity_id` char(36) NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_chats_users1_idx` (`from_users__id`),
  KEY `fk_chats_users2_idx` (`to_users__id`),
  KEY `fk_chats_items1_idx` (`items__id`),
  KEY `fk_chats_users3_idx` (`users__id`),
  CONSTRAINT `fk_chats_items1` FOREIGN KEY (`items__id`) REFERENCES `items` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_chats_users1` FOREIGN KEY (`from_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_chats_users2` FOREIGN KEY (`to_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_chats_users3` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `chats` */

insert  into `chats`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`message`,`type`,`from_users__id`,`to_users__id`,`items__id`,`users__id`,`integrity_id`) values 
(15,'db1a88a2-07be-4291-af05-a0be82c08237','2021-11-01 00:45:58','2021-11-01 00:45:58',1,'Message Request',10,50,34,NULL,50,'156f9e4b-b0f8-4102-9bdb-d13bc5ea40a8'),
(16,'3918e8b7-dffb-444d-a595-88c18e296afc','2021-11-01 00:45:58','2021-11-01 00:45:58',1,'Message Request',10,50,34,NULL,34,'156f9e4b-b0f8-4102-9bdb-d13bc5ea40a8'),
(17,'9a3b41fd-f849-474a-ba54-90a9cffa1c6f','2021-11-01 00:45:58','2021-11-01 00:45:58',1,'Hi',1,50,34,NULL,50,'61780c04-b88f-4bdc-8fa1-6eff0bf462b9'),
(18,'5e7ca1c9-81e4-43db-8b1f-f292add46705','2021-11-01 00:45:58','2021-11-01 00:45:58',1,'Hi',1,50,34,NULL,34,'61780c04-b88f-4bdc-8fa1-6eff0bf462b9'),
(19,'8cadf450-a65a-4fb9-98f0-809f9a45f418','2021-11-01 00:46:42','2021-11-01 00:46:42',1,'iH',1,34,50,NULL,34,'5f0a0dd5-9dba-421d-8b5e-b82b0914ff7c'),
(20,'caee6562-2971-4c1f-8bc2-4b8f9a8f426d','2021-11-01 00:46:42','2021-11-01 00:46:42',1,'iH',1,34,50,NULL,50,'5f0a0dd5-9dba-421d-8b5e-b82b0914ff7c'),
(25,'0ba09387-c341-4aea-8252-bc9b01b69a1e','2021-11-01 00:48:54','2021-11-01 00:48:54',1,'????✌???',1,50,34,NULL,50,'879e0c5b-26bf-4580-babf-84687e8d365c'),
(26,'ae71fd69-5113-44a8-80a7-5967a5be62e7','2021-11-01 00:48:54','2021-11-01 00:48:54',1,'????✌???',1,50,34,NULL,34,'879e0c5b-26bf-4580-babf-84687e8d365c'),
(27,'fa23e4d2-4bf2-485e-8117-166291735a44','2021-11-01 01:04:46','2021-11-01 01:04:46',1,'Message Request',9,34,43,NULL,34,'aa2565cb-741d-4816-9de0-c249258bfe32'),
(28,'f9a4a35f-ab8a-4bd9-92de-46a48c19d4c0','2021-11-01 01:04:46','2021-11-01 01:04:46',1,'Message Request',9,34,43,NULL,43,'aa2565cb-741d-4816-9de0-c249258bfe32'),
(29,'0f7b137a-c431-4d92-995f-0132d613a311','2021-11-01 01:04:46','2021-11-01 01:04:46',1,'this is wrong text direction.',1,34,43,NULL,34,'b5576d59-5e2a-4b62-82fd-e2c55aec9e7e'),
(30,'42aae7e7-19de-44e0-9f6e-0ebe9ebbcf97','2021-11-01 01:04:46','2021-11-01 01:04:46',1,'this is wrong text direction.',1,34,43,NULL,43,'b5576d59-5e2a-4b62-82fd-e2c55aec9e7e');

/*Table structure for table `cities` */

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` mediumint(8) unsigned NOT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_cities_states1_idx` (`state_id`),
  CONSTRAINT `fk_cities_states1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `cities` */

insert  into `cities`(`id`,`name`,`state_id`,`state_code`,`country_code`,`latitude`,`longitude`,`created_at`,`updated_at`) values 
(1,'city',1,'st','AF',40.00000000,39.00000000,'2021-10-27 14:45:47','2021-10-27 14:48:10');

/*Table structure for table `configurations` */

DROP TABLE IF EXISTS `configurations`;

CREATE TABLE `configurations` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `name` varchar(45) NOT NULL,
  `value` text DEFAULT NULL,
  `data_type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Data for the table `configurations` */

insert  into `configurations`(`_id`,`created_at`,`updated_at`,`name`,`value`,`data_type`) values 
(1,'2021-09-28 10:04:20','2021-09-28 10:04:20','booster_period','5',3),
(2,'2021-09-28 10:04:20','2021-09-28 10:04:20','booster_price','5',3),
(3,'2021-09-28 10:04:20','2021-09-28 10:04:20','booster_price_for_premium_user','5',3),
(4,'2021-09-28 14:10:50','2021-09-28 14:10:50','currency','USD',1),
(5,'2021-09-28 14:10:50','2021-09-28 14:10:50','currency_value','USD',1),
(6,'2021-09-28 14:10:50','2021-09-28 14:10:50','currency_symbol','$',1),
(7,'2021-09-28 14:10:50','2021-09-28 14:10:50','round_zero_decimal_currency','1',2),
(9,'2021-10-11 11:44:07','2021-10-11 11:44:07','allow_user_to_change_theme','0',2),
(16,'2021-10-11 11:45:11','2021-10-11 11:45:11','color_theme','dark',1),
(17,'2021-10-11 11:45:11','2021-10-11 11:45:11','name','STACKD',1),
(18,'2021-10-11 11:45:11','2021-10-11 11:45:11','business_email','your-business-email@domain.com',1),
(19,'2021-10-11 11:45:11','2021-10-11 11:45:11','contact_email','your-contact-email@domain.com',1),
(20,'2021-10-11 11:45:11','2021-10-11 11:45:11','timezone','UTC',1),
(21,'2021-10-11 11:45:11','2021-10-11 11:45:11','distance_measurement','3959',1),
(22,'2021-10-11 11:45:11','2021-10-11 11:45:11','default_language','en_US',1),
(23,'2021-10-11 11:46:57','2021-10-11 11:46:57','header_advertisement','{\"title\":\"X  (Appear in Header)\",\"height\":\"728\",\"width\":\"90\",\"status\":\"true\",\"content\":\"This is Header Add\"}',4),
(24,'2021-10-11 11:46:57','2021-10-11 11:46:57','footer_advertisement','{\"title\":\"X  (Appear in Footer)\",\"height\":\"728\",\"width\":\"90\",\"status\":\"false\",\"content\":null}',4),
(25,'2021-10-11 11:46:57','2021-10-11 11:46:57','user_sidebar_advertisement','{\"title\":\"X  (Appear in User Sidebar)\",\"height\":\"200\",\"width\":\"200\",\"status\":\"false\",\"content\":null}',4),
(28,'2021-10-21 10:16:10','2021-10-21 10:16:10','google_map_key','AIzaSyDLtHLq_cVCMMvZkmINNpwH_C5N42pagws',1),
(31,'2021-10-27 12:12:46','2021-10-27 12:12:46','use_static_city_data','0',2),
(32,'2021-10-27 12:12:46','2021-10-27 12:12:46','allow_google_map','1',2),
(34,'2021-11-02 09:22:29','2021-11-02 09:22:29','terms_and_conditions_url','aaa',1),
(35,'2021-11-02 09:22:29','2021-11-02 09:22:29','user_photo_restriction','200',1);

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `_id` smallint(5) unsigned NOT NULL,
  `iso_code` char(2) DEFAULT NULL,
  `name_capitalized` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `iso3_code` char(3) DEFAULT NULL,
  `iso_num_code` smallint(6) DEFAULT NULL,
  `phone_code` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `countries` */

insert  into `countries`(`_id`,`iso_code`,`name_capitalized`,`name`,`iso3_code`,`iso_num_code`,`phone_code`) values 
(1,'AF','AFGHANISTAN','Afghanistan','AFG',4,93),
(2,'AL','ALBANIA','Albania','ALB',8,355),
(3,'DZ','ALGERIA','Algeria','DZA',12,213),
(4,'AS','AMERICAN SAMOA','American Samoa','ASM',16,1684),
(5,'AD','ANDORRA','Andorra','AND',20,376),
(6,'AO','ANGOLA','Angola','AGO',24,244),
(7,'AI','ANGUILLA','Anguilla','AIA',660,1264),
(8,'AQ','ANTARCTICA','Antarctica',NULL,NULL,0),
(9,'AG','ANTIGUA AND BARBUDA','Antigua and Barbuda','ATG',28,1268),
(10,'AR','ARGENTINA','Argentina','ARG',32,54),
(11,'AM','ARMENIA','Armenia','ARM',51,374),
(12,'AW','ARUBA','Aruba','ABW',533,297),
(13,'AU','AUSTRALIA','Australia','AUS',36,61),
(14,'AT','AUSTRIA','Austria','AUT',40,43),
(15,'AZ','AZERBAIJAN','Azerbaijan','AZE',31,994),
(16,'BS','BAHAMAS','Bahamas','BHS',44,1242),
(17,'BH','BAHRAIN','Bahrain','BHR',48,973),
(18,'BD','BANGLADESH','Bangladesh','BGD',50,880),
(19,'BB','BARBADOS','Barbados','BRB',52,1246),
(20,'BY','BELARUS','Belarus','BLR',112,375),
(21,'BE','BELGIUM','Belgium','BEL',56,32),
(22,'BZ','BELIZE','Belize','BLZ',84,501),
(23,'BJ','BENIN','Benin','BEN',204,229),
(24,'BM','BERMUDA','Bermuda','BMU',60,1441),
(25,'BT','BHUTAN','Bhutan','BTN',64,975),
(26,'BO','BOLIVIA','Bolivia','BOL',68,591),
(27,'BA','BOSNIA AND HERZEGOVINA','Bosnia and Herzegovina','BIH',70,387),
(28,'BW','BOTSWANA','Botswana','BWA',72,267),
(29,'BV','BOUVET ISLAND','Bouvet Island',NULL,NULL,0),
(30,'BR','BRAZIL','Brazil','BRA',76,55),
(31,'IO','BRITISH INDIAN OCEAN TERRITORY','British Indian Ocean Territory',NULL,NULL,246),
(32,'BN','BRUNEI DARUSSALAM','Brunei Darussalam','BRN',96,673),
(33,'BG','BULGARIA','Bulgaria','BGR',100,359),
(34,'BF','BURKINA FASO','Burkina Faso','BFA',854,226),
(35,'BI','BURUNDI','Burundi','BDI',108,257),
(36,'KH','CAMBODIA','Cambodia','KHM',116,855),
(37,'CM','CAMEROON','Cameroon','CMR',120,237),
(38,'CA','CANADA','Canada','CAN',124,1),
(39,'CV','CAPE VERDE','Cape Verde','CPV',132,238),
(40,'KY','CAYMAN ISLANDS','Cayman Islands','CYM',136,1345),
(41,'CF','CENTRAL AFRICAN REPUBLIC','Central African Republic','CAF',140,236),
(42,'TD','CHAD','Chad','TCD',148,235),
(43,'CL','CHILE','Chile','CHL',152,56),
(44,'CN','CHINA','China','CHN',156,86),
(45,'CX','CHRISTMAS ISLAND','Christmas Island',NULL,NULL,61),
(46,'CC','COCOS (KEELING) ISLANDS','Cocos (Keeling) Islands',NULL,NULL,672),
(47,'CO','COLOMBIA','Colombia','COL',170,57),
(48,'KM','COMOROS','Comoros','COM',174,269),
(49,'CG','CONGO','Congo','COG',178,242),
(50,'CD','CONGO, THE DEMOCRATIC REPUBLIC OF THE','Congo, the Democratic Republic of the','COD',180,243),
(51,'CK','COOK ISLANDS','Cook Islands','COK',184,682),
(52,'CR','COSTA RICA','Costa Rica','CRI',188,506),
(53,'CI','COTE D\'IVOIRE','Cote D\'Ivoire','CIV',384,225),
(54,'HR','CROATIA','Croatia','HRV',191,385),
(55,'CU','CUBA','Cuba','CUB',192,53),
(56,'CY','CYPRUS','Cyprus','CYP',196,357),
(57,'CZ','CZECH REPUBLIC','Czech Republic','CZE',203,420),
(58,'DK','DENMARK','Denmark','DNK',208,45),
(59,'DJ','DJIBOUTI','Djibouti','DJI',262,253),
(60,'DM','DOMINICA','Dominica','DMA',212,1767),
(61,'DO','DOMINICAN REPUBLIC','Dominican Republic','DOM',214,1809),
(62,'EC','ECUADOR','Ecuador','ECU',218,593),
(63,'EG','EGYPT','Egypt','EGY',818,20),
(64,'SV','EL SALVADOR','El Salvador','SLV',222,503),
(65,'GQ','EQUATORIAL GUINEA','Equatorial Guinea','GNQ',226,240),
(66,'ER','ERITREA','Eritrea','ERI',232,291),
(67,'EE','ESTONIA','Estonia','EST',233,372),
(68,'ET','ETHIOPIA','Ethiopia','ETH',231,251),
(69,'FK','FALKLAND ISLANDS (MALVINAS)','Falkland Islands (Malvinas)','FLK',238,500),
(70,'FO','FAROE ISLANDS','Faroe Islands','FRO',234,298),
(71,'FJ','FIJI','Fiji','FJI',242,679),
(72,'FI','FINLAND','Finland','FIN',246,358),
(73,'FR','FRANCE','France','FRA',250,33),
(74,'GF','FRENCH GUIANA','French Guiana','GUF',254,594),
(75,'PF','FRENCH POLYNESIA','French Polynesia','PYF',258,689),
(76,'TF','FRENCH SOUTHERN TERRITORIES','French Southern Territories',NULL,NULL,0),
(77,'GA','GABON','Gabon','GAB',266,241),
(78,'GM','GAMBIA','Gambia','GMB',270,220),
(79,'GE','GEORGIA','Georgia','GEO',268,995),
(80,'DE','GERMANY','Germany','DEU',276,49),
(81,'GH','GHANA','Ghana','GHA',288,233),
(82,'GI','GIBRALTAR','Gibraltar','GIB',292,350),
(83,'GR','GREECE','Greece','GRC',300,30),
(84,'GL','GREENLAND','Greenland','GRL',304,299),
(85,'GD','GRENADA','Grenada','GRD',308,1473),
(86,'GP','GUADELOUPE','Guadeloupe','GLP',312,590),
(87,'GU','GUAM','Guam','GUM',316,1671),
(88,'GT','GUATEMALA','Guatemala','GTM',320,502),
(89,'GN','GUINEA','Guinea','GIN',324,224),
(90,'GW','GUINEA-BISSAU','Guinea-Bissau','GNB',624,245),
(91,'GY','GUYANA','Guyana','GUY',328,592),
(92,'HT','HAITI','Haiti','HTI',332,509),
(93,'HM','HEARD ISLAND AND MCDONALD ISLANDS','Heard Island and Mcdonald Islands',NULL,NULL,0),
(94,'VA','HOLY SEE (VATICAN CITY STATE)','Holy See (Vatican City State)','VAT',336,39),
(95,'HN','HONDURAS','Honduras','HND',340,504),
(96,'HK','HONG KONG','Hong Kong','HKG',344,852),
(97,'HU','HUNGARY','Hungary','HUN',348,36),
(98,'IS','ICELAND','Iceland','ISL',352,354),
(99,'IN','INDIA','India','IND',356,91),
(100,'ID','INDONESIA','Indonesia','IDN',360,62),
(101,'IR','IRAN, ISLAMIC REPUBLIC OF','Iran, Islamic Republic of','IRN',364,98),
(102,'IQ','IRAQ','Iraq','IRQ',368,964),
(103,'IE','IRELAND','Ireland','IRL',372,353),
(104,'IL','ISRAEL','Israel','ISR',376,972),
(105,'IT','ITALY','Italy','ITA',380,39),
(106,'JM','JAMAICA','Jamaica','JAM',388,1876),
(107,'JP','JAPAN','Japan','JPN',392,81),
(108,'JO','JORDAN','Jordan','JOR',400,962),
(109,'KZ','KAZAKHSTAN','Kazakhstan','KAZ',398,7),
(110,'KE','KENYA','Kenya','KEN',404,254),
(111,'KI','KIRIBATI','Kiribati','KIR',296,686),
(112,'KP','KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF','Korea, Democratic People\'s Republic of','PRK',408,850),
(113,'KR','KOREA, REPUBLIC OF','Korea, Republic of','KOR',410,82),
(114,'KW','KUWAIT','Kuwait','KWT',414,965),
(115,'KG','KYRGYZSTAN','Kyrgyzstan','KGZ',417,996),
(116,'LA','LAO PEOPLE\'S DEMOCRATIC REPUBLIC','Lao People\'s Democratic Republic','LAO',418,856),
(117,'LV','LATVIA','Latvia','LVA',428,371),
(118,'LB','LEBANON','Lebanon','LBN',422,961),
(119,'LS','LESOTHO','Lesotho','LSO',426,266),
(120,'LR','LIBERIA','Liberia','LBR',430,231),
(121,'LY','LIBYAN ARAB JAMAHIRIYA','Libyan Arab Jamahiriya','LBY',434,218),
(122,'LI','LIECHTENSTEIN','Liechtenstein','LIE',438,423),
(123,'LT','LITHUANIA','Lithuania','LTU',440,370),
(124,'LU','LUXEMBOURG','Luxembourg','LUX',442,352),
(125,'MO','MACAO','Macao','MAC',446,853),
(126,'MK','MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','Macedonia, the Former Yugoslav Republic of','MKD',807,389),
(127,'MG','MADAGASCAR','Madagascar','MDG',450,261),
(128,'MW','MALAWI','Malawi','MWI',454,265),
(129,'MY','MALAYSIA','Malaysia','MYS',458,60),
(130,'MV','MALDIVES','Maldives','MDV',462,960),
(131,'ML','MALI','Mali','MLI',466,223),
(132,'MT','MALTA','Malta','MLT',470,356),
(133,'MH','MARSHALL ISLANDS','Marshall Islands','MHL',584,692),
(134,'MQ','MARTINIQUE','Martinique','MTQ',474,596),
(135,'MR','MAURITANIA','Mauritania','MRT',478,222),
(136,'MU','MAURITIUS','Mauritius','MUS',480,230),
(137,'YT','MAYOTTE','Mayotte',NULL,NULL,269),
(138,'MX','MEXICO','Mexico','MEX',484,52),
(139,'FM','MICRONESIA, FEDERATED STATES OF','Micronesia, Federated States of','FSM',583,691),
(140,'MD','MOLDOVA, REPUBLIC OF','Moldova, Republic of','MDA',498,373),
(141,'MC','MONACO','Monaco','MCO',492,377),
(142,'MN','MONGOLIA','Mongolia','MNG',496,976),
(143,'MS','MONTSERRAT','Montserrat','MSR',500,1664),
(144,'MA','MOROCCO','Morocco','MAR',504,212),
(145,'MZ','MOZAMBIQUE','Mozambique','MOZ',508,258),
(146,'MM','MYANMAR','Myanmar','MMR',104,95),
(147,'NA','NAMIBIA','Namibia','NAM',516,264),
(148,'NR','NAURU','Nauru','NRU',520,674),
(149,'NP','NEPAL','Nepal','NPL',524,977),
(150,'NL','NETHERLANDS','Netherlands','NLD',528,31),
(151,'AN','NETHERLANDS ANTILLES','Netherlands Antilles','ANT',530,599),
(152,'NC','NEW CALEDONIA','New Caledonia','NCL',540,687),
(153,'NZ','NEW ZEALAND','New Zealand','NZL',554,64),
(154,'NI','NICARAGUA','Nicaragua','NIC',558,505),
(155,'NE','NIGER','Niger','NER',562,227),
(156,'NG','NIGERIA','Nigeria','NGA',566,234),
(157,'NU','NIUE','Niue','NIU',570,683),
(158,'NF','NORFOLK ISLAND','Norfolk Island','NFK',574,672),
(159,'MP','NORTHERN MARIANA ISLANDS','Northern Mariana Islands','MNP',580,1670),
(160,'NO','NORWAY','Norway','NOR',578,47),
(161,'OM','OMAN','Oman','OMN',512,968),
(162,'PK','PAKISTAN','Pakistan','PAK',586,92),
(163,'PW','PALAU','Palau','PLW',585,680),
(164,'PS','PALESTINIAN TERRITORY, OCCUPIED','Palestinian Territory, Occupied',NULL,NULL,970),
(165,'PA','PANAMA','Panama','PAN',591,507),
(166,'PG','PAPUA NEW GUINEA','Papua New Guinea','PNG',598,675),
(167,'PY','PARAGUAY','Paraguay','PRY',600,595),
(168,'PE','PERU','Peru','PER',604,51),
(169,'PH','PHILIPPINES','Philippines','PHL',608,63),
(170,'PN','PITCAIRN','Pitcairn','PCN',612,0),
(171,'PL','POLAND','Poland','POL',616,48),
(172,'PT','PORTUGAL','Portugal','PRT',620,351),
(173,'PR','PUERTO RICO','Puerto Rico','PRI',630,1787),
(174,'QA','QATAR','Qatar','QAT',634,974),
(175,'RE','REUNION','Reunion','REU',638,262),
(176,'RO','ROMANIA','Romania','ROM',642,40),
(177,'RU','RUSSIAN FEDERATION','Russian Federation','RUS',643,7),
(178,'RW','RWANDA','Rwanda','RWA',646,250),
(179,'SH','SAINT HELENA','Saint Helena','SHN',654,290),
(180,'KN','SAINT KITTS AND NEVIS','Saint Kitts and Nevis','KNA',659,1869),
(181,'LC','SAINT LUCIA','Saint Lucia','LCA',662,1758),
(182,'PM','SAINT PIERRE AND MIQUELON','Saint Pierre and Miquelon','SPM',666,508),
(183,'VC','SAINT VINCENT AND THE GRENADINES','Saint Vincent and the Grenadines','VCT',670,1784),
(184,'WS','SAMOA','Samoa','WSM',882,684),
(185,'SM','SAN MARINO','San Marino','SMR',674,378),
(186,'ST','SAO TOME AND PRINCIPE','Sao Tome and Principe','STP',678,239),
(187,'SA','SAUDI ARABIA','Saudi Arabia','SAU',682,966),
(188,'SN','SENEGAL','Senegal','SEN',686,221),
(190,'SC','SEYCHELLES','Seychelles','SYC',690,248),
(191,'SL','SIERRA LEONE','Sierra Leone','SLE',694,232),
(192,'SG','SINGAPORE','Singapore','SGP',702,65),
(193,'SK','SLOVAKIA','Slovakia','SVK',703,421),
(194,'SI','SLOVENIA','Slovenia','SVN',705,386),
(195,'SB','SOLOMON ISLANDS','Solomon Islands','SLB',90,677),
(196,'SO','SOMALIA','Somalia','SOM',706,252),
(197,'ZA','SOUTH AFRICA','South Africa','ZAF',710,27),
(198,'GS','SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS','South Georgia and the South Sandwich Islands',NULL,NULL,0),
(199,'ES','SPAIN','Spain','ESP',724,34),
(200,'LK','SRI LANKA','Sri Lanka','LKA',144,94),
(201,'SD','SUDAN','Sudan','SDN',736,249),
(202,'SR','SURINAME','Suriname','SUR',740,597),
(203,'SJ','SVALBARD AND JAN MAYEN','Svalbard and Jan Mayen','SJM',744,47),
(204,'SZ','SWAZILAND','Swaziland','SWZ',748,268),
(205,'SE','SWEDEN','Sweden','SWE',752,46),
(206,'CH','SWITZERLAND','Switzerland','CHE',756,41),
(207,'SY','SYRIAN ARAB REPUBLIC','Syrian Arab Republic','SYR',760,963),
(208,'TW','TAIWAN, PROVINCE OF CHINA','Taiwan, Province of China','TWN',158,886),
(209,'TJ','TAJIKISTAN','Tajikistan','TJK',762,992),
(210,'TZ','TANZANIA, UNITED REPUBLIC OF','Tanzania, United Republic of','TZA',834,255),
(211,'TH','THAILAND','Thailand','THA',764,66),
(212,'TL','TIMOR-LESTE','Timor-Leste',NULL,NULL,670),
(213,'TG','TOGO','Togo','TGO',768,228),
(214,'TK','TOKELAU','Tokelau','TKL',772,690),
(215,'TO','TONGA','Tonga','TON',776,676),
(216,'TT','TRINIDAD AND TOBAGO','Trinidad and Tobago','TTO',780,1868),
(217,'TN','TUNISIA','Tunisia','TUN',788,216),
(218,'TR','TURKEY','Turkey','TUR',792,90),
(219,'TM','TURKMENISTAN','Turkmenistan','TKM',795,7370),
(220,'TC','TURKS AND CAICOS ISLANDS','Turks and Caicos Islands','TCA',796,1649),
(221,'TV','TUVALU','Tuvalu','TUV',798,688),
(222,'UG','UGANDA','Uganda','UGA',800,256),
(223,'UA','UKRAINE','Ukraine','UKR',804,380),
(224,'AE','UNITED ARAB EMIRATES','United Arab Emirates','ARE',784,971),
(225,'GB','UNITED KINGDOM','United Kingdom','GBR',826,44),
(226,'US','UNITED STATES','United States','USA',840,1),
(227,'UM','UNITED STATES MINOR OUTLYING ISLANDS','United States Minor Outlying Islands',NULL,NULL,1),
(228,'UY','URUGUAY','Uruguay','URY',858,598),
(229,'UZ','UZBEKISTAN','Uzbekistan','UZB',860,998),
(230,'VU','VANUATU','Vanuatu','VUT',548,678),
(231,'VE','VENEZUELA','Venezuela','VEN',862,58),
(232,'VN','VIET NAM','Viet Nam','VNM',704,84),
(233,'VG','VIRGIN ISLANDS, BRITISH','Virgin Islands, British','VGB',92,1284),
(234,'VI','VIRGIN ISLANDS, U.S.','Virgin Islands, U.s.','VIR',850,1340),
(235,'WF','WALLIS AND FUTUNA','Wallis and Futuna','WLF',876,681),
(236,'EH','WESTERN SAHARA','Western Sahara','ESH',732,212),
(237,'YE','YEMEN','Yemen','YEM',887,967),
(238,'ZM','ZAMBIA','Zambia','ZMB',894,260),
(239,'ZW','ZIMBABWE','Zimbabwe','ZWE',716,263),
(240,'RS','SERBIA','Serbia','SRB',688,381),
(241,'AP','ASIA PACIFIC REGION','Asia / Pacific Region','0',0,0),
(242,'ME','MONTENEGRO','Montenegro','MNE',499,382),
(243,'AX','ALAND ISLANDS','Aland Islands','ALA',248,358),
(244,'BQ','BONAIRE, SINT EUSTATIUS AND SABA','Bonaire, Sint Eustatius and Saba','BES',535,599),
(245,'CW','CURACAO','Curacao','CUW',531,599),
(246,'GG','GUERNSEY','Guernsey','GGY',831,44),
(247,'IM','ISLE OF MAN','Isle of Man','IMN',833,44),
(248,'JE','JERSEY','Jersey','JEY',832,44),
(249,'XK','KOSOVO','Kosovo','---',0,381),
(250,'BL','SAINT BARTHELEMY','Saint Barthelemy','BLM',652,590),
(251,'MF','SAINT MARTIN','Saint Martin','MAF',663,590),
(252,'SX','SINT MAARTEN','Sint Maarten','SXM',534,1),
(253,'SS','SOUTH SUDAN','South Sudan','SSD',728,211);

/*Table structure for table `credit_packages` */

DROP TABLE IF EXISTS `credit_packages`;

CREATE TABLE `credit_packages` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `credits` int(10) unsigned NOT NULL,
  `price` decimal(13,4) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `users__id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_credit_packages_users1_idx` (`users__id`),
  CONSTRAINT `fk_credit_packages_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `credit_packages` */

insert  into `credit_packages`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`title`,`credits`,`price`,`image`,`users__id`) values 
(1,'53faf91b-8d4d-4fe0-927d-23d4d43ef813','2021-09-28 10:02:15','2021-09-28 10:02:15',1,'Basic',10,2.0000,'bg-signup.jpg',1),
(2,'bd277687-5c41-407a-b2b5-f1b8b464aca5','2021-09-28 14:01:28','2021-09-28 14:01:28',1,'Medium',20,5.0000,'people-2561578-1920.jpg',1);

/*Table structure for table `credit_wallet_transactions` */

DROP TABLE IF EXISTS `credit_wallet_transactions`;

CREATE TABLE `credit_wallet_transactions` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `credits` int(11) NOT NULL COMMENT '- (minus) for debit & + for credit',
  `financial_transactions__id` int(10) unsigned DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `credit_type` tinyint(3) unsigned DEFAULT NULL COMMENT 'Purchased, bonuses',
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_credit_wallet_transactions_users1_idx` (`users__id`),
  KEY `fk_credit_wallet_transactions_financial_transactions1_idx` (`financial_transactions__id`),
  CONSTRAINT `fk_credit_wallet_transactions_financial_transactions1` FOREIGN KEY (`financial_transactions__id`) REFERENCES `financial_transactions` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_credit_wallet_transactions_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `credit_wallet_transactions` */

insert  into `credit_wallet_transactions`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`users__id`,`credits`,`financial_transactions__id`,`description`,`credit_type`) values 
(1,'bd277687-5c41-407a-b2b5-f1b8b464aca5','2021-09-28 21:23:16','2021-09-28 21:23:19',0,1,20,NULL,NULL,NULL),
(2,'ad2e601c-77e8-4774-98de-ed1de5824c6f','2021-09-28 14:25:36','2021-09-28 14:25:36',1,1,-5,NULL,NULL,NULL),
(3,'c9343205-f0a0-4342-ac4b-2a9301326e4a','2021-09-29 09:11:05','2021-09-29 09:11:05',1,1,-4,NULL,NULL,NULL),
(4,'8b1d04bd-9793-4912-a505-20020b75f6dc','2021-09-29 09:13:04','2021-09-29 09:13:04',1,1,-1,NULL,NULL,NULL);

/*Table structure for table `email_change_requests` */

DROP TABLE IF EXISTS `email_change_requests`;

CREATE TABLE `email_change_requests` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `new_email` varchar(255) NOT NULL,
  `activation_key` varchar(255) NOT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `user_authorities__id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  KEY `fk_email_change_requests_users1_idx` (`users__id`),
  KEY `fk_email_change_requests_user_authorities1_idx` (`user_authorities__id`),
  CONSTRAINT `fk_email_change_requests_user_authorities1` FOREIGN KEY (`user_authorities__id`) REFERENCES `user_authorities` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_email_change_requests_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `email_change_requests` */

/*Table structure for table `financial_transactions` */

DROP TABLE IF EXISTS `financial_transactions`;

CREATE TABLE `financial_transactions` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `amount` decimal(13,4) DEFAULT NULL,
  `__data` text DEFAULT NULL,
  `users__id` int(10) unsigned DEFAULT NULL,
  `method` varchar(15) NOT NULL,
  `currency_code` varchar(5) DEFAULT NULL,
  `is_test` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_financial_transactions_users1_idx` (`users__id`),
  CONSTRAINT `fk_financial_transactions_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `financial_transactions` */

insert  into `financial_transactions`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`amount`,`__data`,`users__id`,`method`,`currency_code`,`is_test`) values 
(1,'50ee1967-7341-4c3a-b071-f2ea0722b179','2021-09-28 21:24:19','2021-09-28 21:24:21',0,5.0000,NULL,1,'',NULL,NULL);

/*Table structure for table `gym` */

DROP TABLE IF EXISTS `gym`;

CREATE TABLE `gym` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` mediumint(8) unsigned NOT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_cities_states1_idx` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `gym` */

insert  into `gym`(`id`,`name`,`state_id`,`state_code`,`country_code`,`latitude`,`longitude`,`created_at`,`updated_at`) values 
(1,'gym',1,'st','AF',40.00000000,39.00000000,'2021-10-27 14:45:47','2021-10-27 15:44:37');

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'Gift or Sticker',
  `title` varchar(150) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `normal_price` decimal(13,4) DEFAULT NULL,
  `premium_price` varchar(45) DEFAULT NULL,
  `user_authorities__id` int(10) unsigned DEFAULT NULL,
  `premium_only` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_gifts_user_authorities1_idx` (`user_authorities__id`),
  CONSTRAINT `fk_gifts_user_authorities1` FOREIGN KEY (`user_authorities__id`) REFERENCES `user_authorities` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `items` */

insert  into `items`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`type`,`title`,`file_name`,`normal_price`,`premium_price`,`user_authorities__id`,`premium_only`) values 
(1,'7a5b7df8-ce77-45f8-9a52-2b32db417233','2021-09-28 14:06:56','2021-09-28 14:06:56',1,1,'flower','sky-2601156-1920.jpg',2.0000,'1',1,NULL),
(2,'b019c95e-f495-4fb6-bd6e-7bf3ec56e718','2021-09-28 14:07:51','2021-09-28 14:07:51',1,2,'ffter dfer','man-802062-1920.jpg',0.0000,'4',1,1);

/*Table structure for table `like_dislikes` */

DROP TABLE IF EXISTS `like_dislikes`;

CREATE TABLE `like_dislikes` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `to_users__id` int(10) unsigned NOT NULL,
  `by_users__id` int(10) unsigned NOT NULL,
  `like` tinyint(3) unsigned NOT NULL COMMENT '0 for dislike, 1 for like',
  `why` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_like_dislikes_users1_idx` (`to_users__id`),
  KEY `fk_like_dislikes_users2_idx` (`by_users__id`),
  CONSTRAINT `fk_like_dislikes_users1` FOREIGN KEY (`to_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_like_dislikes_users2` FOREIGN KEY (`by_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

/*Data for the table `like_dislikes` */

insert  into `like_dislikes`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`to_users__id`,`by_users__id`,`like`,`why`) values 
(28,'93b40773-fa5d-470b-90f0-8eb9faa37910','2021-11-05 10:32:28','2021-11-05 10:32:28',1,34,68,1,NULL),
(45,'03e9a939-7535-4c99-ae7c-39e2bbce40da','2021-11-05 23:56:24','2021-11-05 23:56:24',1,50,34,1,NULL),
(46,'32fb7e4b-d71a-42dd-b097-53725993c454','2021-11-05 23:56:26','2021-11-05 23:56:26',1,25,34,1,NULL),
(47,'56797ce7-1b24-4cea-9412-8ab92eb1f524','2021-11-05 23:56:31','2021-11-05 23:56:31',1,43,34,1,NULL),
(48,'37764dcb-5be2-4ae6-8d8d-679ba71cce1f','2021-11-05 23:59:15','2021-11-05 23:59:15',1,51,34,1,NULL),
(49,'2fa633e8-c8c0-4aff-9ccb-5548adb1af68','2021-11-05 23:59:17','2021-11-05 23:59:17',1,68,34,1,NULL),
(52,'1d2d229b-364b-40ab-b38e-5932aed7f184','2021-11-06 09:01:57','2021-11-06 09:01:57',1,51,69,1,NULL);

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempts` tinyint(4) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `login_attempts` */

/*Table structure for table `login_logs` */

DROP TABLE IF EXISTS `login_logs`;

CREATE TABLE `login_logs` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` tinyint(4) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `login_logs` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `message` varchar(500) NOT NULL,
  `action` varchar(255) NOT NULL,
  `is_read` tinyint(3) unsigned DEFAULT 0,
  `users__id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_notifications_users1_idx` (`users__id`),
  CONSTRAINT `fk_notifications_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `notifications` */

insert  into `notifications`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`message`,`action`,`is_read`,`users__id`) values 
(3,'3e19cfaa-cd61-45d1-89f5-7524ec7fc55d','2021-10-28 02:56:13','2021-10-28 02:56:13',1,'Profile visited by  ','http://localhost:8000/@pt1111',1,34),
(4,'586ad43c-9bf5-4418-9d49-fc3a731c2aae','2021-10-28 06:49:51','2021-10-28 06:49:51',1,'Profile visited by  ','http://localhost:8000/@123123123',NULL,51),
(5,'4e62056b-7888-4260-b5e3-9c52ccc60591','2021-10-28 06:52:22','2021-10-28 06:52:22',1,'Profile visited by  ','http://localhost:8000/@123123123',NULL,43),
(6,'f53db8fb-6243-4cb8-868e-5d029e5b310f','2021-11-01 00:28:36','2021-11-01 00:28:36',1,'Profile visited by loveria Admin','http://localhost:8000/@admin',NULL,51),
(7,'6693697a-fd09-44c6-83cf-48c130cc750d','2021-11-01 00:29:52','2021-11-01 00:29:52',1,'Profile visited by loveria Admin','http://localhost:8000/@admin',1,50),
(8,'09286f08-7fa5-4c79-906f-2c741f8f312b','2021-11-01 00:31:11','2021-11-01 00:31:11',1,'Profile visited by  ','http://127.0.0.1:8000/@123123123',NULL,33),
(9,'5b08d0c2-ec5c-4081-ae10-080336fadaa4','2021-11-01 00:32:20','2021-11-01 00:32:20',1,'Profile visited by  ','http://127.0.0.1:8000/@123123123',NULL,25),
(10,'2b7f31ee-990e-4398-b0da-c719ec3e8bdc','2021-11-01 00:35:29','2021-11-01 00:35:29',1,'  is online now. ','http://localhost:8000/@partner6',NULL,51),
(11,'ea59ec87-9876-4d57-bc9e-281fed34f1c2','2021-11-01 00:36:46','2021-11-01 00:36:46',1,'Profile visited by  ','http://127.0.0.1:8000/@123123123',1,34),
(12,'c1efe26d-9daf-4cb2-9dac-b54c9730e156','2021-11-01 00:36:59','2021-11-01 00:36:59',1,'Profile visited by  ','http://localhost:8000/@partner6',1,50),
(13,'28342814-7364-441c-bd8d-d851dcab8f00','2021-11-01 00:45:58','2021-11-01 00:45:58',1,'Message request received from  123 123','http://127.0.0.1:8000/@123123123',1,34),
(14,'ad74f78f-566d-4248-8ee2-48e62f430e2b','2021-11-01 01:04:00','2021-11-01 01:04:00',1,'Profile visited by  ','http://localhost:8000/@partner6',NULL,43),
(15,'3fe725e0-efd4-4521-bc50-5ca0775b9b04','2021-11-01 01:04:46','2021-11-01 01:04:46',1,'Message request received from  123 123','http://localhost:8000/@partner6',NULL,43),
(16,'7610536f-5cd4-45ab-8e56-0a99b6e2a31a','2021-11-02 09:33:40','2021-11-02 09:33:40',1,'Profile visited by loveria Admin','http://localhost:8000/@admin',NULL,43),
(17,'63df17d3-cb6f-41aa-a028-ca00aefcf693','2021-11-02 11:40:32','2021-11-02 11:40:32',1,'  is online now. ','http://localhost:8000/@partner6',NULL,51),
(18,'a7afde32-5733-4483-b457-8b5458d20357','2021-11-02 11:40:33','2021-11-02 11:40:33',1,'  is online now. ','http://localhost:8000/@partner6',NULL,50),
(19,'c49d600d-2197-4c64-834c-fd34cdc80334','2021-11-02 11:40:33','2021-11-02 11:40:33',1,'  is online now. ','http://localhost:8000/@partner6',1,1),
(20,'c7dc3501-a915-40c2-aba6-7934723cda12','2021-11-03 00:09:42','2021-11-03 00:09:42',1,'  is online now. ','http://localhost:8000/@partner6',NULL,51),
(21,'9ffe0a34-6a7b-476c-a389-b04717b4c429','2021-11-03 00:09:42','2021-11-03 00:09:42',1,'  is online now. ','http://localhost:8000/@partner6',NULL,50),
(22,'9d9a5973-48f5-42ca-bf76-aa623cda68d3','2021-11-03 00:09:42','2021-11-03 00:09:42',1,'  is online now. ','http://localhost:8000/@partner6',1,1),
(23,'85184fbc-ae19-4c16-9123-d11aff92513c','2021-11-03 00:10:24','2021-11-03 00:10:24',1,'  is online now. ','http://localhost:8000/@123123123',NULL,34),
(24,'5276833f-6f2c-4960-a4cb-558cc02497e0','2021-11-03 03:40:14','2021-11-03 03:40:14',1,'  is online now. ','http://localhost:8000/@123123123',NULL,34),
(25,'9090b125-0d05-46eb-bb27-04e9b0cb7432','2021-11-05 09:11:44','2021-11-05 09:11:44',1,'Profile visited by Liu 1233123','http://127.0.0.1:8000/@partner10',NULL,34),
(26,'0ecc2ce2-1fb1-4585-b066-ef6dcf2d823d','2021-11-05 10:01:20','2021-11-05 10:01:20',1,'  is online now. ','http://localhost:8000/@partner6',NULL,68),
(27,'38d02405-24f3-40a2-810e-030401401482','2021-11-05 10:02:17','2021-11-05 10:02:17',1,'Profile visited by  ','http://localhost:8000/@partner6',NULL,68),
(28,'47ab62cd-316b-45ac-8964-458f3382bc60','2021-11-05 12:29:51','2021-11-05 12:29:51',1,'testtest asdf is online now. ','http://localhost:8000/@partner6',NULL,68),
(29,'37c15ca6-60d2-4b66-ba67-e8e09675488b','2021-11-05 23:39:35','2021-11-05 23:39:35',1,'qqqq lastname is online now. ','http://localhost:8000/@partner554',NULL,68),
(30,'135d2850-569b-48a6-96b6-db074adcded7','2021-11-05 23:59:40','2021-11-05 23:59:40',1,'Profile visited by qqqq lastname','http://localhost:8000/@partner554',NULL,51),
(31,'66a5eafa-fcef-4c79-8f52-21933e3da19d','2021-11-06 05:01:55','2021-11-06 05:01:55',1,'Profile visited by loveria Admin','http://localhost:8000/@admin',NULL,34),
(32,'13cf076f-0dc9-4adf-bd3f-b5190b094126','2021-11-06 09:01:29','2021-11-06 09:01:29',1,'Profile visited by  ','http://localhost:8000/@ptrainer3',NULL,34),
(33,'9909ffab-f328-4f01-9713-2b30ad39a179','2021-11-06 09:01:48','2021-11-06 09:01:48',1,'Profile visited by  ','http://localhost:8000/@ptrainer3',NULL,51);

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `show_in_menu` tinyint(3) unsigned DEFAULT NULL,
  `content` text DEFAULT NULL,
  `type` tinyint(3) unsigned DEFAULT NULL,
  `users__id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `fk_pages_users1_idx` (`users__id`),
  CONSTRAINT `fk_pages_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `password_resets` */

/*Table structure for table `profile_boosts` */

DROP TABLE IF EXISTS `profile_boosts`;

CREATE TABLE `profile_boosts` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `for_users__id` int(10) unsigned NOT NULL,
  `expiry_at` datetime NOT NULL,
  `credit_wallet_transactions__id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_profile_boosts_users1_idx` (`for_users__id`),
  KEY `fk_profile_boosts_credit_wallet_transactions1_idx` (`credit_wallet_transactions__id`),
  CONSTRAINT `fk_profile_boosts_credit_wallet_transactions1` FOREIGN KEY (`credit_wallet_transactions__id`) REFERENCES `credit_wallet_transactions` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_boosts_users1` FOREIGN KEY (`for_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `profile_boosts` */

/*Table structure for table `profile_visitors` */

DROP TABLE IF EXISTS `profile_visitors`;

CREATE TABLE `profile_visitors` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `to_users__id` int(10) unsigned NOT NULL,
  `by_users__id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_profile_visitors_users1_idx` (`to_users__id`),
  KEY `fk_profile_visitors_users2_idx` (`by_users__id`),
  CONSTRAINT `fk_profile_visitors_users1` FOREIGN KEY (`to_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_visitors_users2` FOREIGN KEY (`by_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `profile_visitors` */

insert  into `profile_visitors`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`to_users__id`,`by_users__id`) values 
(16,'08d248d3-25aa-4293-8f9b-bd7368716e7f','2021-10-28 02:56:12','2021-10-28 02:56:12',1,34,51),
(17,'5dd29094-8c26-4ebb-8ec5-bf80fefe0139','2021-10-28 06:49:51','2021-10-28 06:49:51',1,51,50),
(18,'e7ea77aa-a482-4198-ab0b-f7211ace934d','2021-10-28 06:52:22','2021-10-28 06:52:22',1,43,50),
(19,'3babf421-b042-4765-9f25-f6ed9678076b','2021-11-01 00:28:36','2021-11-01 00:28:36',1,51,1),
(20,'84bb6f96-3bc3-4d2c-811a-3240a473e1b7','2021-11-01 00:29:52','2021-11-01 00:29:52',1,50,1),
(21,'c838f396-bf3c-4323-b2cb-dc04e223a7f2','2021-11-01 00:31:11','2021-11-01 00:31:11',1,33,50),
(22,'88d8492b-2c29-46fc-a987-c64be845c422','2021-11-01 00:32:19','2021-11-01 00:32:19',1,25,50),
(23,'80c24119-fb11-4c60-ab6f-4ce352302c3e','2021-11-01 00:36:46','2021-11-01 00:36:46',1,34,50),
(24,'8d53df54-170b-4c1e-bed1-ee83051726ab','2021-11-01 00:36:59','2021-11-01 00:36:59',1,50,34),
(25,'60c68dbf-8e71-4645-9e7a-2ded76568040','2021-11-01 01:04:00','2021-11-01 01:04:00',1,43,34),
(26,'62921be8-2380-4177-8f66-748a2af11f5b','2021-11-02 09:33:40','2021-11-02 09:33:40',1,43,1),
(27,'79a934d7-0b29-417f-80ce-34845a3d4e03','2021-11-05 09:11:44','2021-11-05 09:11:44',1,34,68),
(28,'9d688035-a749-4c27-92d0-2558ca499004','2021-11-05 10:02:16','2021-11-05 10:02:16',1,68,34),
(29,'6c3ec3e7-6144-482e-b38a-2582c1207622','2021-11-05 23:59:40','2021-11-05 23:59:40',1,51,34),
(30,'7f9bc9ad-5431-49ac-88c7-c80bee926b83','2021-11-06 05:01:55','2021-11-06 05:01:55',1,34,1),
(31,'3cd4d8d0-5dc1-4322-8e80-d8c043d57bcd','2021-11-06 09:01:29','2021-11-06 09:01:29',1,34,69),
(32,'0e8972a9-3676-4979-8c89-3e0c3ef5370a','2021-11-06 09:01:48','2021-11-06 09:01:48',1,51,69);

/*Table structure for table `states` */

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` mediumint(8) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fips_code` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `states` */

insert  into `states`(`id`,`name`,`country_id`,`country_code`,`fips_code`,`iso2`,`created_at`,`updated_at`) values 
(1,'state','1','AF','st','st','2021-10-27 14:43:17','2021-10-27 14:45:30');

/*Table structure for table `user_authorities` */

DROP TABLE IF EXISTS `user_authorities`;

CREATE TABLE `user_authorities` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `user_roles__id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_authorities_users1_idx` (`users__id`),
  KEY `fk_user_authorities_user_roles1_idx` (`user_roles__id`),
  CONSTRAINT `fk_user_authorities_user_roles1` FOREIGN KEY (`user_roles__id`) REFERENCES `user_roles` (`_id`) ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_authorities_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Data for the table `user_authorities` */

insert  into `user_authorities`(`_id`,`_uid`,`status`,`created_at`,`updated_at`,`users__id`,`user_roles__id`) values 
(1,'307303c0-6dae-4066-a613-b26a8146df59',1,'2021-09-28 09:04:34','2021-11-06 05:12:21',1,1),
(15,'70415a96-5b9d-45dc-ac3d-2bafc5c944f9',1,'2021-10-27 03:15:54','2021-10-27 03:27:48',25,2),
(16,'cac1de54-9bc3-49d2-bd97-429661b6775f',1,'2021-10-27 10:12:53','2021-10-27 10:12:53',26,3),
(20,'cb129f71-f8cc-4fcb-b44d-dd42b1ff5f61',1,'2021-10-27 10:20:58','2021-10-27 10:20:58',30,3),
(21,'80505da6-d588-4469-83cf-27d5e84f3621',1,'2021-10-27 10:26:43','2021-10-27 10:26:43',31,3),
(23,'12c411af-5bc1-464c-ad1e-137b14ac3533',1,'2021-10-27 10:34:52','2021-10-27 10:34:52',33,3),
(24,'c9664846-0a2f-434d-8d6d-dd85b28850b6',1,'2021-10-27 10:41:23','2021-11-06 00:01:36',34,2),
(33,'d8fb13b8-7f42-4662-9f45-cc12cfc6b521',1,'2021-10-27 11:59:14','2021-10-27 11:59:14',43,2),
(40,'ddead643-b85b-42f0-bd95-41be941796ff',1,'2021-10-28 02:34:56','2021-11-03 03:40:20',50,2),
(41,'d9a201f0-de93-47a3-af5f-4adb3bc1c704',1,'2021-10-28 02:40:42','2021-10-28 04:04:02',51,3),
(43,'bee56398-130f-40cc-9c86-7707ebc35aad',1,'2021-11-05 07:03:10','2021-11-05 11:00:40',68,3),
(44,'25d971d7-d72d-4112-a27c-71bb97d0b75e',1,'2021-11-06 09:00:50','2021-11-06 09:03:54',69,3);

/*Table structure for table `user_block_users` */

DROP TABLE IF EXISTS `user_block_users`;

CREATE TABLE `user_block_users` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `to_users__id` int(10) unsigned NOT NULL,
  `by_users__id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_block_users1_idx` (`to_users__id`),
  KEY `fk_user_block_users2_idx` (`by_users__id`),
  CONSTRAINT `fk_user_block_users1` FOREIGN KEY (`to_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_block_users2` FOREIGN KEY (`by_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_block_users` */

/*Table structure for table `user_encounters` */

DROP TABLE IF EXISTS `user_encounters`;

CREATE TABLE `user_encounters` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `by_users__id` int(10) unsigned NOT NULL,
  `to_users__id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_encounters_users1_idx` (`by_users__id`),
  KEY `fk_user_encounters_users2_idx` (`to_users__id`),
  CONSTRAINT `fk_user_encounters_users1` FOREIGN KEY (`by_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_encounters_users2` FOREIGN KEY (`to_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_encounters` */

/*Table structure for table `user_gifts` */

DROP TABLE IF EXISTS `user_gifts`;

CREATE TABLE `user_gifts` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `from_users__id` int(10) unsigned NOT NULL,
  `to_users__id` int(10) unsigned NOT NULL,
  `items__id` int(10) unsigned NOT NULL,
  `price` decimal(13,4) DEFAULT NULL,
  `credit_wallet_transactions__id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_gifts_users1_idx` (`from_users__id`),
  KEY `fk_user_gifts_users2_idx` (`to_users__id`),
  KEY `fk_user_gifts_items1_idx` (`items__id`),
  KEY `fk_user_gifts_credit_wallet_transactions1_idx` (`credit_wallet_transactions__id`),
  CONSTRAINT `fk_user_gifts_credit_wallet_transactions1` FOREIGN KEY (`credit_wallet_transactions__id`) REFERENCES `credit_wallet_transactions` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_gifts_items1` FOREIGN KEY (`items__id`) REFERENCES `items` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_gifts_users1` FOREIGN KEY (`from_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_gifts_users2` FOREIGN KEY (`to_users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_gifts` */

/*Table structure for table `user_gym` */

DROP TABLE IF EXISTS `user_gym`;

CREATE TABLE `user_gym` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` mediumint(8) unsigned DEFAULT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `countries__id` smallint(5) DEFAULT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_cities_states1_idx` (`state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `user_gym` */

insert  into `user_gym`(`id`,`_uid`,`users__id`,`name`,`state_id`,`state_code`,`countries__id`,`latitude`,`longitude`,`created_at`,`updated_at`) values 
(1,'eb3541ef-ce3d-4d1e-89b5-d31d6d8a3984',50,'Fremont',NULL,NULL,226,37.49248450,-121.94462300,'2021-10-28 02:34:57','2021-10-28 02:34:57'),
(2,'fb60309c-77db-464c-a9d0-f12290385bad',51,'Chukai',NULL,NULL,129,4.25026940,103.42015740,'2021-10-28 02:40:42','2021-10-28 02:40:42'),
(3,'9edecaca-58f1-4ee4-8b26-58f5c9ffdb19',69,'Gardena',NULL,NULL,226,33.87216790,-118.30763700,'2021-11-06 09:00:51','2021-11-06 09:00:51');

/*Table structure for table `user_items` */

DROP TABLE IF EXISTS `user_items`;

CREATE TABLE `user_items` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `items__id` int(10) unsigned NOT NULL,
  `price` decimal(13,4) DEFAULT NULL,
  `credit_wallet_transactions__id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_items_users1_idx` (`users__id`),
  KEY `fk_user_items_items1_idx` (`items__id`),
  KEY `fk_user_items_credit_wallet_transactions1_idx` (`credit_wallet_transactions__id`),
  CONSTRAINT `fk_user_items_credit_wallet_transactions1` FOREIGN KEY (`credit_wallet_transactions__id`) REFERENCES `credit_wallet_transactions` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_items_items1` FOREIGN KEY (`items__id`) REFERENCES `items` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_items_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_items` */

/*Table structure for table `user_photos` */

DROP TABLE IF EXISTS `user_photos`;

CREATE TABLE `user_photos` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_photos_users1_idx` (`users__id`),
  CONSTRAINT `fk_user_photos_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `user_photos` */

insert  into `user_photos`(`_id`,`_uid`,`created_at`,`updated_at`,`status`,`users__id`,`file`) values 
(2,'68cfb0a2-7891-4657-ae38-c96dbd5fabd9','2021-10-25 13:36:21','2021-10-25 13:36:21',1,1,'rectangle-91-at-1x-6176b2d53a0ed.png'),
(3,'1fbfa4e2-fa2e-4b28-8c6d-9a78c706fc30','2021-10-25 13:37:06','2021-10-25 13:37:06',1,1,'rectangle-97-at-2x-6176b30218522.png'),
(4,'9922081e-cf8a-44d2-9301-da9a7b67d2f2','2021-11-02 09:19:44','2021-11-02 09:19:44',1,1,'rectangle-102-at-2x-618102b08caff.png'),
(5,'203e6f64-506d-4614-8f72-bb7f56527965','2021-11-02 09:19:45','2021-11-02 09:19:45',1,1,'rectangle-99-at-2x-618102b184e1a.png'),
(6,'e22692c7-199e-4814-b965-7f359f6f5f02','2021-11-02 09:19:46','2021-11-02 09:19:46',1,1,'rectangle-116-at-1x-618102b27bc47.png'),
(7,'2d204853-ad30-4ef1-9047-586589075d67','2021-11-02 09:19:48','2021-11-02 09:19:48',1,1,'rectangle-118-at-2x-618102b3dffaa.png'),
(8,'774c1543-a5c6-48f5-9b2c-edd577aeb492','2021-11-02 09:19:49','2021-11-02 09:19:49',1,1,'rectangle-117-at-2x-618102b546781.png'),
(9,'0f1249ff-a687-44fa-aa4b-3d0119e5b380','2021-11-02 09:20:14','2021-11-02 09:20:14',1,1,'main-2-1-at-2x-618102ce8d39f.png'),
(10,'9fbb51d2-9029-426b-886c-f79176766117','2021-11-02 09:20:16','2021-11-02 09:20:16',1,1,'main-45-1-at-2x-618102cfd1508.png'),
(11,'d95bbb34-4bf8-448b-9178-077262cce179','2021-11-02 09:20:17','2021-11-02 09:20:17',1,1,'match-1-at-2x-618102d0d7dc6.png'),
(12,'c682b92f-da54-4146-8458-e278c4636078','2021-11-02 09:24:04','2021-11-02 09:24:04',1,1,'rectangle-72-at-2x-618103b3d1cf1.png'),
(13,'128c2cf1-89f3-46f5-9582-ff2577613606','2021-11-02 09:24:05','2021-11-02 09:24:05',1,1,'rectangle-97-at-2x-618103b52f7a1.png'),
(14,'378d9fa9-fab9-4929-b5c5-cc5d41807af8','2021-11-02 09:24:06','2021-11-02 09:24:06',1,1,'rectangle-98-at-2x-618103b62b5d5.png'),
(15,'46670085-f68c-4739-882f-f394130b01c1','2021-11-02 09:24:07','2021-11-02 09:24:07',1,1,'rectangle-92-at-1x-618103b745c9d.png'),
(16,'0172670a-1338-4e69-b613-8c07e1b99d79','2021-11-02 09:24:08','2021-11-02 09:24:08',1,1,'rectangle-78-at-2x-618103b899c43.png'),
(17,'40815ed3-2029-463d-bdcd-79c5c48351fd','2021-11-02 09:24:09','2021-11-02 09:24:09',1,1,'rectangle-72-1-at-2x-618103b9c0a6b.png'),
(18,'17d3a428-5580-4efb-9382-da0f58cfadf9','2021-11-02 09:24:10','2021-11-02 09:24:10',1,1,'rectangle-102-at-2x-618103bad2fbd.png'),
(23,'47106875-2575-4ff1-98dd-888180e2e8c6','2021-11-05 23:52:36','2021-11-05 23:52:36',1,34,'player-full-screen-6185c3c3a997b.png'),
(24,'5fe9f0b7-748a-4ddc-beb0-ea3704fe95ce','2021-11-05 23:53:12','2021-11-05 23:53:12',1,34,'rectangle-13-at-2x-6185c3e8c794e.png'),
(25,'e9d0792c-59eb-4265-add6-14dfb665ba2c','2021-11-05 23:53:13','2021-11-05 23:53:13',1,34,'rectangle-25-at-2x-6185c3e978373.png'),
(26,'71056f5e-b496-4dcc-b432-fa06e6dd0ba1','2021-11-05 23:53:14','2021-11-05 23:53:14',1,34,'rectangle-27-at-2x-6185c3ea537da.png'),
(27,'0579831e-0e51-41fa-b629-fad883200a40','2021-11-05 23:53:15','2021-11-05 23:53:15',1,34,'rectangle-23-at-2x-6185c3eaf1b29.png'),
(28,'8d162882-c5ec-4a70-a0a5-a8e52785f13e','2021-11-05 23:53:15','2021-11-05 23:53:15',1,34,'rectangle-19-at-2x-6185c3eb924b9.png'),
(29,'1885db68-6649-46d9-9b5b-a87fbdcb90e9','2021-11-05 23:53:16','2021-11-05 23:53:16',1,34,'rectangle-21-at-2x-6185c3ec3417d.png'),
(30,'f6179436-5a7b-4670-b7e8-c5b6f02f9fa3','2021-11-05 23:53:17','2021-11-05 23:53:17',1,34,'rectangle-24-at-2x-6185c3ece8d44.png');

/*Table structure for table `user_profiles` */

DROP TABLE IF EXISTS `user_profiles`;

CREATE TABLE `user_profiles` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `__data` text DEFAULT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `countries__id` smallint(5) unsigned DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `about_me` varchar(500) DEFAULT NULL,
  `location_latitude` decimal(11,8) DEFAULT NULL,
  `location_longitude` decimal(11,8) DEFAULT NULL,
  `preferred_language` varchar(15) DEFAULT NULL,
  `relationship_status` tinyint(3) unsigned DEFAULT NULL,
  `work_status` tinyint(3) unsigned DEFAULT NULL,
  `education` tinyint(4) DEFAULT NULL,
  `cover_picture` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(3) unsigned DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `kanji_name` varchar(255) DEFAULT NULL,
  `kata_name` varchar(255) DEFAULT NULL,
  `do_qualify` date DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `do_start` date DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  KEY `fk_user_profiles_users1_idx` (`users__id`),
  KEY `fk_user_profiles_countries1_idx` (`countries__id`),
  CONSTRAINT `fk_user_profiles_countries1` FOREIGN KEY (`countries__id`) REFERENCES `countries` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_profiles_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `user_profiles` */

insert  into `user_profiles`(`_id`,`_uid`,`created_at`,`updated_at`,`__data`,`users__id`,`countries__id`,`profile_picture`,`gender`,`dob`,`city`,`about_me`,`location_latitude`,`location_longitude`,`preferred_language`,`relationship_status`,`work_status`,`education`,`cover_picture`,`is_verified`,`status`,`kanji_name`,`kata_name`,`do_qualify`,`company_name`,`brand`,`do_start`,`website`) values 
(1,'b6dbe1a7-c86b-4248-8453-7c3ef189552f','2021-09-28 14:02:47','2021-11-06 04:58:37',NULL,1,NULL,'rectangle-72-at-2x-6181121227df2.png',NULL,'2003-11-04',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'love-1706572-1920-61542d53830cd.jpg',NULL,0,'Admin',NULL,NULL,NULL,NULL,NULL,NULL),
(13,'125c6936-f136-4e13-b3de-d3158cd2759e','2021-10-27 03:15:54','2021-10-27 03:19:11',NULL,25,NULL,'rectangle-37-at-2x-6178c4bc3786f.png',1,'1999-02-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'rectangle-24-at-2x-6178c52f18f3c.png',NULL,1,'123','234',NULL,NULL,NULL,NULL,NULL),
(14,'79affcc9-9961-44d3-aea8-8d3689244e40','2021-10-27 10:12:53','2021-10-27 10:12:53',NULL,26,NULL,NULL,2,'2003-10-08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'123','123','2003-10-13',NULL,NULL,NULL,NULL),
(15,'7dbbaeb0-d605-47d4-8596-eb7a4f1c9cd9','2021-10-27 10:20:58','2021-10-27 10:20:58',NULL,30,NULL,NULL,2,'2003-10-14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'123','123','2003-10-03',NULL,NULL,NULL,NULL),
(16,'fba10843-c87a-44ab-9310-ea6340f1b5b4','2021-10-27 10:26:43','2021-10-27 10:26:43',NULL,31,NULL,NULL,1,'2003-10-15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'123','123','2003-10-08',NULL,NULL,NULL,NULL),
(17,'d1b169c8-ce44-4608-ae22-7e61c025232e','2021-10-27 10:34:53','2021-10-27 10:34:53',NULL,33,NULL,NULL,2,'2003-10-09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'123','123','2003-10-02',NULL,NULL,NULL,NULL),
(18,'db4fe8ea-d080-4db4-bace-06347f7c84cc','2021-10-27 10:41:23','2021-11-06 00:01:36',NULL,34,62,'rectangle-19-at-2x-6185c5e015fbf.png',2,'2003-10-10','Guayaquil','asdfasdf asdf aasdfasdfasfasdf asdf asdf',-2.16934770,-79.89853970,'5',2,4,NULL,'rectangle-116-at-1x-617f367a8d88d.png',NULL,2,'ddddsdf','123',NULL,NULL,NULL,NULL,NULL),
(27,'5491c69d-108f-4bf6-a01c-69671e07f8cc','2021-10-27 11:59:14','2021-10-27 11:59:14',NULL,43,1,'61793f128fa33.png',2,'2003-10-15','city',NULL,40.00000000,39.00000000,NULL,NULL,NULL,NULL,NULL,NULL,1,'123','123',NULL,NULL,NULL,NULL,NULL),
(34,'a597deb0-f65b-4ed7-81bd-cc08c63c4d03','2021-10-28 02:34:56','2021-10-28 02:36:02',NULL,50,67,'617a0c50c677b.png',3,'2003-10-09','Saula',NULL,59.21470890,25.04345130,NULL,NULL,NULL,NULL,'rectangle-90-at-1x-617a0c7cf237a.png',NULL,2,'123','123',NULL,NULL,NULL,NULL,NULL),
(35,'851d6620-e96a-4d50-9208-1a0b4ea4154c','2021-10-28 02:40:42','2021-10-28 02:46:20',NULL,51,80,'617a0daa6fd6e.png',2,'2000-03-16','Köln',NULL,50.93614400,6.93840170,NULL,NULL,NULL,NULL,'rectangle-92-at-1x-617a0efb99e8c.png',NULL,2,'123123','123123','2000-03-15',NULL,NULL,NULL,NULL),
(36,'206e857e-8051-4ff0-9465-2da98e14a374','2021-11-05 07:03:11','2021-11-05 08:19:06',NULL,68,NULL,'6184d72f37672.png',2,'2003-11-03',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'rectangle-4-at-1x-6184d7d1b9764.png',NULL,2,'asd','asd','2003-10-27',NULL,NULL,NULL,NULL),
(37,'895a36d2-b6ab-42f3-96a0-db5aed719c62','2021-11-06 09:00:51','2021-11-06 09:03:34',NULL,69,225,'61864442d30c9.png',1,'2003-10-29','','123123 123123 234',51.54179380,-0.33708890,NULL,NULL,NULL,NULL,NULL,NULL,2,'Trainer 3','123123','2003-10-29',NULL,NULL,NULL,NULL);

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `user_roles` */

insert  into `user_roles`(`_id`,`_uid`,`status`,`created_at`,`updated_at`,`title`) values 
(1,'15f21c9f-88bb-4fec-bad4-03eb9d9065f8',1,'2021-09-28 09:04:34','2021-09-28 09:04:34','Admin'),
(2,'287133c4-2afc-4f65-ab3c-28b0df8a099a',1,'2021-09-28 09:04:34','2021-09-28 09:04:34','Partner'),
(3,'69acf899-286e-45b3-990c-677f45076c5f',1,'2021-10-21 21:08:47','2021-10-21 21:08:51','PT'),
(4,'e0808e5e-8880-47c7-b8bf-94f852664501',1,'2021-10-21 21:09:20','2021-10-21 21:09:23','GYM'),
(5,'5a0d145c-e47e-41c8-a15f-b8cb12cfd687',1,'2021-10-21 21:10:18','2021-10-21 21:10:20','Brand');

/*Table structure for table `user_settings` */

DROP TABLE IF EXISTS `user_settings`;

CREATE TABLE `user_settings` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `key_name` varchar(45) NOT NULL,
  `value` text DEFAULT NULL,
  `data_type` tinyint(4) DEFAULT NULL,
  `users__id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `name` (`key_name`),
  KEY `fk_user_settings_users1_idx` (`users__id`),
  CONSTRAINT `fk_user_settings_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `user_settings` */

insert  into `user_settings`(`_id`,`created_at`,`updated_at`,`key_name`,`value`,`data_type`,`users__id`) values 
(1,'2021-10-28 02:55:48','2021-10-28 02:55:48','max_age','19',3,51),
(2,'2021-10-28 03:50:27','2021-10-28 03:50:27','looking_for','1',1,51),
(3,'2021-11-01 00:34:01','2021-11-01 00:34:01','max_age','70',3,50),
(4,'2021-11-02 03:39:57','2021-11-02 03:39:57','max_age','43',3,1);

/*Table structure for table `user_specifications` */

DROP TABLE IF EXISTS `user_specifications`;

CREATE TABLE `user_specifications` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `specification_key` varchar(15) NOT NULL,
  `specification_value` varchar(150) DEFAULT NULL,
  `users__id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_favorites_users1_idx` (`users__id`),
  CONSTRAINT `fk_user_favorites_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `user_specifications` */

insert  into `user_specifications`(`_id`,`_uid`,`created_at`,`updated_at`,`type`,`status`,`specification_key`,`specification_value`,`users__id`) values 
(1,'8afad04d-8ee8-4610-b272-3f752ce86732','2021-11-05 09:08:43','2021-11-05 09:08:43',1,1,'music_genre','Looo',68),
(2,'ec54d5e5-3371-4a7d-b7ed-f3f9e29a0a4c','2021-11-05 09:08:50','2021-11-05 09:08:50',1,1,'singer','sss',68),
(3,'0c9f683f-629c-4ba0-80fc-4f09c468e1d0','2021-11-05 09:08:54','2021-11-05 09:08:54',1,1,'song','ss',68),
(4,'8deb50f5-0262-4b66-8394-782c280b5c44','2021-11-05 09:08:55','2021-11-05 09:08:55',1,1,'hobby','sfdf',68),
(5,'0e102047-7195-4414-965d-3fea8bdf6cf9','2021-11-05 09:08:56','2021-11-05 09:08:56',1,1,'sport','df',68),
(6,'13afc66b-28c9-4e2b-b5f9-eef941213553','2021-11-05 09:08:58','2021-11-05 09:08:58',1,1,'book','dfdf',68),
(7,'f0133dab-c9dd-4da6-84e6-5ec628404a40','2021-11-05 09:08:59','2021-11-05 09:08:59',1,1,'color','sdf',68),
(8,'d6a8cc9e-1d4a-4e4e-9f53-1c93d3c789f4','2021-11-05 09:09:00','2021-11-05 09:09:00',1,1,'dish','sdfsdf',68),
(9,'837e07e9-0521-4e65-a0b8-38669bd4b107','2021-11-05 09:09:01','2021-11-05 09:09:01',1,1,'movie','sdfsdf',68),
(10,'a562d314-91cf-41d2-9d97-d0281198a3c7','2021-11-05 09:09:02','2021-11-05 09:09:02',1,1,'show','sdfsdf',68),
(11,'cbeb38f0-45dc-4d18-b778-3790aeb3aa61','2021-11-05 09:09:04','2021-11-05 09:09:04',1,1,'inspired_from','sdfsdf',68),
(12,'2e8fa260-f071-4ce7-9628-08fe870e0da1','2021-11-05 09:09:20','2021-11-05 09:09:20',1,1,'religion','buddhist',68),
(13,'49993370-6355-4445-b414-c341a0620cca','2021-11-05 09:09:22','2021-11-05 09:09:22',1,1,'i_live_with','parents',68),
(14,'cb56ff9a-3e1f-4071-8f20-c76e32070797','2021-11-05 09:09:23','2021-11-05 09:09:23',1,1,'travel','yes_sometimes',68),
(15,'f671684f-b9ac-4aeb-8c4a-1a768f967387','2021-11-05 09:09:25','2021-11-05 09:09:25',1,1,'car','none',68),
(16,'9f8e478a-4104-4bbc-a999-319491def11d','2021-11-05 09:09:26','2021-11-05 09:09:26',1,1,'smoke','never',68),
(17,'3a04cb85-287c-4488-a5ce-8e28f0c554a8','2021-11-05 09:09:28','2021-11-05 09:09:28',1,1,'drink','i_drink_sometimes',68),
(18,'8633f9fe-de57-45b0-b806-1fa08b8829fc','2021-11-05 09:09:40','2021-11-05 09:09:40',1,1,'ethnicity','black',68),
(19,'de972fc1-2240-4997-9bba-6bdae5540c1c','2021-11-05 09:09:41','2021-11-05 09:09:41',1,1,'body_type','slim',68),
(20,'ac757d1e-ff22-4678-8931-30632513bbf6','2021-11-05 09:09:43','2021-11-05 09:09:43',1,1,'hair_color','black',68),
(21,'2b34a445-9785-48bf-bf80-4376938aa13a','2021-11-05 09:09:44','2021-11-05 09:09:44',1,1,'height','142',68),
(22,'9ae3b50f-6f78-4e7d-ab2a-feaf3ef7f441','2021-11-05 23:44:02','2021-11-05 23:44:02',1,1,'music_genre','ddfs',34),
(23,'caa84dbe-6cb5-416e-bcdb-8189ccdb1a85','2021-11-05 23:45:08','2021-11-05 23:45:08',1,1,'religion','atheist',34),
(24,'3ecaefdc-ac26-49a8-8433-3645f0e2b205','2021-11-05 23:45:09','2021-11-05 23:45:09',1,1,'i_live_with','alone',34),
(25,'81627b2a-2e35-4288-a98e-e9a9bca09acc','2021-11-05 23:45:11','2021-11-05 23:45:11',1,1,'travel','yes_sometimes',34),
(26,'990bc8e4-d97f-44c4-9ea5-aa1acf0d48ab','2021-11-05 23:45:13','2021-11-05 23:45:13',1,1,'car','none',34),
(27,'c5e995f3-337e-4947-85e6-a38cbd360b84','2021-11-05 23:45:17','2021-11-05 23:45:17',1,1,'smoke','chain_smoker',34),
(28,'4107c89f-8291-4a5a-aa48-06300cd8b5ec','2021-11-05 23:45:19','2021-11-05 23:45:19',1,1,'drink','i_drink_sometimes',34),
(29,'a5815d77-4ec6-42b5-bf57-8deae7bf440c','2021-11-05 23:45:52','2021-11-05 23:45:52',1,1,'body_type','average',34),
(30,'0ff1f037-8155-46a2-bb4d-699a74c5fae8','2021-11-05 23:45:55','2021-11-05 23:45:55',1,1,'ethnicity','middle_eastern',34),
(31,'d7080d53-8a1f-4909-971c-4b51346da8d2','2021-11-05 23:46:00','2021-11-05 23:46:00',1,1,'height','195',34),
(32,'a44ea3f9-ca37-4dea-ab10-15d7dea38ac8','2021-11-05 23:46:04','2021-11-05 23:46:04',1,1,'hair_color','sandy',34),
(33,'ce6153c9-26f1-4858-a05f-94af7fb70e69','2021-11-05 23:51:51','2021-11-05 23:51:51',1,1,'friends','some_friends',34),
(34,'8e2a1aa5-89ed-4e1d-a002-7ddbe262da6f','2021-11-05 23:51:54','2021-11-05 23:51:54',1,1,'pets','have_pets',34),
(35,'5313ebb4-db9a-4dbc-818a-701c9fa7b1a4','2021-11-05 23:51:58','2021-11-05 23:51:58',1,1,'children','expecting',34),
(36,'5c56a599-1ec2-487d-bba2-a1221fb5b0f8','2021-11-05 23:52:00','2021-11-05 23:52:00',1,1,'nature','careless',34);

/*Table structure for table `user_subscriptions` */

DROP TABLE IF EXISTS `user_subscriptions`;

CREATE TABLE `user_subscriptions` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `expiry_at` datetime DEFAULT NULL,
  `credit_wallet_transactions__id` int(10) unsigned DEFAULT NULL,
  `plan_id` varchar(20) NOT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`),
  UNIQUE KEY `_uid` (`_uid`),
  KEY `fk_user_subscriptions_users1_idx` (`users__id`),
  KEY `fk_user_subscriptions_credit_wallet_transactions1_idx` (`credit_wallet_transactions__id`),
  CONSTRAINT `fk_user_subscriptions_credit_wallet_transactions1` FOREIGN KEY (`credit_wallet_transactions__id`) REFERENCES `credit_wallet_transactions` (`_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_subscriptions_users1` FOREIGN KEY (`users__id`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_subscriptions` */

/*Table structure for table `user_time` */

DROP TABLE IF EXISTS `user_time`;

CREATE TABLE `user_time` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` varchar(36) DEFAULT NULL,
  `users__id` int(10) unsigned NOT NULL,
  `day` varchar(20) NOT NULL,
  `start` varchar(20) DEFAULT NULL,
  `end` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_time` */

insert  into `user_time`(`_id`,`_uid`,`users__id`,`day`,`start`,`end`,`created_at`,`updated_at`) values 
(36,'2d68eea8-ab22-4aa6-a00d-4a555af12ff2',25,'mon','12:00','14:00','2021-10-27 03:15:54','2021-10-27 03:15:54'),
(37,'dcaeaac2-5851-42d2-91fd-141f3f05bd07',25,'tue','12:00','14:00','2021-10-27 03:15:54','2021-10-27 03:15:54'),
(38,'ce98bf82-0ce9-464c-89b5-5de0c965e132',25,'wed','12:00','14:00','2021-10-27 03:15:54','2021-10-27 03:15:54'),
(39,'46bffd51-6a88-4b19-84f7-a75ddb958536',25,'thu','12:00','14:00','2021-10-27 03:15:54','2021-10-27 03:15:54'),
(40,'6532912d-d6cb-46cc-8e4c-6c0a79875d8c',25,'fri','12:00','14:00','2021-10-27 03:15:54','2021-10-27 03:15:54'),
(41,'dbcde4e8-b7f0-4344-a56b-6717ddb2cd1d',25,'sat','12:00','14:00','2021-10-27 03:15:54','2021-10-27 03:15:54'),
(42,'f79e65ca-8b79-4cd2-9d56-be8ec5d78237',25,'sun','12:00','16:00','2021-10-27 03:15:54','2021-10-27 03:15:54'),
(43,'c4d2a3a0-8c27-4afa-9084-4343e3c4ea1a',26,'mon','12:00','12:00','2021-10-27 10:12:53','2021-10-27 10:12:53'),
(44,'9bb2202e-e7b1-4191-8a5b-319aa9490ef2',26,'tue','12:00','12:00','2021-10-27 10:12:53','2021-10-27 10:12:53'),
(45,'1c350c3d-2151-46b1-858d-e92c7e211ad1',26,'wed','12:00','12:00','2021-10-27 10:12:53','2021-10-27 10:12:53'),
(46,'ae6b4e70-2fcc-4b0c-8cc4-c9771349c202',26,'thu','12:00','12:00','2021-10-27 10:12:53','2021-10-27 10:12:53'),
(47,'a99b2146-2283-4304-8bf0-63f16047a07c',26,'fri','12:00','12:00','2021-10-27 10:12:53','2021-10-27 10:12:53'),
(48,'5a25f94d-56bd-4cce-8cc3-269a9196d99b',26,'sat','12:00','12:00','2021-10-27 10:12:53','2021-10-27 10:12:53'),
(49,'47c087b3-c9a4-49e5-be62-c9c5a11e7dc1',26,'sun','12:00','12:00','2021-10-27 10:12:53','2021-10-27 10:12:53'),
(50,'82f69dfe-0c34-40e6-adff-15e22e102ee0',30,'mon','12:00','12:00','2021-10-27 10:20:58','2021-10-27 10:20:58'),
(51,'c03590df-6dcf-4157-b03d-56c2feadee68',30,'tue','12:00','12:00','2021-10-27 10:20:58','2021-10-27 10:20:58'),
(52,'fe48798a-81a3-44c0-a661-46e45f0d5b0f',30,'wed','12:00','12:00','2021-10-27 10:20:58','2021-10-27 10:20:58'),
(53,'fd3883fa-9940-49b4-bbd7-8c190b20fb7e',30,'thu','12:00','12:00','2021-10-27 10:20:58','2021-10-27 10:20:58'),
(54,'bbeb8f2a-f2e2-497b-88f0-dd10c5dac7da',30,'fri','12:00','12:00','2021-10-27 10:20:58','2021-10-27 10:20:58'),
(55,'92949a59-bbed-459d-b537-46677a3d611a',30,'sat','12:00','12:00','2021-10-27 10:20:58','2021-10-27 10:20:58'),
(56,'fe953ee1-8c6a-4034-8a3d-7c3206ae848b',30,'sun','12:00','12:00','2021-10-27 10:20:58','2021-10-27 10:20:58'),
(57,'62dbe82f-505a-4f7a-ba94-ce674faa2ee9',31,'mon','12:00','12:00','2021-10-27 10:26:43','2021-10-27 10:26:43'),
(58,'2f545cc5-fb39-4e9c-a5f0-26220c55f8cf',31,'tue','12:00','12:00','2021-10-27 10:26:43','2021-10-27 10:26:43'),
(59,'106b4d3e-38c6-4631-8e34-eb665a2f34ae',31,'wed','12:00','12:00','2021-10-27 10:26:43','2021-10-27 10:26:43'),
(60,'e3087fbd-1647-4a1b-accb-da67285b0d9f',31,'thu','12:00','12:00','2021-10-27 10:26:43','2021-10-27 10:26:43'),
(61,'93b2c928-bd7c-435d-bf09-be87d0e2e9dc',31,'fri','12:00','12:00','2021-10-27 10:26:43','2021-10-27 10:26:43'),
(62,'aa1bbabd-466d-4b60-9fff-4c674fa44152',31,'sat','12:00','12:00','2021-10-27 10:26:43','2021-10-27 10:26:43'),
(63,'cb24f719-5421-40d0-9495-7da03f5df5e8',31,'sun','12:00','12:00','2021-10-27 10:26:43','2021-10-27 10:26:43'),
(64,'cb7fb9ed-2497-4c5e-9093-9839b2271f28',33,'mon','12:00','12:00','2021-10-27 10:34:53','2021-10-27 10:34:53'),
(65,'c85aea10-f2c8-4dec-97be-639d2912dc4a',33,'tue','12:00','12:00','2021-10-27 10:34:53','2021-10-27 10:34:53'),
(66,'11669d8a-7e42-4ea2-b767-1647dabb94e0',33,'wed','12:00','12:00','2021-10-27 10:34:53','2021-10-27 10:34:53'),
(67,'b8cf1e94-cec6-463b-9750-42e422a638fa',33,'thu','12:00','12:00','2021-10-27 10:34:53','2021-10-27 10:34:53'),
(68,'79e45104-50a7-4cf5-9c0d-ede6fab83de7',33,'fri','12:00','12:00','2021-10-27 10:34:53','2021-10-27 10:34:53'),
(69,'c3681663-2611-4391-9197-caeed50f283d',33,'sat','12:00','12:00','2021-10-27 10:34:53','2021-10-27 10:34:53'),
(70,'8b6c709d-acd2-4b2d-b3e7-4b4a065ed539',33,'sun','12:00','12:00','2021-10-27 10:34:53','2021-10-27 10:34:53'),
(71,'4a486bd0-412e-4941-af43-b3cc772b15a8',34,'mon','1','1','2021-10-27 10:41:23','2021-11-05 10:01:31'),
(72,'e273c41e-8228-48a2-87db-945155f9f79c',34,'tue','1','1','2021-10-27 10:41:23','2021-11-05 10:01:33'),
(73,'93b68f33-3f22-4109-b34a-5f8397d4569b',34,'wed','1','1','2021-10-27 10:41:23','2021-11-05 23:51:25'),
(74,'3cb2665f-1424-4751-b01a-b5ac53321409',34,'thu','1','1','2021-10-27 10:41:23','2021-11-05 10:01:38'),
(75,'961cddf7-400c-4988-9f29-d687e4d6d24c',34,'fri','0','0','2021-10-27 10:41:23','2021-11-05 23:51:24'),
(76,'9635d249-87d0-471c-b720-69648a4708e2',34,'sat','0','1','2021-10-27 10:41:23','2021-11-05 10:01:42'),
(77,'20192969-d281-4a95-a48b-5e02ebd91bfc',34,'sun','0','1','2021-10-27 10:41:23','2021-11-05 10:01:43'),
(134,'1bef610c-a014-4797-a3eb-88aedc7b801a',43,'mon','12:00','12:00','2021-10-27 11:59:14','2021-10-27 11:59:14'),
(135,'035aa624-54d9-41a7-b413-4a2b276ab07d',43,'tue','12:00','12:00','2021-10-27 11:59:14','2021-10-27 11:59:14'),
(136,'9e4c9068-095a-4ee2-9b8d-02b1a766fdb6',43,'wed','12:00','12:00','2021-10-27 11:59:14','2021-10-27 11:59:14'),
(137,'311a9adc-323b-4257-9cab-d344dfde8451',43,'thu','12:00','12:00','2021-10-27 11:59:14','2021-10-27 11:59:14'),
(138,'6a33465c-3341-47ed-8fb3-e851aa2f5cb5',43,'fri','12:00','12:00','2021-10-27 11:59:14','2021-10-27 11:59:14'),
(139,'931ff87c-f993-4e5a-b8b8-47764297b250',43,'sat','12:00','12:00','2021-10-27 11:59:14','2021-10-27 11:59:14'),
(140,'4a8fad47-2051-4e0f-892c-223aef88a993',43,'sun','12:00','12:00','2021-10-27 11:59:14','2021-10-27 11:59:14'),
(183,'148371be-3e70-4ac4-9777-059a6fd1800a',50,'mon','12:00','12:00','2021-10-28 02:34:56','2021-10-28 02:34:56'),
(184,'5ae6b031-9486-4398-b0aa-91fd2f2145fb',50,'tue','12:00','12:00','2021-10-28 02:34:56','2021-10-28 02:34:56'),
(185,'fb2af710-9b40-4268-8687-cb641e4edab0',50,'wed','12:00','12:00','2021-10-28 02:34:56','2021-10-28 02:34:56'),
(186,'45d1ada2-c948-4ef1-bcd4-e4ef00d4ce43',50,'thu','12:00','12:00','2021-10-28 02:34:56','2021-10-28 02:34:56'),
(187,'5c50c420-589e-4001-972c-5e703fc9788c',50,'fri','12:00','12:00','2021-10-28 02:34:56','2021-10-28 02:34:56'),
(188,'7ddc496b-824c-4c55-911d-c2376b84175c',50,'sat','12:00','12:00','2021-10-28 02:34:56','2021-10-28 02:34:56'),
(189,'bb40b8ca-e256-4f3d-a1e2-6c1a36d4769a',50,'sun','12:00','12:00','2021-10-28 02:34:56','2021-10-28 02:34:56'),
(190,'416ae9ea-70ba-4431-bf80-0e8707e64399',51,'mon','12:00','12:00','2021-10-28 02:40:42','2021-10-28 02:40:42'),
(191,'00c14fac-98c3-4827-8f4d-47e3d6fef274',51,'tue','12:00','12:00','2021-10-28 02:40:42','2021-10-28 02:40:42'),
(192,'db7bbfac-202f-4907-bb00-2a7a99a5d843',51,'wed','12:00','12:00','2021-10-28 02:40:42','2021-10-28 02:40:42'),
(193,'ca5a5d0e-e179-4250-9e9f-6b65be6cb7e0',51,'thu','12:00','12:00','2021-10-28 02:40:42','2021-10-28 02:40:42'),
(194,'ef38add6-b4f7-4e53-b9d3-137b5b4371aa',51,'fri','12:00','12:00','2021-10-28 02:40:42','2021-10-28 02:40:42'),
(195,'a325ce93-cd0f-4e9f-b5d7-2c7ff0ed59ea',51,'sat','12:00','12:00','2021-10-28 02:40:42','2021-10-28 02:40:42'),
(196,'60ca631c-3061-4202-8e09-4de44ae3c3eb',51,'sun','12:00','12:00','2021-10-28 02:40:42','2021-10-28 02:40:42'),
(211,'a52b19c8-5334-4f0c-97aa-d2144847835b',68,'mon','1','0','2021-11-05 08:54:18','2021-11-05 09:07:03'),
(212,'b6136071-c876-4980-a2e2-851ea5ae4faf',68,'tue','1','0','2021-11-05 08:54:18','2021-11-05 09:06:58'),
(213,'64d38909-1f3a-430e-841e-89979122bada',68,'wed','1','0','2021-11-05 08:54:18','2021-11-05 09:07:00'),
(214,'ea5b5052-e0f6-4423-bd34-c3c9ed62d5be',68,'thu','1','0','2021-11-05 08:54:18','2021-11-05 09:07:00'),
(215,'babe4a68-8290-4af0-aed8-a291c8852b94',68,'fri','0','1','2021-11-05 08:54:18','2021-11-05 09:07:12'),
(216,'83294c84-7f49-40b6-97c2-cdf1672509c0',68,'sat','0','1','2021-11-05 08:54:18','2021-11-05 09:07:09'),
(217,'3567e4a7-7255-4a4b-aa2e-b33fa1fa5da7',68,'sun','0','1','2021-11-05 08:54:18','2021-11-05 09:07:07'),
(218,'de17f3b1-3c12-4bea-a76f-fdf45d2d200d',1,'mon','1','1','2021-11-06 04:59:15','2021-11-06 04:59:16'),
(219,'31438996-1200-49fe-94f2-6adc4aff66b7',1,'tue','1','1','2021-11-06 04:59:15','2021-11-06 04:59:18'),
(220,'64aed03b-4403-4960-a430-69a2157bd11f',1,'wed','1','1','2021-11-06 04:59:15','2021-11-06 04:59:19'),
(221,'8f099a1c-43e6-48e7-96c4-6dd26e4d9c21',1,'thu','1','1','2021-11-06 04:59:15','2021-11-06 04:59:21'),
(222,'c629c2dd-c9d0-414b-aab7-c6b6cfebd342',1,'fri','1','1','2021-11-06 04:59:15','2021-11-06 04:59:22'),
(223,'8f3f60d5-bc14-4ea5-b7ff-c4d39666b19f',1,'sat','1','1','2021-11-06 04:59:15','2021-11-06 04:59:25'),
(224,'a0736278-2480-4a66-a174-a62a15cb1b68',1,'sun','1','1','2021-11-06 04:59:15','2021-11-06 04:59:26'),
(225,'8f2bdafe-d124-41f4-8bdc-87b21fb1ca02',69,'mon','1','1','2021-11-06 09:00:51','2021-11-06 09:02:24'),
(226,'ed2e9d27-52e1-4210-8b6b-b81e23f98e93',69,'tue','1','0','2021-11-06 09:00:51','2021-11-06 09:00:51'),
(227,'663dca41-9aa8-47d1-ab6d-eafe79230978',69,'wed','1','1','2021-11-06 09:00:51','2021-11-06 09:02:27'),
(228,'0f4d3f0b-193d-407c-bd6f-3be9a76946f7',69,'thu','1','1','2021-11-06 09:00:51','2021-11-06 09:02:26'),
(229,'59dafdda-1c27-431f-8853-a6c100c592b6',69,'fri','1','0','2021-11-06 09:00:51','2021-11-06 09:02:29'),
(230,'5a18f6bb-9f74-459c-a529-5ac4248aa076',69,'sat','1','0','2021-11-06 09:00:51','2021-11-06 09:00:51'),
(231,'848cbcb3-cc16-47b9-ace7-ce0850908886',69,'sun','1','1','2021-11-06 09:00:51','2021-11-06 09:00:51');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `_uid` char(36) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `designation` varchar(45) DEFAULT NULL,
  `mobile_number` varchar(15) DEFAULT NULL,
  `timezone` varchar(45) DEFAULT NULL,
  `registered_via` varchar(15) DEFAULT NULL,
  `block_reason` varchar(255) DEFAULT NULL,
  `is_fake` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_uid_UNIQUE` (`_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`_id`,`_uid`,`created_at`,`updated_at`,`username`,`email`,`password`,`status`,`remember_token`,`first_name`,`last_name`,`designation`,`mobile_number`,`timezone`,`registered_via`,`block_reason`,`is_fake`) values 
(1,'50ee1967-7341-4c3a-b071-f2ea0722b179','2021-09-28 09:04:34','2021-09-28 09:04:34','admin','firstadmin@domain.com','$2y$10$0MFZ3GWf7JSlfFjpPQ0gke7Sq9lZ/s3yhKwCjY7z00mRAjwDnE4um',1,'jrx1gzlcWhAbOmVzKfwiWY1bhNwgmiZzawGKhH6FplmgpFsjbzfktpmFrq7m','loveria','Admin','Admin','9999999999',NULL,NULL,NULL,NULL),
(25,'09edffc0-8c6d-4b48-853f-15b528120df6','2021-10-27 03:15:53','2021-10-27 03:15:53','34567','partner1@gmail.com','$2y$10$ZTGVzNXqMrG50V0WVhp5MuD7x4SoFYwivxSnZ0tvv8NlR7soFnnyi',1,'y0LiGxMAwV9TiPX9Y1e0c8siLN6q4I032KTwm9Dt6kkPrsyHwUL9fvjQvueU',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(26,'8d82079a-7f9f-47ba-acf6-6dde52fef744','2021-10-27 10:12:53','2021-10-27 10:12:53','partner2','partner2@gmail.com','$2y$10$J199oyaouP6yYKVdFJAmVuHLmPDVG3uggWC1xNjhTymNqnIGdhaci',1,'e9e1cbf6-46da-4313-8492-64af5a9d2b3a',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(30,'4c11be2b-50cd-4104-83b3-ee8d65c178e1','2021-10-27 10:20:58','2021-10-27 10:20:58','partner3','partner3@gmail.com','$2y$10$eidFFWQnCZG/ILSI4F12a.cpnk3ORBwIMCWfQDtmTV75sRDmxvs5K',1,'0fa947da-84c1-499f-9276-67a7ac5ed8e3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(31,'4c113b1c-5086-4fbd-8792-ccd31632ed0f','2021-10-27 10:26:43','2021-10-27 10:26:43','partner4','partner4@gmail.com','$2y$10$u8s4W9SpIYXwBwoMSkbCYetBU9e7kMrGF3DjZLw52dFYfOVonJBwe',1,'2edb08e3-39d0-437d-a9d0-7a00fd5c71db',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(33,'fac46729-b95d-4a73-a1de-29d4709db81a','2021-10-27 10:34:52','2021-10-27 10:34:52','partner5','partner5@gmail.com','$2y$10$I6dty4noVl72MRTte1xHmuwDxwnRL5EXBjnbxzaWwbalp7Zg8.lNq',1,'1cfaba74-b8b8-4a15-8734-97b69e0fe0e3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(34,'4e1edf34-7ded-4628-93cb-8760c07654fb','2021-10-27 10:41:23','2021-11-05 13:24:44','partner554','partner6@gmail.com','$2y$10$ZvrGbapgI6nGru66HocIn.BQ20p3KP7PS6gVWKkI7dm85BEkhnhyC',1,'aEdZrBp5ckZv52Bi95neBh987VVqqpONX0cOs5eY6gE1DJMsUhTXAKiZaA1o','qqqq','lastname',NULL,'123123',NULL,NULL,NULL,NULL),
(43,'e567bad3-ef51-4efa-afef-9c528ef4e4c2','2021-10-27 11:59:14','2021-10-27 11:59:14','partner7','partner7@gmail.com','$2y$10$tJqIImbWGMr3L5zG1bgE4.yl1Pe5sbWxJJnp9T5aNRhlv1sHRfbIm',1,'167f8c9e-42c8-428e-b124-8a64df15ebf3',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(50,'ddfb8d28-7d13-485a-8c68-9a2749bebfdb','2021-10-28 02:34:56','2021-10-28 02:34:56','123123123','partner9@gmail.com','$2y$10$WHdQHU2iMVy4azU0rbwPReYEBSEwJTjX.NfA4GJQFUSmD4da1pUpC',1,'U8K2ryryPlorkYeF4z0Ncxo0dCS3atSUwHLmPgbxm2Bcyuh0wvoSKLTR1p2O',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(51,'21750716-4562-4cac-84cb-810289f5d52f','2021-10-28 02:40:42','2021-10-28 02:40:42','pt1111','pt1@gmail.com','$2y$10$gCWbPBnFVoWvQjP01hZe5Osn1um96nl/5NIYG7qYnjyHNVYoXgMOm',1,'y76IBHvdmDO5Iq8LAsaSrdi3cjfyYG3LOJjj1HCi8pbjj47tnjIIcfTwnjXm',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(68,'47a79117-fb12-4858-97b5-d3c0adb449dc','2021-11-05 07:03:10','2021-11-05 08:31:37','partner10','partner10@gmail.com','$2y$10$r4uI7UKh3mtAMCxB2ZKJ2.VBW5I6vmOaT6UwXE0rugL4A1udI.XYC',1,'d8570a8d-f09f-4eae-8836-e2d274504968','Liu','1233123',NULL,'123123',NULL,NULL,NULL,NULL),
(69,'892ea1cf-dedf-413c-8e73-c19654b08abe','2021-11-06 09:00:50','2021-11-06 09:03:10','ptrainer3','pt3@gmail.com','$2y$10$O/Hx5lFcTEuf/WXvIn3GN.6yDylpWoBvrJKDfw6rdQf1E8p3RFl0a',1,'be36b721-748e-4005-bd84-72c683bb2859',NULL,'latst',NULL,'0123123123',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
