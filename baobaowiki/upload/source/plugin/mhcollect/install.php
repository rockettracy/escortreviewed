<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `cdb_mhcollect_cache` (
  `id` int(4) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `video` text NOT NULL,
  `img` text NOT NULL,
  `edit` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `cdb_mhcollect_exclude` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `target` text NOT NULL,
  `source` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 ;


CREATE TABLE IF NOT EXISTS `cdb_mhcollect_member` (
  `uid` int(10) NOT NULL,
  `uname` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `cdb_mhcollect_newslists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate` varchar(5) NOT NULL,
  `link` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `pubdate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=729 ;



CREATE TABLE IF NOT EXISTS `cdb_mhcollect_xmls` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `link` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 ;

INSERT INTO `cdb_mhcollect_xmls` (`id`, `link`, `description`) VALUES
(1, 'http://rss.sina.com.cn/ent/hot_roll.xml', NULL),
(2, 'http://rss.sina.com.cn/sports/basketball/nba.xml', NULL),
(3, 'http://rss.sina.com.cn/roll/sports/hot_roll.xml', NULL),
(4, 'http://rss.sina.com.cn/roll/sports/hot_roll.xml', NULL),
(5, 'http://rss.sina.com.cn/news/society/misc15.xml', NULL),
(6, 'http://rss.sina.com.cn/news/society/focus15.xml', NULL),
(7, 'http://rss.sina.com.cn/roll/mil/hot_roll.xml', NULL),
(8, 'http://rss.sina.com.cn/jczs/focus.xml', NULL),
(9, 'http://rss.sina.com.cn/news/society/wonder15.xml', NULL),
(10, 'http://rss.sina.com.cn/news/china/hktaiwan15.xml', NULL),
(11, 'http://rss.sina.com.cn/jczs/taiwan20.xml', NULL),
(12, 'http://rss.sina.com.cn/eladies/gossip.xml', NULL),
(13, 'http://rss.sina.com.cn/roll/finance/hot_roll.xml', NULL),
(14, 'http://rss.sina.com.cn/news/marquee/ddt.xml', NULL),
(15, 'http://rss.sina.com.cn/news/china/focus15.xml', NULL),
(16, 'http://rss.sina.com.cn/news/world/focus15.xml', NULL),
(17, 'http://rss.sina.com.cn/news/society/focus15.xml', NULL),
(18, 'http://rss.sina.com.cn/news/china/hktaiwan15.xml', NULL),
(19, 'http://rss.sina.com.cn/news/society/law15.xml', NULL),
(20, 'http://rss.sina.com.cn/news/society/misc15.xml', NULL),
(21, 'http://rss.sina.com.cn/news/society/feeling15.xml', NULL),
(22, 'http://rss.sina.com.cn/news/society/wonder15.xml', NULL),
(26, 'http://rss.sina.com.cn/roll/edu/hot_roll.xml', NULL),
(24, 'http://rss.sina.com.cn/eladies/marry.xml', NULL);

EOF;




runquery($sql);

$finish = TRUE;

?>
