-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 20 Novembre 2013 à 23:48
-- Version du serveur: 5.5.31
-- Version de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `cloudnote`
--
CREATE DATABASE IF NOT EXISTS `cloudnote` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cloudnote`;

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_note`(IN `_id_user` INT, IN `_name` VARCHAR(256))
    MODIFIES SQL DATA
INSERT INTO cn_notes(id_user, name, content) VALUES (_id_user, _name, '')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_note`(IN `_id_note` INT, IN `_id_user` INT)
    MODIFIES SQL DATA
DELETE FROM cn_notes WHERE id_note = _id_note AND id_user = _id_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_reminder`(IN `_id_reminder` INT, IN `_id_user` INT)
    MODIFIES SQL DATA
DELETE FROM cn_reminders WHERE id_reminder = _id_reminder AND id_user = _id_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_last_note_created`(IN `_id_user` INT)
    READS SQL DATA
SELECT MAX( n.id_note ) AS id_note, n.content as content
FROM cn_notes n
WHERE n.id_user = _id_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_last_reminder_created`(IN `_id_user` INT)
    READS SQL DATA
SELECT MAX( r.id_reminder ) AS id_reminder, r.id_note, r.name, r.date, r.time, r.location
FROM cn_reminders r
WHERE r.id_user = _id_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_list_notes`(IN `_id_user` INT)
    READS SQL DATA
SELECT n.id_note AS id_note, n.name AS name FROM cn_notes n WHERE n.id_user = _id_user ORDER BY n.id_note DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_list_reminders`(IN `_id_user` INT)
    READS SQL DATA
SELECT * FROM cn_reminders WHERE id_user = _id_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_note`(IN `_id_note` INT, IN `_id_user` INT)
    READS SQL DATA
SELECT n.content AS content FROM cn_notes n WHERE n.id_note = _id_note AND n.id_user = _id_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_note`(IN `_id_note` INT, IN `_content` TEXT, IN `_id_user` INT)
    MODIFIES SQL DATA
UPDATE cn_notes SET content = _content WHERE id_note = _id_note AND id_user = _id_user$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_reminder`(IN `_id_reminder` INT, IN `_id_user` INT, IN `_location` VARCHAR(512), IN `_description` TEXT)
    MODIFIES SQL DATA
UPDATE cn_reminders SET location = _location, description =_description WHERE id_reminder = _id_reminder AND id_user = _id_user$$

--
-- Fonctions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `check_password`(`_password` VARCHAR(160), `_email` VARCHAR(128)) RETURNS tinyint(1)
    READS SQL DATA
IF(EXISTS(SELECT * FROM cn_users u WHERE u.password = _password AND u.email = _email))
THEN RETURN TRUE;
ELSE RETURN FALSE;
END IF$$

CREATE DEFINER=`root`@`localhost` FUNCTION `create_reminder`(`_name` VARCHAR(512), `_date` VARCHAR(128), `_time` VARCHAR(128), `_location` VARCHAR(256), `_id_note` INT, `_id_user` INT, `_identifier` VARCHAR(512), `_description` TEXT) RETURNS tinyint(1)
    MODIFIES SQL DATA
BEGIN
DECLARE name_r VARCHAR(512);
DECLARE date_r VARCHAR(128);
DECLARE time_r VARCHAR(128);
DECLARE location_r VARCHAR(128);

IF(NOT EXISTS(SELECT * FROM cn_reminders WHERE identifier = _identifier)) THEN

	IF(_name = 'null') 
	THEN SET name_r = NULL;
	ELSE SET name_r = _name;
	END IF;

	IF(_date = 'null') 
	THEN SET date_r = NULL;
	ELSE SET date_r = _date;
	END IF;

	IF(_time = 'null') 
	THEN SET time_r = NULL;
	ELSE SET time_r = _time;
	END IF;

	IF(_location = 'null') 
	THEN SET location_r = NULL;
	ELSE SET location_r = _location;
	END IF;


	INSERT INTO cn_reminders(name, date, time, location, id_note, id_user, identifier) VALUES(name_r, date_r, time_r, location_r, _id_note, _id_user, _identifier);
	RETURN FALSE;
ELSE RETURN TRUE;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `create_user`(`_email` VARCHAR(128), `_password` VARCHAR(160), `_firstname` VARCHAR(128), `_lastname` VARCHAR(128)) RETURNS tinyint(1)
    MODIFIES SQL DATA
IF(NOT EXISTS(SELECT * FROM cn_users u WHERE u.email = _email)) THEN
        INSERT INTO cn_users(
                    email,
                    password,
                    firstname,
                    lastname
                    )
                    
                    VALUES(
                        _email,
                        _password,
                        _firstname,
                        _lastname
                    );
		INSERT INTO cn_notes(
            		id_user,
            		name,
            		content
        			) 
					VALUES(
                        (SELECT MAX(id_user) FROM cn_users),
                        'Welcome',
                        'Welcome to CloudNote, don\'t forget to read the readme file in the install folder'
                        );
        RETURN 1;
    ELSE RETURN 0;
    END IF$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('1b0fa0d2679fabd8a4b2be8c944f14f0', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1384987642, 'a:4:{s:9:"user_data";s:0:"";s:5:"email";N;s:9:"signed_in";b:1;s:7:"id_user";s:3:"125";}'),
('673c3c7a3e08ce74c3b073071a19904b', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1384987185, 'a:4:{s:9:"user_data";s:0:"";s:5:"email";N;s:9:"signed_in";b:1;s:7:"id_user";s:2:"11";}'),
('d4e56c49342ffea23aea1ff3ed85b1bb', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1384987161, 'a:4:{s:9:"user_data";s:0:"";s:5:"email";N;s:9:"signed_in";b:1;s:7:"id_user";s:2:"11";}');

-- --------------------------------------------------------

--
-- Structure de la table `cn_notes`
--

CREATE TABLE IF NOT EXISTS `cn_notes` (
  `id_note` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `name` varchar(254) NOT NULL DEFAULT 'New note',
  PRIMARY KEY (`id_note`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=348 ;

-- --------------------------------------------------------

--
-- Structure de la table `cn_reminders`
--

CREATE TABLE IF NOT EXISTS `cn_reminders` (
  `id_reminder` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_note` int(11) NOT NULL,
  `name` varchar(512) DEFAULT NULL,
  `date` varchar(128) DEFAULT NULL,
  `time` varchar(128) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `location` varchar(256) DEFAULT NULL,
  `identifier` varchar(512) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_reminder`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Structure de la table `cn_users`
--

CREATE TABLE IF NOT EXISTS `cn_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(160) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=126 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
