<?php

function http_curl($url, $type='get', $res='json',$arr='') {
    //初始化curl
    $ch = curl_init();
    //设置curl参数  下面的方式是get请求
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
         
    //post请求
    if ($type == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
    }
    //采集curl
    $output = curl_exec($ch);
    //关闭
    curl_close($ch);
    if($res='json') {
        //请求失败返回错误信息
        if(curl_errno($ch)) {
            return curl_error($ch);
        }//返回成功
        else {
        //加上参数true 将json对象转化成数组而不仅仅是object类型
            return json_decode($output,true);
        }
    }
    var_dump($output); 
}

function getAccessToken() {
    $appid = 'wxd7a2160ff8aba604';//你的appid
    $secret= 'a19bcc0c3b460f0a572f631c853305a6';//你的secret  
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
    $res = http_curl($url, 'get', 'json'); 
    $access_token = $res['access_token'];
    $_SESSION['access_token'] = $access_token;
    $_SESSION['expire_time'] = time()+7000;
    return $access_token;
}

function sendUserMessage() {
    header('content-type:text/html;charset=utf-8');
    echo $access_token = getAccessToken();
    echo "<br />";
    $url  = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$access_token;
    $postArr = array(
        'filter' => array(
        	'is_to_all' => true
        ),
        'text' => array(
        	'content' => '群发测试'
        ),
        'msgtype' => 'text'
    );
	echo $postJson = json_encode($postArr);
    $res = http_curl($url,'post','json',$postJson);
    var_dump($res);
}

