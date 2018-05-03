$(function(){
	initOption();
	/**
	 * 查找
	 */
	$('button#search-btn').on('click', function(event) {
		//跳查找二维码
		window.location.href='viewQRCode.html';
	});

})


/**
 * 初始化
 */
function initOption(){
	$.ajax({
	  url: 'http://47.104.218.168:8117/6',
	  type: 'get',
	  dataType: 'json',
	  success: function (data) {
	    console.log(data);
	    var indus= data.ret[0].d.industry;
	    var area = data.ret[0].d.area;
	    var indus_opt = '<option value="">选择行业</option>';
	    for (var i = 0; i < indus.length; i++) {
	    	indus_opt += '<option value="'+indus[i].id+'">'+indus[i].name+'</option>'
	    }
	    var area_opt = '<option value="">选择地区</option>';
	    for (var i = 0; i < area.length; i++) {
	    	area_opt += '<option value="'+area[i].id+'">'+area[i].name+'</option>'
	    }
	    $('select#industry').html(indus_opt);
	    $('select#area').html(area_opt);
	  },
	  fail: function (err) {
	    console.log(err)
	  }
	})	
}