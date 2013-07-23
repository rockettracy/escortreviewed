<?php
$time_min = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24);
$time_max = array(24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1,0);
function show_date($unixtime) {
	if ($unixtime == NULL) $unixtime = time();
	return date("Y-m-d", $unixtime);
}
function get_dateslist() {
	$dateslist[] = show_date();
	$infodates = DB::query("SELECT `pubdate` FROM ".DB::TABLE(mhcollect_newslists)." WHERE pubdate > UNIX_TIMESTAMP('2012-12-31')");
	while ($date = DB::fetch($infodates)) {
		$date_fomatted = date("Y-m-d", $date['pubdate']);
		//if (!in_array($dateslist, $date_fomatted)) $dateslist[] = $date_fomatted;
		if (!in_array($date_fomatted, $dateslist)) $dateslist[] = $date_fomatted;
	}
	return $dateslist;
}
function lister($site, $list_cate) {
	$file_page_urls = get_xmls();
	$num = list_news($file_page_urls, $time_min, $time_max, $day,$keywords, $list_cate);
	show_configure($num);
}
function get_xmls($site) {
	$infoxmls = DB::query("SELECT * FROM ".DB::TABLE(mhcollect_xmls));
	while($xml = DB::fetch($infoxmls)) {
		if(strpos($xml['link'], $site)) $xmllist[] = $xml['link'];
	}
	return $xmllist;
}
function get_newslist($site,$list_cate) {
	$xmllist = get_xmls($site);
	if ($site == "sina"){
		$reg="/<item>*.*?<\/item>/";
		$content = "";
		foreach ($xmllist as $xml) {
			$content = $content.file_get_contents($xml);
		}
		$content = str_replace("\n","",$content);
		$content = str_replace("\r","",$content);
		$content = str_replace("\t","",$content);
		preg_match_all($reg, $content,$matches);
		$reg_title="/<title>*.*?<\/title>/";
		$reg_link="/<link>*.*?<\/link>/";
		$reg_description="/<description>*.*?<\/description>/";
		$reg_date="/<pubDate>*.*?<\/pubDate>/";
		foreach ($matches[0] as $item) {
			preg_match_all($reg_link, $item, $link);
			$link = substr($link[0][0], 49, -7);
			$cate_find = find_cate($link);
			$sql = "SELECT link FROM ".DB::TABLE(mhcollect_newslists)." WHERE link='$link'";
			$collected = DB::num_rows(DB::query($sql));
			if ($collected) continue;
			preg_match_all($reg_description, $item, $description);
			$description = substr($description[0][0], 22, -17);
			if ($description == "") continue;
			$description = iconv('UTF-8', 'GB2312//IGNORE', $description);
			$description = str_replace("'","\'",$description);
			preg_match_all($reg_title, $item, $title);
			preg_match_all($reg_date, $item, $date);
			$date = explode(" ",$date[0][0]);
			$time = explode(":",$date[4]);
			$time[0] = $time[0] + 8;
			$unixtime = "$date[1] $date[2] $date[3] +$time[0] hours $time[1] minutes $time[2] seconds";
			$pubDate = strtotime($unixtime);
			$title = iconv('UTF-8', 'GB2312//IGNORE', $title[0][0]);$title = substr($title, 16, -11);
			$style= floor($i%2);
			$sql = "INSERT INTO ".DB::TABLE(mhcollect_newslists)." (cate,link,title,description,pubdate) VALUES ('$cate_find','$link', '$title', '$description','$pubDate')";
			DB::query($sql);
		}
	}
}
function list_news($site, $cate, $time_min, $time_max, $day, $keywords) {
	$infonews = DB::query("SELECT * FROM ".DB::TABLE(mhcollect_newslists));
	while($news = DB::fetch($infonews)) {
		if(!strpos($news['link'], $site)) continue;
		if($cate != NULL && $cate != "全部" && find_cate($cate) != $news['cate']) continue;
		if(date("Y-m-d", $news['pubdate']) != $day) continue;
		if(date("H", $news['pubdate']) < $time_min) continue;
		if(date("H", $news['pubdate']) > $time_max) continue;
		$news['time'] = date("Y-m-d H:i:s", $news['pubdate']);
		$newslist[] = $news;
	}
	return $newslist;
}
function find_cate($string) {
	if (strpos($string, 'sports') || $string == "体育"			) return "体育";
			elseif (strpos($string, 'mil') || $string == "军事"	) return "军事";
			elseif (strpos($string, 'tech') || $string == "科技"	) return "科技";
			elseif (strpos($string, 'finance') || $string == "财经"	) return "财经";
			elseif (strpos($string, 'ent') || $string == "娱乐"	) return "娱乐";
			elseif (strpos($string, 'video') || $string == "科技"	) return "视频";
			elseif (strpos($string, 'edu') || $string == "教育"	) return "教育";
			elseif (strpos($string, 'eladies') || $string == "女性"	) return "女性";
			elseif (strpos($string, 'news')	|| $string == "综合"	) return "综合";
			else return "其它";
}
function collect_cate($newslist,$choosecate) {
	if($choosecate != "") $catelist[] = $choosecate;
	$catelist[] = "全部";
	$infocate = DB::query("SELECT DISTINCT `cate` FROM ".DB::TABLE(mhcollect_newslists));
	while($cate = DB::fetch($infocate)) {
		$catelist[] = $cate['cate'];
	}
	return $catelist;
}
function collect_forum() {
	$infoforum = DB::query("SELECT `fid`,`name` FROM ".DB::TABLE(forum_forum)." WHERE `status` = 1 AND `fup` != 0");
	while($forum = DB::fetch($infoforum)) {
		$forumlist[] = $forum;
	}
	return $forumlist;
}

