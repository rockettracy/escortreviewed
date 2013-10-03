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

class lev_fall {

	public static $PL_G, $_G, $PLNAME, $PLSTATIC, $PLURL, $lang = array(), $table, $navtitle = '', $debug = FALSE;

	public function __construct() {
		self::__debug();
		self::init();
		if (!self::$PL_G['is_open']) showmessage('plugin close!');;//is open plugin?
		self::levlang();
		self::navtitle();
	}

	public static function init() {
		$plugin_dir   = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));//print_r($arrs_dir);

		global $_G;
		self::$_G     = $_G;
		self::$PLNAME = trim(end($plugin_dir));
		self::$PL_G   = self::$_G['cache']['plugin'][self::$PLNAME];//print_r($PL_G);

		self::$PLSTATIC = 'source/plugin/'.self::$PLNAME.'/statics/';
		self::$PLURL    = 'plugin.php?id='.self::$PLNAME.':lev';
		self::$table    = '#'.self::$PLNAME.'#lev';
	}

	public static function run() {
		include template(self::$PLNAME.':lev');
	}

	public static function levlang() {
		$sets = self::$PL_G['levlang'];
		if ($sets) {
			$array = explode("\r\n", $sets);
			$lang  = array();
			foreach ($array as $r) {
				$thisr  = explode("=", trim($r));
				$lang[trim($thisr[0])] = trim($thisr[1]);
			}
			self::$lang = $lang;
		}
	}
	
	public static function navtitle() {
		$navs = self::$_G['setting']['navs'];
		foreach ((array)$navs as $v) {
			if (strpos($v['nav'], self::$PLNAME) !==FALSE) {
				self::$navtitle = $v['navname'];
				break;
			}
		}
	}
	
	//return $instr = 1,2,3,4,5,6
	public static function sqlinstr($str) {
		$array = unserialize($str);
		$instr = implode(",", $array);
		return $instr;
	}

	public static function lev_load_class($classname, $class_path = '', $initialize = 1) {
		static $classes = array();
		if (empty($class_path)) $class_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'lev_class.php';

		$key = md5($class_path.$classname);
		if (isset($classes[$key])) {
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}

		if (file_exists($class_path)) {
			include $class_path;
			$name = $classname;
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			return $classes[$key];
		} else {
			return false;
		}
	}

	private static function __debug() {
		if (self::$debug) {
			error_reporting(E_ALL ^ E_NOTICE);//显示除去 E_NOTICE 之外的所有错误信息
			ini_set('display_errors', 1);
		}
	}

}













