layui.config({
}).use(['form', 'element', 'jquery', 'button', 'popup'], function() {
    var form = layui.form;
    var element = layui.element;
    var button = layui.button;
    var popup = layui.popup;
    var $ = layui.jquery;
    // 登 录 提 交
    form.on('submit(login)', function(data) {
        button.load({
            elem: '.login',
            time: 1500,
            done: function() {
                popup.success("登录成功", function() {
                    location.href = "login"
                });
            }
        })
        return false;
    });
})