sendUserMessage();
/*
$wechatObj = new wechatSendUserMessage();
$wechatObj->login();
$wechatObj->sendMessage('测试群发！');

class wechatSendUserMessage
{
	private $_account = 'qun20180314@163.com';
	private $_password = 'quun20180314';

	//登录
	public function login(){
	  $url = 'https://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN';
	  $this->send_data = array(
	    'username' => $this->_account,
	    'pwd' => md5($this->_password),
	    'f' => 'json'
	  );
	  $this->referer = "https://mp.weixin.qq.com/";
	  $this->getHeader = 1;
	  $result = explode("\n",$this->curlPost($url));

	  foreach ($result as $key => $value) {
	    $value = trim($value);
	    echo $key . ':' . $value . '<br>';
	    if(preg_match('/"ErrCode": (.*)/i', $value,$match)){//获取token
	      switch ($match[1]) {
	        case -1:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"系统错误")));
	        case -2:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"帐号或密码错误")));
	        case -3:
	          die(urldecode(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>urlencode("密码错误")))));
	        case -4:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"不存在该帐户")));
	        case -5:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"访问受限")));
	        case -6:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"需要输入验证码")));
	        case -7:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"此帐号已绑定私人微信号，不可用于公众平台登录")));
	        case -8:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"邮箱已存在")));
	        case -32:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"验证码输入错误")));
	        case -200:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"因频繁提交虚假资料，该帐号被拒绝登录")));
	        case -94:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"请使用邮箱登陆")));
	        case 10:
	          die(json_encode(array('status'=>1,'errCode'=>$match[1],'msg'=>"该公众会议号已经过期，无法再登录使用")));
	        case 0:
	          $this->userFakeid = $this->getUserFakeid();
	          break;
	      }
	    }
	    if(preg_match('/^set-cookie:[\s]+([^=]+)=([^;]+)/i', $value,$match)){//获取cookie
	      $this->cookie .=$match[1].'='.$match[2].'; ';
	    }
	    if(preg_match('/"ErrMsg"/i', $value,$match)){//获取token
	      $this->token = rtrim(substr($value,strrpos($value,'=')+1),'",');
	    }
	  }
	}

	//单发消息
	public function send($fakeid,$content){
	  $url = 'https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&lang=zh_CN';
	  $this->send_data = array(
	      'type' => 1,
	      'content' => $content,
	      'error' => 'false',
	      'tofakeid' => $fakeid,
	      'token' => $this->token,
	      'ajax' => 1,
	    );
	  $this->referer = 'https://mp.weixin.qq.com/cgi-bin/singlemsgpage?token='.$this->token.'&fromfakeid='.$fakeid.'&msgid=&source=&count=20&t=wxm-singlechat&lang=zh_CN';
	  return $this->curlPost($url);
	}

	//群发消息
	public function sendMessage($content='',$userId='') {
	  if(is_array($userId) && !empty($userId)){
	    foreach($userId as $v){
	      $json = json_decode($this->send($v,$content));
	      if($json->ret!=0){
	        $errUser[] = $v;
	      }
	    }
	  }else{
	    foreach($this->userFakeid as $v){
	      $json = json_decode($this->send($v['fakeid'],$content));
	      if($json->ret!=0){
	        $errUser[] = $v['fakeid'];
	      }
	    }
	  }
	   
	  //共发送用户数
	  $count = count($this->userFakeid);
	  //发送失败用户数
	  $errCount = count($errUser);
	  //发送成功用户数
	  $succeCount = $count-$errCount;
	   
	  $data = array(
	    'status'=>0,
	    'count'=>$count,
	    'succeCount'=>$succeCount,
	    'errCount'=>$errCount,
	    'errUser'=>$errUser
	  );
	   
	  return json_encode($data);
	}

	//获取所有用户信息
	public function getAllUserInfo(){
	  foreach($this->userFakeid as $v){
	    $info[] = $this->getUserInfo($v['groupid'],$v['fakeid']);
	  }
	   
	  return $info;
	}
	 
	 
	 
	//获取用户信息
	public function getUserInfo($groupId,$fakeId){
	  $url = "https://mp.weixin.qq.com/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&fakeid={$fakeId}";
	  $this->getHeader = 0;
	  $this->referer = 'https://mp.weixin.qq.com/cgi-bin/contactmanagepage?token='.$this->token.'&t=wxm-friend&lang=zh_CN&pagesize='.$this->pageSize.'&pageidx=0&type=0&groupid='.$groupId;
	  $this->send_data = array(
	    'token'=>$this->token,
	    'ajax'=>1
	  );
	  $message_opt = $this->curlPost($url);
	  return $message_opt;
	}
	 
	//获取所有用户fakeid
	private function getUserFakeid(){
	  ini_set('max_execution_time',600);
	  $pageSize = 1000000;
	  $this->referer = "https://mp.weixin.qq.com/cgi-bin/home?t=home/index&lang=zh_CN&token={$_SESSION['token']}";
	  $url = "https://mp.weixin.qq.com/cgi-bin/contactmanage?t=user/index&pagesize={$pageSize}&pageidx=0&type=0&groupid=0&token={$this->token}&lang=zh_CN";
	  $user = $this->vget($url);
	  $preg = "/\"id\":(\d+),\"name\"/";
	  preg_match_all($preg,$user,$b);
	  $i = 0;
	  foreach($b[1] as $v){
	    $url = 'https://mp.weixin.qq.com/cgi-bin/contactmanage?t=user/index&pagesize='.$pageSize.'&pageidx=0&type=0&groupid='.$v.'&token='.$this->token.'&lang=zh_CN';
	    $user = $this->vget($url);
	    $preg = "/\"id\":(\d+),\"nick_name\"/";
	    preg_match_all($preg,$user,$a);
	    foreach($a[1] as $vv){
	      $arr[$i]['fakeid'] = $vv;
	      $arr[$i]['groupid'] = $v;
	      $i++;
	    }
	  }
	  return $arr;
	}

	private function curlPost($url){
	//初始化
	    $curl = curl_init();
	    //设置抓取的url
	    curl_setopt($curl, CURLOPT_URL, $url);
	    //设置头文件的信息作为数据流输出
	    curl_setopt($curl, CURLOPT_HEADER, $this->getHeader);
	    //设置获取的信息以文件流的形式返回，而不是直接输出。
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt ($ch,CURLOPT_REFERER,$this->referer);
	    //设置post方式提交
	    curl_setopt($curl, CURLOPT_POST, 1);
	    //设置post数据
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $this->send_data);
	    //执行命令
	    $data = curl_exec($curl);
	    //关闭URL请求
	    curl_close($curl);
	    //显示获得的数据
	    return $data;
	}
}*/
?>