layui.define([], function (exports) {
    var $ = layui.jquery;
    let ws;

    const gatewayWorker = new function(){
        this.WebSocket = function (url,data) {
            ws =  new WebSocket(url);
            ws.onmessage = function(e) {
                var msg =  JSON.parse(e.data);
                
                switch (msg.type) {
                    case "init":    // 链接成功，返回初始化数据
                        var bild = '{"type":"bind","fromid":"'+data.Uid+'"}';
                        ws.send(bild);
                        return;
                    case "say":     // 推送过来的消息
                        // TODO
                        return;
                    case "save":    // 推送对方是否读取消息
                        // TODO
                        return;
                    case  "online": // 推送对方在线状态
                        // TODO
                        return;
                    case "onclose": // 推送对方下线通知
                        // TODO
                        return;
                }
            }
        }
    }

    exports('gatewayWorker', gatewayWorker);
})