$(function(){
	/**
	 * 购买积分
	 */
	$('button#buyCoin').on('click', function(event) {
    	//跳往个人中心
    	window.location.href='myCenter.html';
	});	
	/**
	 * 开通包月
	 */
	$('button#payMonth').on('click', function(event) {
		//跳往个人中心
		window.location.href='myCenter.html';
    	
	});	
	/**
	 * 开通会员
	 */
	$('button#openMember').on('click', function(event) {
		//跳往个人中心
		window.location.href='myCenter.html';    	
	});	


})



var tk = '';
if (getCookie('tk') != null) {
	tk = getCookie('tk')
	signRequest();
} else {
	tk = getQueryString('tk');
	signRequest();
}



/**
 * 签到
 */
function signRequest(){
	
	$.ajax({
	  url: 'http://47.104.218.168:8117/3?tk='+tk,
	  type: 'get',
	  dataType: 'json',
	  success: function (data) {
	    console.log(data);
	   

	  },
	  fail: function (err) {
	    console.log(err)
	  }
	})	
}