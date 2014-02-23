- iyy_member
CREATE TABLE `iyy_member` ( `pnum` int(11) NOT NULL AUTO_INCREMENT, `username` varchar(28) NOT NULL DEFAULT '', `password` varchar(128) NOT NULL DEFAULT '', `email` varchar(56) NOT NULL DEFAULT '', `createdon` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00', `updatedon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`pnum`), UNIQUE KEY `username` (`username`)) ENGINE=InnoDB AUTO_INCREMENT=1000000 DEFAULT CHARSET=utf8;



