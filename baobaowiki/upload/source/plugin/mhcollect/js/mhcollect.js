function change_cate(a,gp_do) {
	var step = document.getElementById("mhcollect_step").value;
	var time_min = document.getElementById("mhcollect_timemin").value;
	var time_max = document.getElementById("mhcollect_timemax").value;
	var site = document.getElementById("mhcollect_site").value;
	var day = document.getElementById("mhcollect_day").value;
	var method = document.getElementById("mhcollect_method").value;
	var cate = a.value;
	var url = "admin.php?action=plugins&operation=config&do="+gp_do+"&pmod=get_newslist";
	post(url,{'step':step,'time_min':time_min,'time_max':time_max,'cate':cate,'site':site,'method':method,'day':day});
}

function post(URL, PARAMS) {      
    var temp = document.createElement("form");      
    temp.action = URL;      
    temp.method = "post";      
    temp.style.display = "none";      
    for (var x in PARAMS) {      
        var opt = document.createElement("textarea");      
        opt.name = x;      
        opt.value = PARAMS[x];      
        // alert(opt.name)      
        temp.appendChild(opt);      
    }      
    document.body.appendChild(temp);      
    temp.submit();      
    return temp;      
}

function show_editor(id) {
	var id_string = "editor_"+id;
	var x = document.getElementById(id_string);
	x.style.display = "";
}

function save_change(id,gp_do) {
	var id_string = "editor_"+id;
	var x = document.getElementById(id_string);
	x.style.display = "none";
	var title_string = "title_"+id;
	var title = document.getElementById(title_string).value;
	var content_string = "content_"+id;
	var content = document.getElementById(content_string).value;
	var url = "admin.php?action=plugins&operation=config&do="+gp_do+"&pmod=edit_post";
	var step = 3;
	post(url,{'step':step,'title':title,'content':content,'id':id,'method':"save"});
}

function delete_news(a,gp_do) {
	var id = a.name;
	var url = "admin.php?action=plugins&operation=config&do="+gp_do+"&pmod=edit_post";
	var step = 3;
	post(url,{'step':step,'id':id,'method':"delete"});
}

function close_hints(a) {
	a.parentNode.parentNode.parentNode.style.display = "none";
}

function member_ad(gp_do) {
	var member_add=document.getElementById("addmember").value;
	if(member_add) {
		var url = "admin.php?action=plugins&operation=config&do="+gp_do+"&pmod=config";
		post(url,{'member_add':member_add});
	}
	else alert ("你没有输入用户名！");
}

function member_del(gp_do) {
	var member_del=document.getElementById("memberid").value;
	if(member_del) {
		var url = "admin.php?action=plugins&operation=config&do="+gp_do+"&pmod=config";
		post(url, {'member_del':member_del});
	}
	else alert("请选择需要删除的发布者");
}

function xml_add(gp_do) {
	var xml_add=document.getElementById("addxml").value;
	if(xml_add) {
		var url = "admin.php?action=plugins&operation=config&do="+gp_do+"&pmod=config";
		post(url,{'xml_add':xml_add});
	}
	else alert ("你没有输入rss的Url地址！");
}

function xml_del(gp_do) {
	var xml_del=document.getElementById("xmlid").value;
	if(xml_del) {
		var url = "admin.php?action=plugins&operation=config&do="+gp_do+"&pmod=config";
		post(url,{'xml_del':xml_del});
	}
	else alert("请选择需要删除的rss");
}
