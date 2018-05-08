<?php
header("content-type:text/html;charset=utf-8");

function send_code($url, $code_param){
	$get_url = $url . '?code=' . $code_param;
#	echo $get_url . "<br/>";
	$curlHandler = curl_init();
	curl_setopt($curlHandler, CURLOPT_URL, $get_url);
	curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curlHandler);
#	echo "result:" . $result . "<br/>";
	curl_close($curlHandler);
	return $result;
}

function send_openid($url, $code_param){
	$get_url = $url . '?unionid=' . $code_param;
#	echo $get_url . "<br/>";
	$curlHandler = curl_init();
	curl_setopt($curlHandler, CURLOPT_URL, $get_url);
	curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curlHandler);
#	echo "result:" . $result . "<br/>";
	curl_close($curlHandler);
	return $result;
}

function saveUserInfo($user){
	$tk = $user['tk'];
	setcookie("tk", $tk, time()+3600*24);

	$points = $user['points'];
	setcookie("points", $points, time()+3600*24);

	$last_checkin = $user['last_checkin'];
	setcookie("last_checkin", $last_checkin, time()+3600*24);

	$moon_vip_date = $user['moon_vip_date'];
	setcookie("moon_vip_date", $moon_vip_date, time()+3600*24);

	$vip_level = $user['vip_level'];
	setcookie("vip_level", $vip_level, time()+3600*24);
}

function goToPage($name,$tk_param){

	//高质量群
	if ($name=='gaozhiliang') {
		header("Location: http://51weixingqun.com/massGroup.html?tk=".$tk_param);
	}
	//普通群
	elseif ($name=='putong') {
		header("Location: http://51weixingqun.com/commonGroup.html?tk=".$tk_param);
	}
	//发布群
	elseif ($name=='fabu') {
		header("Location: http://51weixingqun.com/notPublished.html?tk=".$tk_param);
	}
	//已发布
	elseif ($name=='yifabu') {
		header("Location: http://51weixingqun.com/QRCodePublished.html?tk=".$tk_param);
	}
	//开通包月
	elseif ($name=='baoyue') {
		header("Location: http://51weixingqun.com/payMonth.html?tk=".$tk_param);
	}
	//开通会员
	elseif ($name=='huiyuan') {
		header("Location: http://51weixingqun.com/openMember.html?tk=".$tk_param);
	}
	//购买积分
	elseif ($name=='jifen') {
		# code...
	}
	//个人中心
	elseif ($name=='zhongxin') {
		header("Location: http://51weixingqun.com/myCenter.html?tk=".$tk_param);
	}
	//签到
	elseif ($name=='qiandao') {
		# code...
	}
}

$code = $_GET["code"];
$func = $_GET["func"];

#$code_cookie = $_COOKIE ["code"];
$tk_cookie = $_COOKIE["tk"];
$openid_cookie = $_COOKIE["openid"];


//如果记录了tk
//if ($tk_cookie!='') {
//	goToPage($func, $tk_cookie);
//}
//如果记录了code

if ($openid_cookie!="") {
	$result = send_openid("http://47.104.218.168:8117/1",$openid_cookie);
	$obj = json_decode($result,true);
	$cmd = $obj['cmd'];
	if ($cmd=="1") {
		$ret = $obj['ret'];
		$ele = $ret[0];
		$d_obj = $ele['d'];
		$openid = $ele['openid'];

		saveUserInfo($d_obj);
		setcookie("openid", $openid, time()+3600*24);

		goToPage($func, $d_obj["tk"]);
	}
}
//微信传code过来
elseif ($code!=null) {
	$result = send_code("http://47.104.218.168:8117/1",$code);
	$obj = json_decode($result,true);
	$cmd = $obj['cmd'];
	if ($cmd=="1") {
		$ret = $obj['ret'];
		$ele = $ret[0];
		$d_obj = $ele['d'];
		$openid = $ele['openid'];

		saveUserInfo($d_obj);
		setcookie("openid", $openid, time()+3600*24);

		goToPage($func, $d_obj["tk"]);
	}
}
else{
	if ($func!="") {
		$wx_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxd7a2160ff8aba604&redirect_uri=http://51weixingqun.com/index.php?func=".$func."&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
		header("Location: ".$wx_url);
	}
}

?>