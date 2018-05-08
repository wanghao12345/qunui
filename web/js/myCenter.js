
$(function(){
	/**
	 * 每日签到
	 */
	$('button#sign').on('click', function(event) {
		//跳往签到成功页面
		signRequest();
	});	
	/**
	 * 购买积分
	 */
	$('button#buyCoin').on('click', function(event) {
    	//跳往个人中心
    	window.location.href='payPoints.html';
	});	
	/**
	 * 开通包月
	 */
	$('button#payMonth').on('click', function(event) {
		//跳往包月服务
		window.location.href='payMonth.html';
    	
	});	
	/**
	 * 开通会员
	 */
	$('button#openMember').on('click', function(event) {
		//判断是否已经是会员
		var vip_level = getCookie('vip_level');
		if (vip_level==1||vip_level=='1') {//是会员
			window.location.href='isMember.html';   
		} else {//不是会员
			//跳往会员服务
			window.location.href='openMember.html';   
		}

	});	
	//获取积分
	var points = getCookie('points')==null? 0 : getCookie('points');
	$('b#points').html(points);

})

/**
 *签到请求
 */
function signRequest(){
	var tk = getCookie('tk');
	$.ajax({
	  url: 'http://47.104.218.168:8117/3?tk='+tk,
	  type: 'get',
	  dataType: 'json',
	  success: function (data) {
    	window.location.href='signSuccess.html';
	  },
	  fail: function (err) {
	    console.log(err)
	  }
	})		
}


