<?php
if(!defined('IN_DISCUZ')) { exit('Access Denied'); }

$sql = <<<EOF

DROP TABLE cdb_mhcollect_cache;
DROP TABLE cdb_mhcollect_exclude;
DROP TABLE cdb_mhcollect_member;
DROP TABLE cdb_mhcollect_newslists;
DROP TABLE cdb_mhcollect_xmls;

EOF;

runquery($sql);

$finish = TRUE;

?>