function collect_member() {
	$infomember = DB::query("SELECT `uid`,`uname` FROM ".DB::TABLE(mhcollect_member));
	while($member = DB::fetch($infomember)) {
		$memberlist[] = $member;
	}
	return $memberlist;
}

function collect_xml() {
	$infoxml = DB::query("SELECT * FROM ".DB::TABLE(mhcollect_xmls));
	while($xml = DB::fetch($infoxml)) {
		$xmllist[] = $xml;
	}
	return $xmllist;
}

function news_into_cache($news_chose_list) {
	$newslist = "(";
	if(count($news_chose_list))
		$newslist = $newslist.implode(",", $news_chose_list);
	else
		$newslist = $newslist."0";
	$newslist = $newslist.")";
	$infonews = DB::query("SELECT `id`,`link`,`title`,`description` FROM ".DB::TABLE("mhcollect_newslists")." WHERE `id` IN $newslist");
	while($news = DB::fetch($infonews)) {
		cache($news['title'], $news['link'], $news['id']);
		$news_array[] = $news;
	}
}
function read_cache() {
	$infonews = DB::query("SELECT * FROM ".DB::TABLE(mhcollect_cache));
	while($news = DB::fetch($infonews)) {
		$newslist[] = $news;
	}
	return $newslist;
}

/**** 以下是旧的 **/
function cache($title, $url, $news_id) {
	$contents = file_get_contents($url);

	$contents = str_replace("\n","",$contents);
	$contents = str_replace("\r","",$contents);
	$contents = str_replace("\t","",$contents);			//删除所有换行
	$contents = str_replace("'","\'",$contents);

	$reg_content = "/<!-- publish*.*?>*.*helper_end/";		//抽取正文
	preg_match_all($reg_content, $contents, $result);
	$result = $result[0][0];

	$reg_img = "/<img*.*?>*.*?>/";
	preg_match_all($reg_img, $result, $img);			//抽取图片
	if ($img[0][0] == "")
		; 
	else {
		for ($i = 0; $img[0][$i] != ''; $i++){
			$reg_image_link = "//";
		}
	}
	$reg_p = "/<p *.*?>*.*?p>/";
	preg_match_all($reg_p, $result, $p);				//抽取正文的所有段,并加换行
	for ($i = 0; $p[0][$i] != ''; $i++){
		$text = $text.$p[0][$i]."\n";
	}
	$text = delete_html_tag($text);					//删除所有htmltag
	$img_urls = get_img_urls($contents);				//获取图片信息
	$flash_urls = flash_convert($contents);
	$text = $flash_urls.$text;
	$array = array('id'=>$news_id,'content'=>$text,'title'=>$title,'img'=>$img_urls);
	$tid=DB::insert('mhcollect_cache', $array, TRUE);
}

function get_img_urls($contents) {
	$reg_wrapper = "/<div class=\"img_wrapper\"><img*.*?>/";
	preg_match_all($reg_wrapper, $contents, $result);
	$imgs = "";
	for ($i = 0; $i < count($result[0]); $i++) {
		$handle = substr($result[0][$i], 25);
		$imgs = $imgs.$handle;
	}
	return $imgs;
}

