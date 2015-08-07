/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.6.22-log : Database - phalcon
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`phalcon` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `phalcon`;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(36) DEFAULT NULL,
  `reg_date` datetime NOT NULL,
  `last_visit_date` datetime DEFAULT NULL,
  `role` enum('ROLE_USER','ROLE_MODERATOR','ROLE_ADMIN') NOT NULL DEFAULT 'ROLE_USER',
  `status` enum('STATUS_NEW','STATUS_ACTIVE','STATUS_BANNED','STATUS_FROZEN','STATUS_DELETED') NOT NULL DEFAULT 'STATUS_NEW',
  `info` text,
  `rating` int(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`id`,`email`,`password_hash`,`first_name`,`last_name`,`phone`,`reg_date`,`last_visit_date`,`role`,`status`,`info`,`rating`) values (1,'remkwadriga@yandex.ua','9f70396df11e88cf40fabb79b5ddadc6','Dmitry','Kushneriov','(063)568-86-19','2015-08-03 15:56:15','2015-08-04 11:39:42','ROLE_ADMIN','STATUS_ACTIVE',NULL,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
