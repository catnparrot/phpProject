-- --------------------------------------------------------
-- 호스트:                          ###########
-- 서버 버전:                        10.3.32-MariaDB - Source distribution
-- 서버 OS:                        Linux
-- HeidiSQL 버전:                  12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- dbname 데이터베이스 구조 내보내기
DROP DATABASE IF EXISTS `dbname`;
CREATE DATABASE IF NOT EXISTS `dbname` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dbname`;

-- 테이블 dbname.companies 구조 내보내기
DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_res` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_pn` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_res` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_res` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updatedate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 테이블 dbname.servers 구조 내보내기
DROP TABLE IF EXISTS `servers`;
CREATE TABLE IF NOT EXISTS `servers` (
  `pid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charpol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periodstart` date DEFAULT NULL,
  `periodend` date DEFAULT NULL,
  `back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backmem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonnum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suplev` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beforeco` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`) USING BTREE,
  KEY `pid` (`pid`),
  CONSTRAINT `servers_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 테이블 dbname.server_detail 구조 내보내기
DROP TABLE IF EXISTS `server_detail`;
CREATE TABLE IF NOT EXISTS `server_detail` (
  `sid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hostname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diskmodel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mmemory` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cpumodel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `raid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ipaddr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tool` tinyint(2) DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CC1` (`sid`) USING BTREE,
  CONSTRAINT `server_detail_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `servers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 트리거 dbname.prevent_insert_same_values 구조 내보내기
DROP TRIGGER IF EXISTS `prevent_insert_same_values`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER prevent_insert_same_values
BEFORE INSERT ON server_detail
FOR EACH ROW
BEGIN
	 DECLARE var_id INT;
	 SET var_id = FLOOR(NEW.id / 100);
	 IF var_id != NEW.sid THEN
	     SIGNAL SQLSTATE '45000' 
	     SET MESSAGE_TEXT = 'sid * 100 and id must have the same value';
	 END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