function delete_html_tag($scr)
{
	for($i=0;$i<strlen($scr);$i++)
	{
		if(substr($scr,$i,1)=="<")
		{
			while(substr($scr,$i,1)!=">")$i++;
			$i++;
		}
		$str=$str.substr($scr,$i,1);
	}
	$sql = "SELECT * FROM ".DB::TABLE(mhcollect_exclude);
	$result = DB::query($sql);
	$num = DB::num_rows($result);
	for( $i = 0; $i < $num; $i++) {
		$abc = DB::fetch($result);
		$target = $abc['target'];
		$source = $abc['source'];
		$str = str_replace($target,"$source",$str);
	}
	$str = str_replace("[微博]","",$str);
	$str = str_replace('[flash][/flash]',"",$str);
	$str = str_replace("(微博)","",$str);
	$str = str_replace("关注新浪户外，了解更多户外资讯。","",$str);
	$str = str_replace("</p>","",$str);
	$str = str_replace("&nbsp;","",$str);
	$str = str_replace("新浪体育讯","",$str);
	$str = str_replace("<strong>","",$str);
	$str = str_replace("</strong>","",$str);
	$str = str_replace("【环球网综合报道】","",$str);
	$str = str_replace("</span>","",$str);
	$str = str_replace("</a>","",$str);
	$str = str_replace("【新浪财经手机客户端下载 安卓客户端下载】","",$str);
	$str = str_replace("&gt;&gt;","",$str);
	$str = preg_replace("/<a *.*?>/","",$str);
	$str = preg_replace("/<span*.*?>/","",$str);
	$str = preg_replace("/<br*.*?>/","",$str);

	
	return($str);
}

function flash_convert($content) {
	$content = iconv('UTF-8', 'GB2312//IGNORE', $content);
	$content = str_replace("\n","",$content);
	$content = str_replace("\r","",$content);
	$content = str_replace("\t","",$content);
	$reg="/<script type=\"text\/javascript\">document.*.*?<\/script>/";
	preg_match_all($reg, $content,$matches);
	$content_url = substr($matches[0][0], 31, -9);
	$reg_url="/swfOutsideUrl*.*?swf/";
	preg_match_all($reg_url, $content_url,$matches);
	$url = substr($matches[0][0], 16);
	if ($url != "") {
		$url =  '[flash]'.$url.'[/flash]';
	}
	$reg_article = "/videoContent\"><p>*.*?>/";
	preg_match_all($reg_article, $content,$matches);
	$article = substr($matches[0][0], 17, -4);
	$url = $url."\n".$article;
	$url = str_replace("<span style=\"color: #ff000", "", $url);
	return $url;

}

function cache_save($arry) {
	$id = $arry['id'];
	$array = array('content'=>$arry['content'],'title'=>$arry['title'],'edit'=>1);
	DB::update("mhcollect_cache", $array, "id='$id'");
}

function cache_delete($arry) {
	$id = $arry['id'];
	DB::delete("mhcollect_cache", "id = '$id'");
}

function post_news($ids,$fid,$uid) {
	$fname = get_forumname($fid);
	$str = "("; $str = $str.implode(",", $ids); $str = $str.")";
	$result = DB::query("SELECT * FROM ".DB::TABLE(mhcollect_cache)." WHERE id IN $str");
	while($news = DB::fetch($result)) {
		$cache_id = $news['id'];
		DB::query("UPDATE ".DB::table('mhcollect_newslists')." SET status=1 WHERE id='$cache_id'", 'UNBUFFERED');
		$title = $news['title'];
		$content = $news['content'];
		$content = str_replace("'","\'",$content);
		$user = choose_user($uid);
		$userid = $user['uid'];
		$uname = $user['uname'];
		$news_information = create_news($title, $fid, $userid, $uname, $content);
		$tid = $news_information[1];
		$pid = $news_information[2];
		$flash = "";
		if (strpos($content, "flash") != '') {
			DB::query("UPDATE ".DB::TABLE(forum_post)." SET bbcodeoff = 0 WHERE tid=$tid AND pid=$pid");
			$flash = 1;
		} //打开flash嵌入功能
		$img_num = wimage_localization($news['img'], $uid, $tid, $pid);
		DB::query("DELETE FROM ".DB::TABLE(mhcollect_cache)." WHERE id=$cache_id");
		$news_brefinformation = array();
		$news_brefinformation['title'] = $title;
		$news_brefinformation['href'] = "<a href=\"forum.php?mod=post&action=edit&fid=$fid&tid=$tid&pid=$pid&page=1\" target=\"_blank\">[编辑]</a>";
		$news_bref_array[] = $news_brefinformation;
	}
	return $news_bref_array;
}

