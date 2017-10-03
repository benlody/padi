
CREATE TABLE `customer` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `chinese_name` TEXT DEFAULT '',
  `english_name` TEXT DEFAULT '',
  `level` CHAR(255) DEFAULT '',
  `contact` TEXT DEFAULT '',
  `tel` TEXT DEFAULT '',
  `email` TEXT DEFAULT '',
  `chinese_addr` TEXT DEFAULT '',
  `english_addr` TEXT DEFAULT '',
  `region` CHAR(255) DEFAULT '',
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `product` (
  `id` CHAR(64) NOT NULL PRIMARY KEY,
  `chinese_name` TEXT DEFAULT '',
  `english_name` TEXT DEFAULT '',
  `warning_cnt_tw` INT(32) DEFAULT 0,
  `warning_cnt_xm` INT(32) DEFAULT 0,
  `weight` INT(32) DEFAULT 0,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `crew_pak` (
  `id` CHAR(64) NOT NULL PRIMARY KEY,
  `chinese_name` TEXT DEFAULT '',
  `english_name` TEXT DEFAULT '',
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_self_balance` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_padi_balance` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_self_balance` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_padi_balance` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_self_transaction` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tw_padi_transaction` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_self_transaction` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xm_padi_transaction` (
  `date` DATE,
  `serial` CHAR(255) NOT NULL PRIMARY KEY,
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `order` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `customer_id` CHAR(255) NOT NULL,
  `customer_name` TEXT DEFAULT '',
  `chinese_addr` TEXT DEFAULT '',
  `english_addr` TEXT DEFAULT '',
  `region` CHAR(255) DEFAULT '',
  `contact` TEXT DEFAULT '',
  `tel` TEXT DEFAULT '',
  `content` TEXT NOT NULL,
  `ship_type` INT(8) NOT NULL,
  `date` DATE NOT NULL,
  `done_date` DATE,
  `warehouse` CHAR(255) NOT NULL,
  `shipping_info` TEXT DEFAULT '',
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
  `chinese_addr` TEXT DEFAULT '',
  `english_addr` TEXT DEFAULT '',
  `contact` TEXT DEFAULT '',
  `tel` TEXT DEFAULT '',
  `content` TEXT NOT NULL,
  `send_date` DATE,
  `recv_date` DATE,
  `status` INT(8) NOT NULL,
  `src_warehouse` CHAR(255) NOT NULL,
  `dst_warehouse` CHAR(255) NOT NULL,
  `ship_type` CHAR(255) DEFAULT '',
  `shipping_info` TEXT DEFAULT '',
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `shipping` (
  `id` CHAR(255) NOT NULL PRIMARY KEY,
  `order_id` CHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `send_date` DATE  NOT NULL,
  `ship_type` INT(8) NOT NULL,
  `warehouse` CHAR(255) NOT NULL,
  `packing_fee` INT(8) NOT NULL,
  `shipping_fee` INT(8) NOT NULL,
  `request_fee` DOUBLE(8,2) NOT NULL,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group` smallint(6) NOT NULL ,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` CHAR(255) NOT NULL,
  `action` TEXT DEFAULT '',
  `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `marketing` (
  `id` INT(32) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `date` DATE  NOT NULL,
  `content` TEXT DEFAULT '',
  `tracking` TEXT DEFAULT '',
  `weight` TEXT DEFAULT '',
  `orig_fee` INT(8) NOT NULL,
  `req_fee` INT(8) NOT NULL,
  `extra_info` TEXT DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
