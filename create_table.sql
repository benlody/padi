CREATE TABLE `country` (
  `code` CHAR(2) NOT NULL PRIMARY KEY,
  `name` CHAR(52) NOT NULL,
  `population` INT(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `customer` (
  `id` INT(16) NOT NULL PRIMARY KEY,
  `chinese_name` CHAR(255) NOT NULL,
  `english_name` CHAR(255) NOT NULL,
  `level` CHAR(255) NOT NULL,
  `contact` CHAR(255) NOT NULL,
  `tel` CHAR(255) NOT NULL,
  `email` CHAR(255) NOT NULL,
  `chinese_addr` CHAR(255) NOT NULL,
  `english_addr` CHAR(255) NOT NULL,
  `extra_info` CHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `product` (
  `id` CHAR(64) NOT NULL PRIMARY KEY,
  `chinese_name` CHAR(255) ,
  `english_name` CHAR(255) ,
  `extra_info` CHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `crew_pak` (
  `id` CHAR(64) NOT NULL PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

