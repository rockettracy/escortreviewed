<?php

/**
 * Lev.levme.com [ 专业开发各种Discuz!插件 ]
 *
 * Copyright (c) 2013-2014 http://www.levme.com All rights reserved.
 *
 * Author: Mr.Lee <675049572@qq.com>
 *
 * Date: 2013-02-17 16:22:17 Mr.Lee $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once 'lev_base.php';

$navall   = intval($_GET['na']);

$set_fids = lev_fall::sqlinstr(lev_fall::$PL_G['set_fids']);

if ($set_fids) {
	$forums = C::t('forum_forum')->fetch_all_by_fid(unserialize(lev_fall::$PL_G['set_fids']));
}else {
	$forums = C::t('forum_forum')->fetch_all_forum();//print_r($forums);
}

$autopage = ceil(lev_fall::$PL_G['limit'] / lev_fall::$PL_G['page']);
$__where  = lev_fall::$PL_G['is_image'] ? 'attachment=2' : '';
$__where .= !lev_fall::$PL_G['is_stamp'] ? '' : ($__where ? ' AND stamp!=-1' : 'stamp!=-1');

$__fids   = intval($_GET['fid']) ? intval($_GET['fid']) : $set_fids;
if ($__fids) {
	$__where = $__where ? $__where.' AND fid IN ('.$__fids.')' : 'fid IN ('.$__fids.')';
}
	
if (isset($_GET['page']) && isset($_GET['ajax'])) {
	if ($autopage < intval($_GET['page'])) exit();
	$ajax  = intval($_GET['ajax']);
	$start = ($ajax >0) ? (($ajax-1) * lev_fall::$PL_G['limit']) : 0;
	$infos = C::t(lev_fall::$table)->levpages('forum_thread', $__where, lev_fall::$PL_G['page'], $start);
	$pages = $infos['pages'];
	$lists = $infos['lists'];
	
	include template(lev_fall::$PLNAME.':page');
}else {
	$infos = C::t(lev_fall::$table)->levpages('forum_thread', $__where, lev_fall::$PL_G['limit']);
	$pages = $infos['pages'];
	$lists = $infos['lists'];//print_r($infos);
	
	include template(lev_fall::$PLNAME.':lev');
}












