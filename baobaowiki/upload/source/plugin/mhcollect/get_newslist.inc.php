<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {exit('Access Denied');}
include_once("include/collect.func.php");
if ($_POST['method'] == "collectthroughnet") get_newslist($_POST['site']);
$infonews = list_news($_POST['site'], $_POST['cate'], $_POST['time_min'], $_POST['time_max'], $_POST['day'], $_POST['keywords']);
$list_cate = collect_cate($infonews, $_POST['cate']);
include_once template("mhcollect:collect");
?>
