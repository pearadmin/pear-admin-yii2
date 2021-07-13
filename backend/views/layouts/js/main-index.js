$(document).on('click', '.home-page', function() {
    window.location.href = '/';
});
$.ajaxSetup({
    complete:function(XMLHttpRequest,textStatus){
        console.log(textStatus);
        if(XMLHttpRequest.responseText == 'Forbidden (#403): 需要登录'){
             layer.confirm(this.url+':<br/>'+XMLHttpRequest.responseText,{btn:['确定','取消'],title:XMLHttpRequest.status,icon:7,id: 'LAY_layuipro'},
                 function () {
                     window.location.reload();
                 },function () {
                 })
         }else if(XMLHttpRequest.responseText == 'Forbidden (#403): 您没有执行此操作的权限。'){
            layer.confirm(this.url+':<br/>'+XMLHttpRequest.responseText,{btn:['确定'],title:XMLHttpRequest.status,icon:7})
         }else if(XMLHttpRequest.status==404){
             layer.confirm(this.url+':<br/>'+XMLHttpRequest.responseText,{btn:['确定'],title:XMLHttpRequest.status,icon:7})
         }else if(XMLHttpRequest.status == 500){
             layer.confirm(this.url+':<br/>500 ('+XMLHttpRequest.statusText+')',{btn:['确定'],title:XMLHttpRequest.status,icon:7})
         }else if(textStatus == 'error'){
            layer.confirm(this.url+':<br/>Forbidden (#403): 您没有执行此操作的权限。',{btn:['确定'],title:XMLHttpRequest.status,icon:7})
        }
    }
});