function create_news($title, $fid, $uid, $uname, $content, $ip) {
	$time=time();                                  //发帖时间
	$ip='127.0.0.1';                               //IP
	$views=rand(0,100);                            //浏览次数
	$htmlon=1;                                     // 是否支持HTML   1是支持. 要去后台给板块开启支持HTML
	$pid=DB::fetch(DB::query("SELECT max(pid) FROM ".DB::table(forum_post)));
	$pid=$pid['max(pid)']+1;


	$need_return = array();
	$array=array ( 'fid'=>$fid, 'posttableid'=>0, 'typeid'=>0, 'sortid'=>0, 'readperm'=>0, 'price'=>0, 'author'=>$uname, 'authorid'=>$uid, 'subject'=>$title, 'dateline'=>$time, 'lastpost'=>$time, 'lastposter'=>$uname, 'views'=>$views, 'replies'=>0, 'displayorder'=>0, 'highlight'=>0, 'digest'=>0, 'rate'=>0, 'special'=>0, 'attachment'=>0, 'moderated'=>0, 'closed'=>0, 'stickreply'=>0, 'recommends'=>0, 'recommend_add'=>0, 'recommend_sub'=>0, 'heats'=>0,'status'=>32, 'isgroup'=>0, 'favtimes'=>0, 'sharetimes'=>0, 'stamp'=>-1, 'icon'=>-1, 'pushedaid'=>0, 'cover'=>0, 'replycredit'=>0);
	$tid=DB::insert('forum_thread', $array, TRUE);


	$array=array('pid'=>$pid,'fid'=>$fid,'tid'=>$tid,'first'=>1,'author'=>$uname,'authorid'=>$uid,'subject'=>$title,'dateline'=>$time,'message'=>"$content",'useip'=>$ip,'invisible'=>0,'anonymous'=>0,'usesig'=>1,'htmlon'=>$htmlon,'bbcodeoff'=>-1,'smileyoff'=>-1,'parseurloff'=>0,'attachment'=>0,'rate'=>0,'ratetimes'=>0,'status'=>0,'tags'=>'','comment'=>0,'replycredit'=>0);
	DB::insert('forum_post', $array, TRUE);


	$array=array('pid'=>$pid);
	DB::insert('forum_post_tableid', $array);

	$num=DB::fetch(DB::query('SELECT threads,posts,todayposts FROM '.DB::table('forum_forum')." WHERE fid='$fid'"));
	$array=array('threads'=>$num[threads]+1,'posts'=>$num[posts]+1,'lastpost'=>"$pid        $title        $time        $uname",'todayposts'=>$num[todayposts]+1);
	DB::update('forum_forum', $array,"fid='$fid'");

	DB::query("UPDATE ".DB::table('common_member_count')." SET posts=posts+1 WHERE uid='$uid'", 'UNBUFFERED');
	//DB::query("UPDATE ".DB::table('common_member_status')." SET lastip='$ip',lastvisit='$time',lastactivity='$time',lastpost="$pid        $title        $time        $uname"  WHERE uid='$uid'", 'UNBUFFERED');

	$need_return[] = $uid;
	$need_return[] = $tid;
	$need_return[] = $pid;
	return ($need_return);
}

