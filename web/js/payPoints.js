$(function(){


	$('button#query-btn').on('click', function(event) {
		event.preventDefault();
		payMonthRequest();
	});
	getSignPackage('','','','');


})

var tk = '';
if (getCookie('tk') != null) {
	tk = getCookie('tk')
} else {
	tk = getQueryString('tk');
}




/**
 * 包月
 */
function payMonthRequest(){
	var money = parseInt($('#money-num').html());
	$.ajax({
	  url: 'http://47.104.218.168:8117/8?func=3&money='+money+'&tk='+tk,
	  type: 'get',
	  dataType: 'json',
	  success: function (data) {
	    console.log(data);
	    var item = data.ret[0].d;
	    var appid = item.appid;
	    var timestamp = item.timestamp;
	    var nonceStr = item.nonce_str;
	    var prepay_id = item.prepay_id;
	    var sign = item.sign;

		

		wx.chooseWXPay({
			timestamp: timestamp, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
			nonceStr: nonceStr, // 支付签名随机串，不长于 32 位
			package: "prepay_id="+prepay_id, // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=\*\*\*）
			signType: 'MD5', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
			paySign: sign, // 支付签名
			success: function (res) {
				// timer = setInterval("query_pay('"+dev_id+"')",2000);
			}
		});	   

	  },
	  fail: function (err) {
	    console.log(err)
	  }
	})	
}
/**
 * 获取url中的参数
 */
function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r != null) return unescape(r[2]); return null; 
}



