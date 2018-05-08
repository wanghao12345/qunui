
$(function(){
	/**
	 * 每日签到
	 */
	$('button#sign').on('click', function(event) {
		//跳往签到成功页面
    	window.location.href='signSuccess.html';
	});	
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