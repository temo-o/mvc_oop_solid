/*
SQLyog Community
MySQL - 10.4.21-MariaDB : Database - trips_01
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`trips_01` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `trips_01`;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `status_flag` int(11) DEFAULT 1,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `bit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`id`,`title`,`status_flag`,`add_date`,`bit`) values 
(1,'Administrator',1,'2021-10-22 11:08:41',1),
(2,'Moderator',1,'2021-10-22 11:09:06',64),
(3,'Viewer',1,'2021-10-22 11:09:15',128);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role_id` int(11) DEFAULT -1,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `status_flag` int(11) NOT NULL DEFAULT 1,
  `created` varchar(64) NOT NULL,
  `modified` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`password`,`role_id`,`first_name`,`last_name`,`status_flag`,`created`,`modified`) values 
(1,'admin@gmail.com','12345',65,'John','Doe',1,'','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
