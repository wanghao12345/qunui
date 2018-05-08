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

function definedItems() {
    header('content-type:text/html;charset=utf-8');
    echo $access_token = getAccessToken();
    echo "<br />";
    $url  = " https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
    $postArr = array(
        'button' => array(
            array(//第一个一级菜单
                'name'=>"微信群",
                'sub_button'=> array(
                array(
                    'type'=>'view',
                    'name'=>'普通群',
                    'url' =>'http://51weixingqun.com/index.php?func=putong'
                ),
                array(
                    'type'=>'view',
                    'name'=>'效果群',
                    'url' =>'http://51weixingqun.com/index.php?func=gaozhiliang'
                ),
                )
            ),
            array(//第二个一级菜单
               'name'=>'发布群',
                'sub_button'=> array(
                array(
                    'type'=>'view',
                    'name'=>'发布群',
                    'url' =>'http://51weixingqun.com/index.php?func=fabu'
                ),
                array(
                    'type'=>'view',
                    'name'=>'已发布',
                    'url' =>'http://51weixingqun.com/index.php?func=yifabu'
                ),
                )
            ),
            array(
                'name'=> '我的',
                'sub_button'=> array(
                array(
                    'type'=>'view',
                    'name'=>'开通包月',
                    'url' =>'http://51weixingqun.com/index.php?func=baoyue'
                ),
                array(
                    'type'=>'view',
                    'name'=>'开通会员',
                    'url' =>'http://51weixingqun.com/index.php?func=huiyuan'
                ),
                array(
                    'type'=>'view',
                    'name'=>'购买积分',
                    'url' =>'http://51weixingqun.com/index.php?func=jifen'
                ),
                array(
                    'type'=>'view',
                    'name'=>'个人中心',
                    'url' =>'http://51weixingqun.com/index.php?func=zhongxin'
                ),
                array(
                    'type'=>'view',
                    'name'=>'每日签到',
                    'url' =>'http://51weixingqun.com/index.php?func=qiandao'
                ),
                )
            ),
        )
    );
	echo $postJson = json_encode($postArr);
    $res = http_curl($url,'post','json',$postJson);
    var_dump($res);
}

definedItems();
?>