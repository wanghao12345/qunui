$(function(){
    /**
     * 上传事件
     */
    $(".j-upload-btn").on('click', function(event) {
        $(this).next(".upload-file").trigger("click");
    });

})

/**
 * 上传请求
 */
function upQRCodeImg(file){
    var formData = new FormData();
    var fileObj = file.files[0];
    formData.append('name',getQueryString('name'));
    formData.append('area',getQueryString('area'));
    formData.append('industry',getQueryString('industry'));
    formData.append('head_img',getQueryString('head_img'));
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
            window.location.href='payQRPublished.html';
            
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