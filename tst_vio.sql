-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 18 2016 г., 12:45
-- Версия сервера: 5.5.44-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `tst_vio`
--

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('file','dir','','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `parent_id`, `name`, `type`) VALUES
(1, 0, 'c:', 'dir'),
(2, 1, 'Windows', 'dir'),
(3, 1, 'Temp', 'dir'),
(4, 2, 'System32', 'dir'),
(5, 3, 'tempDb.log', 'file'),
(6, 2, 'notepad.exe', 'file'),
(7, 2, 'calc.exe', 'file'),
(8, 4, 'cmd.exe', 'file'),
(9, 4, 'certutil.exe', 'file');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(11) NOT NULL AUTO_INCREMENT,
  `storage` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  UNIQUE KEY `id_3` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `storage`) VALUES
(6, 'a:3:{s:4:"home";a:4:{s:4:"city";s:3:"msk";s:6:"street";s:10:"zdorovceva";s:5:"house";s:2:"34";s:8:"location";a:2:{s:3:"lat";s:2:"60";s:4:"long";s:2:"48";}}s:4:"work";a:2:{s:4:"main";a:2:{s:12:"organization";s:2:"ms";s:4:"post";s:5:"sales";}s:5:"hobby";a:2:{s:8:"location";s:12:"nansey dodjo";s:4:"post";s:6:"aikido";}}s:3:"age";s:2:"25";}'),
(9, 'a:3:{s:4:"home";a:4:{s:4:"city";s:7:"strussa";s:6:"street";s:4:"mira";s:5:"house";s:1:"5";s:8:"location";a:2:{s:3:"lat";s:2:"42";s:4:"long";s:2:"55";}}s:4:"work";a:2:{s:4:"main";a:2:{s:12:"organization";s:5:"Lenta";s:4:"post";s:5:"sales";}s:5:"hobby";a:2:{s:8:"location";s:10:"rollerClub";s:4:"post";s:6:"roller";}}s:3:"age";s:2:"28";}'),
(11, 'a:3:{s:4:"home";a:4:{s:4:"city";s:3:"spb";s:6:"street";s:12:"dobrovoltsev";s:5:"house";s:2:"11";s:8:"location";a:2:{s:3:"lat";s:2:"39";s:4:"long";s:2:"45";}}s:4:"work";a:2:{s:4:"main";a:2:{s:12:"organization";s:9:"peterbalt";s:4:"post";s:10:"itDirector";}s:5:"hobby";a:2:{s:8:"location";s:11:"nanseyDodjo";s:4:"post";s:4:"user";}}s:3:"age";s:2:"32";}'),
(14, 'a:3:{s:4:"home";a:4:{s:4:"city";s:5:"pskov";s:6:"street";s:8:"centeral";s:5:"house";s:2:"17";s:8:"location";a:2:{s:3:"lat";s:2:"48";s:4:"long";s:2:"52";}}s:4:"work";a:2:{s:4:"main";a:2:{s:12:"organization";s:4:"Kafe";s:4:"post";s:3:"aho";}s:5:"hobby";a:2:{s:8:"location";s:8:"veloClub";s:4:"post";s:7:"cyclist";}}s:3:"age";s:2:"30";}'),
(21, 'a:3:{s:4:"home";a:4:{s:4:"city";s:6:"valday";s:6:"street";s:8:"ozerskay";s:5:"house";s:1:"9";s:8:"location";a:2:{s:3:"lat";s:2:"44";s:4:"long";s:2:"55";}}s:4:"work";a:2:{s:4:"main";a:2:{s:12:"organization";s:17:"recreationÐ¡enter";s:4:"post";s:7:"manager";}s:5:"hobby";a:2:{s:8:"location";s:9:"sportClub";s:4:"post";s:4:"yoga";}}s:3:"age";s:2:"31";}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
