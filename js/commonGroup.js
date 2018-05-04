$(function(){
	// getTestTk();
	getParam();
	//行业选择
	$('button#indu').on('click', function(event) {
		window.location.href='searchQun.html?type=2';
	});
	//地区选择
	$('button#addr').on('click', function(event) {
		//跳查找群
		window.location.href='searchQun.html?type=2';
	});
	//质量群
	$('button#massGroup').on('click', function(event) {
		window.location.href='massGroup.html';
	});
	//查看下一个
	$('button#lookNext').on('click', function(event) {
		getQRCode(tk,1);
	});
})
var tk = '';

/**
 * 获取测试tk
 */
function getTestTk(){
	$.ajax({
	  url: 'http://47.104.218.168:8117/2?dv=1',
	  type: 'get',
	  dataType: 'json',
	  success: function (data) {
	    console.log(data);
	    tk = data.ret[0].d.tk;
	    getQRCode(tk,0);
	  },
	  fail: function (err) {
	    console.log(err)
	  }
	})	
}
/**
 * 获取url参数
 */
function getParam(){
    tk = getQueryString('tk');
    if (tk == null) {
    	tk = '';
    } 
    getQRCode(tk,0);  
}

/**
 * 获取数据
 */
function getQRCode(tk,type){
	$.ajax({
	  url: 'http://47.104.218.168:8117/4?tk='+tk,
	  type: 'get',
	  dataType: 'json',
	  success: function (data) {
	    console.log(data);
	    if (data.ret[0].d.length==1) {
			$('#QRCode').html('<img src="'+data.ret[0].d[0].qr_url+'" alt="二维码">');
	    } else {
	    	$('#QRCode').html('<img src="'+data.ret[0].d[type].qr_url+'" alt="二维码">');
	    }

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