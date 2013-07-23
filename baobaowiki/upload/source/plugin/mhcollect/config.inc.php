<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
		exit('Access Denied');}
include_once("include/collect.func.php");
$add_member = add_member($_POST['member_add']);
$del_member = del_member($_POST['member_del']);
$add_xml = add_xml($_POST['xml_add']);
$del_xml = del_xml($_POST['xml_del']);
$add_xml = add_xml($_POST['xml_add']);
$member_list = collect_member();
$xml_list = collect_xml();
include_once template("mhcollect:config");
?>
