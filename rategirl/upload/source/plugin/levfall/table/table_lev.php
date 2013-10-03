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

class table_lev extends discuz_table {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function levpages($table, $where = '', $limit = 20, $start = 0, $url = '') {
		if (!$url) $url = lev_fall::$PLURL;
		
		$where = $where ? ' WHERE '.$where : ' ';
		$page  = max(intval($_GET['page']), 1);
		$total = DB::result_first("SELECT COUNT(*) FROM ".DB::table($table).$where);
		$start = ($page - 1) * $limit + $start;
		$sql   = "SELECT * FROM ".DB::table($table).$where." ORDER BY dateline DESC ".DB::limit($start, $limit);
		$lists = DB::fetch_all($sql);//print_r($lists);
		$pages = multi($total, $limit, $page, $url);//print_r($pages);
		$infos = array('pages'=>$pages, 'lists'=>$lists);
		
		return $infos;
	}
	
}








