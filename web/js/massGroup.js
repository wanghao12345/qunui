$(function(){
	// getTestTk();
	getParam();

	//行业选择
	$('button#indu').on('click', function(event) {
		window.location.href='searchQun.html?type=1&tk='+tk;
	});
	//地区选择
	$('button#addr').on('click', function(event) {
		//跳查找群
		window.location.href='searchQun.html?type=1&tk='+tk;
	});
	//质量群
	$('button#commonGroup').on('click', function(event) {
		window.location.href='commonGroup.html?tk='+tk;
	});
	//查看下一个
	$('button#lookNext').on('click', function(event) {
		getQRCode(tk,industry,area);
	});

	//获取积分
	var points = getCookie('points')==null? 0 : getCookie('points');
	if (points==0) {
		window.location.href='CannotView.html?tk='+tk;
	}
	$('b#points').html(points);


})
var tk = '', industry= '', area = '';
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
	    industry = getQueryString('industry');
	    if (industry==null) {
	    	industry = '';
	    }
	    area = getQueryString('area');
	    if (area == null) {
	    	area = '';
	    }
	    getQRCode(tk,industry,area);
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
    industry = getQueryString('industry');
    if (industry==null) {
    	industry = '';
    }
    area = getQueryString('area');
    if (area == null) {
    	area = '';
    }
    tk = getQueryString('tk');
    if (tk == null) {
    	tk = '';
    } 
    getQRCode(tk,industry,area);   
}




/**
 * 获取数据
 */
function getQRCode(tk,industry,area){
	$.ajax({
	  url: 'http://47.104.218.168:8117/5?tk='+tk+'&industry='+industry+'&area='+area,
	  type: 'get',
	  dataType: 'json',
	  success: function (data) {
	    console.log(data);
	    $('#QRCode').html('<img src="'+data.ret[0].d.qr_url+'" alt="二维码">');
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