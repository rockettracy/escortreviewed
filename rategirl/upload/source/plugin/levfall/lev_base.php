<?php

/**
 * Lev.suake.org [ 专业开发各种Discuz!插件 ]
 *
 * Copyright (c) 2013-2014 http://www.suake.org All rights reserved.
 *
 * Author: Mr.Lee <675049572@qq.com>
 *
 * Date: 2013-02-17 16:22:17 Mr.Lee $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once 'lev_class.php';

$C = new lev_fall();

$lev_lang = lev_fall::$lang;

$navtitle = $lev_lang['navtitle'] ? $lev_lang['navtitle'] : lev_fall::$navtitle;

$_G['setting']['bbname'] = $lev_lang['bbname'] ? $lev_lang['bbname'] : 'PLugin';

$metakeywords = $lev_lang['metakeywords'] ? $lev_lang['metakeywords'] : $metakeywords;

$metadescription = $lev_lang['metadescription'] ? $lev_lang['metadescription'] : $metadescription;