function choose_user($id) {
	if ($id == -1) 		$option = " ORDER BY rand()";
	else 			$option = " WHERE uid = $id limit 1";
	$sql = "SELECT sql_no_cache * FROM ".DB::TABLE(mhcollect_member).$option;
	$result = DB::query($sql,"UNBUFFERED");
	$result = DB::fetch($result);
	return ($result);
}
function wimage_localization ($contents, $uid, $tid, $pid) {	
	if ($contents == "") ;
	else {
		$reg_wrapper = "/<img*.*?>/";
		preg_match_all($reg_wrapper, $contents, $result);
		$wcount = count($result[0]);
		if ($wcount != 0) {
			$sql = "UPDATE ".DB::TABLE(forum_thread)." SET attachment = 2 WHERE tid = $tid";	DB::query($sql);
			$sql = "UPDATE ".DB::TABLE(forum_post)." SET attachment = 2 WHERE pid = $pid";		DB::query($sql);
		}
		for ($i = 0; $i < $wcount; $i++) {
			$wrapper = $result[0][$i];
			$reg_wlink = "/src=\"*.*?\"/";
			$reg_walt = "/alt=\"*.*?\"/";
			preg_match_all($reg_wlink, $wrapper, $wlink);
			preg_match_all($reg_walt, $wrapper, $walt);
			$wlink = substr($wlink[0][0], 5, -1);
			$walt = substr($walt[0][0], 5, -1);
			$dateline = time();
			$filename = explode("/", $wlink);$filename = end($filename);
			$filename = str_replace("' title=", "", $filename);
			$attachment = date("Ym/d/",$dateline).$filename; 
			//$attachment = str_replace(" title=", "", $attachment);
			$wimg_preference = img_capture($wlink, $attachment);
			$filesize = $wimg_preference[0];
			$width = $wimg_preference[1];
			$isimage = 1;
			$tableid = $tid%10;
			$array = array('tid'=>$tid, 'pid'=>$pid, 'uid'=>$uid, 'tableid'=>$tableid);
			$aid = DB::insert('forum_attachment', $array, TRUE);
			$array = array('tid'=>$tid, 'aid'=>$aid, 'pid'=>$pid, 'uid'=>$uid, 'dateline'=>$dateline, 'filename'=>$filename, 'filesize'=>$filesize, 'attachment'=>$attachment, 'isimage'=>$isimage,'width'=>$width,'description'=>$walt);
			DB::insert("forum_attachment_$tableid", $array, TRUE);
			$array = array('tid'=>$tid, 'attachment'=>$attachment);
			DB::insert("forum_threadimage", $array, TRUE);
		}
			return $wcount;
	}
}

function img_capture($url, $attachment, $filename) {
	// $url 是远程图片的完整URL地址，不能为空。
	// $filename 是可选变量: 如果为空，本地文件名将基于时间和日期
	// 自动生成.
	if($url == ""):return false;endif;
	//if($filename=="") {
	//	$ext=strrchr($url,".");
	//	if($ext != ".gif" && $ext != ".jpg" && $ext != ".png"):return false;endif;
	//	$filename=date("dMYHis").$ext;
	//}
	$attachments = explode("/", $attachment);
	$dir_yearmonth = $attachments[0];
	$dir_day = $attachments[1];
	create_folders("data/attachment/forum/$dir_yearmonth/$dir_day");
	$filename = "data/attachment/forum/".$attachment;
	ob_start();readfile($url);$img = ob_get_contents();ob_end_clean();$size = strlen($img);$fp2=@fopen($filename, "a");fwrite($fp2, $img);fclose($fp2);
	$size = filesize($filename);
	$image_preference = getimagesize($filename);
	$need_return = array();
	array_push($need_return, $size);
	array_push($need_return, $image_preference[0]);
	array_push($need_return, $filename);
	return ($need_return);
}
function create_folders($dir) {
	return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir,0777));
}
function get_forumname($fid) {
	$result = DB::fetch(DB::query("SELECT name FROM ".DB::TABLE(forum_forum)." WHERE fid=$fid"));
	return $name = $result['name'];
}


//下面是config的函数

function add_member($uname) {
	if ($uname) {
		if($infomember = DB::fetch(DB::query("SELECT * FROM ".DB::TABLE(common_member)." WHERE `username` = '$uname'"))) {
			if(DB::fetch(DB::query("SELECT * FROM ".DB::TABLE(mhcollect_member)." WHERE `uname` = '$uname'"))) {
				return -2;
			}
			else {
				$member_add = array('uid' => $infomember['uid'], 'uname' => $infomember['username']);
					DB::insert("mhcollect_member", $member_add);
				return $member_add;
			}
		}
		else return -1;
	}
}

function del_member($uid) {
	if ($uid) {
		$member_deleted = DB::fetch(DB::query("SELECT * FROM ".DB::TABLE(mhcollect_member)." WHERE `uid` = '$uid'"));
		DB::delete('mhcollect_member', "`uid` = '$uid'");
		return $member_deleted;
		}
}

function add_xml($link) {
	if($link) {
		if(DB::fetch(DB::query("SELECT * FROM ".DB::TABLE(mhcollect_xmls)." WHERE `link` = '$link'"))) {
			return -2;
		}
		else {
			DB::insert("mhcollect_xmls",array('link'=>$link));
			return $link;
		}
	}
}
function del_xml($id) {
	if($id) {
		$xml_deleted = DB::fetch(DB::query("SELECT * FROM ".DB::TABLE(mhcollect_xmls)." WHERE `id` = '$id'"));
		DB::delete('mhcollect_xmls', "`id` = '$id'");
		return $xml_deleted;
	}
}
?>
