
CREATE TABLE `customer` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `chinese_name` TEXT NOT NULL,
  `english_name` TEXT NOT NULL,
  `level` CHAR(255) NOT NULL,
  `contact` TEXT NOT NULL,
  `tel` TEXT NOT NULL,
  `email` TEXT NOT NULL,
  `chinese_addr` TEXT NOT NULL,
  `english_addr` TEXT NOT NULL,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `product` (
  `id` CHAR(64) NOT NULL PRIMARY KEY,
  `chinese_name` TEXT DEFAULT '',
  `english_name` TEXT DEFAULT '',
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `crew_pak` (
  `id` CHAR(64) NOT NULL PRIMARY KEY
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_self_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_padi_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_self_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_padi_balance` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_self_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_padi_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_self_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_padi_transaction` (
  `date` DATE,
  `serial` CHAR(64),
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `order` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `customer_id` CHAR(255) NOT NULL,
  `chinese_addr` TEXT NOT NULL,
  `english_addr` TEXT NOT NULL,
  `contact` TEXT NOT NULL,
  `tel` TEXT NOT NULL,
  `content` TEXT NOT NULL,
  `ship_type` INT(8) NOT NULL,
  `date` DATE NOT NULL,
  `done_date` DATE,
  `warehouse` CHAR(255) NOT NULL,
  `issue_by` CHAR(255) DEFAULT '',
  `box_num` INT(8) DEFAULT 0,
  `weight` INT(16) DEFAULT 0,
  `shipping_no` CHAR(255) DEFAULT '',
  `status` INT(8) NOT NULL,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchase_order` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `content` TEXT NOT NULL,
  `date` DATE NOT NULL,
  `done_date` DATE,
  `status` INT(8)  NOT NULL,
  `warehouse` CHAR(255) NOT NULL,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `transfer` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `content` TEXT NOT NULL,
  `send_date` DATE,
  `recv_date` DATE,
  `status` INT(8) NOT NULL,
  `src_warehouse` CHAR(255) NOT NULL,
  `dst_warehouse` CHAR(255) NOT NULL,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
