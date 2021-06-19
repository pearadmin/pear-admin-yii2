var ws =  new WebSocket("ws://127.0.0.1:8282");

ws.onmessage = function(e) {
    var msg =  JSON.parse(e.data);
    switch (msg.type) {                 // 链接成功，返回初始化数据
        case "init":
            var bild = '{"type":"bind","fromid":"'+user_id+'"}';
            ws.send(bild);
            return;
        case "say":
            console.log(msg);
            // 推送过来的消息
            return;
        case "say_img":
            // 推送过来的图片
            return;
        case "save":
            // 推送对方是否读取消息
            console.log(msg);
            return;
        case  "online":
            // 推送对方在线状态
            return;
        case "onclose":
            // 推送对方下线通知
            console.log(msg);
            return;
    }
}

$('a[data-target="a"]').click(function () {
    var toid = 1;
    var message = '{"data":"111","type":"say","fromid":"'+user_id+'","toid":"'+ toid +'"}';
    ws.send(message);
})

$(document).on('click', '.home-page', function() {
    window.location.href = '/';
});
$.ajaxSetup({
    complete:function(XMLHttpRequest,textStatus){
       /* if(XMLHttpRequest.responseText == 'Forbidden (#403): 需要登录'){
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
        }
        */
    }
});