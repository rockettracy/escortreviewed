<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
		exit('Access Denied');}

include_once("include/collect.func.php");
$days = get_dateslist();
include_once template("mhcollect:collect");
?>
