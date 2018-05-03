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
		//跳往开通包月
		window.location.href='payMonth.html';
	});	

	/**
	 * 个人中心
	 */
	$('button#myCenter').on('click', function(event) {
		//跳往个人中心
		window.location.href='myCenter.html';
	});	

	/**
	 * 查看高质量效果群
	 */
	$('button#searchMore').on('click', function(event) {
		//跳往查看高质量效果群
		// window.location.href='myCenter.html';    	
	});	




})