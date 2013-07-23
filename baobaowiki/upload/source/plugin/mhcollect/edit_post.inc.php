<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {exit('Access Denied');}
include_once("include/collect.func.php");
$forum_list = collect_forum();
$member_list = collect_member();
if ($_POST['needpostnewsid']) $news_posted = post_news($_POST['needpostnewsid'] ,$_POST['forum'], $_POST['member']);
if ($_POST['mhcollectnewsid']) DB::query("TRUNCATE TABLE ".DB::TABLE(mhcollect_cache));
news_into_cache($_POST['mhcollectnewsid']);
if($_POST['id']) {
	if($_POST['method'] == "save") {
		cache_save($_POST);
	}
	elseif($_POST['method'] == "delete") {
		cache_delete($_POST);
	}
}
$news_neededit = read_cache();
include_once template("mhcollect:collect");
?>
