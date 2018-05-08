$(function(){
    /**
     * 上传事件
     */
    $(".j-upload-btn").on('click', function(event) {
        $(this).next(".upload-file").trigger("click");
    });


    // $('input#upload-file').on('change',function(file){
    //   $('#input').get(0).files[0];
    //     upQRCodeImg(file);
    // })

})

var tk = '';
if (getCookie('tk') != null) {
  tk = getCookie('tk')
} else {
  tk = getQueryString('tk');
}




/**
 * 上传请求
 */
function upQRCodeImg(file){
    var formData = new FormData();
    var fileObj = file.files[0];
    formData.append('name','user');
    formData.append('tk',tk);
    formData.append('area','1');
    formData.append('industry','1');
    formData.append('head_img',fileObj);
    var myUrl = 'http://47.104.218.168:8117/7';
    if (fileObj.size<2048576) {
        $.ajax({
          url: myUrl,
          type: 'post',
          data:formData,
          dataType: 'json',
          async: false,
          processData: false,
          contentType: false,
          success: function (data) {
            console.log(data);
            if (data.ret[0].i==2) {
                var money = data.ret[0].d.id;
                window.location.href='payQRPublished.html?tk='+tk+'&money='+money;
            } else {
              layer.alert('上传失败', {
                skin: 'layui-layer-molv' //样式类名
                ,closeBtn: 0
              }, function(){
                location.reload();
              });
            }
          },
          fail: function (err) {
            console.log(err);
          }
        })
    }else{
        layer.alert('上传图片过大！')
    }
}




/**
 * 获取url中的参数
 */
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
    var r = window.location.search.substr(1).match(reg); 
    if (r != null) return unescape(r[2]); return ''; 
}