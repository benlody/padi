CREATE TABLE `country` (
  `code` CHAR(2) NOT NULL PRIMARY KEY,
  `name` CHAR(52) NOT NULL,
  `population` INT(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `customer` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
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

CREATE TABLE `tw_self_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_padi_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_self_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_padi_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_self_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_padi_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_self_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_padi_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` CHAR(64)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `order` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `customer_id` CHAR(255) NOT NULL,
  `chinese_addr` CHAR(255) NOT NULL,
  `english_addr` CHAR(255) NOT NULL,
  `contact` CHAR(255) NOT NULL,
  `tel` CHAR(255) NOT NULL,
  `content` CHAR(255) NOT NULL,
  `ship_type` INT(8),
  `date` DATE NOT NULL,
  `issue_by` CHAR(255) NOT NULL,
  `check` BOOL DEFAULT FALSE,
  `box_num` INT(8),
  `weight` INT(16),
  `shipping_no` CHAR(255) NOT NULL,
  `status` INT(8),
  `extra_info` CHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_order` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `content` CHAR(255) NOT NULL,
  `date` DATE NOT NULL,
  `done_date` DATE,
  `status` INT(8)  NOT NULL,
  `warehouse` CHAR(255) NOT NULL,
  `extra_info` CHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
