layui.config({
}).use(['form', 'element', 'jquery', 'button', 'popup','sliderVerify'], function() {
    var form = layui.form;
    var element = layui.element;
    var button = layui.button;
    var sliderVerify = layui.sliderVerify;
    var popup = layui.popup;
    var $ = layui.jquery;

    // 滑块验证
    var slider = sliderVerify.render({
        elem: '#slider'
    })

    // 登 录 提 交
    form.on('submit(login)', function(data) {
        if(slider.isOk()){//用于表单验证是否已经滑动成功
            button.load({
                elem: '.login',
                time: 1500,
                done: function() {
                    popup.success("登录成功", function() {
                        location.href = "login"
                    });
                }
            })
        }else{
            layer.msg("请先通过滑块验证");
        }
        return false;
    });


    //监听提交
    form.on('submit(formDemo)', function(data) {
        if(slider.isOk()){//用于表单验证是否已经滑动成功
            layer.msg(JSON.stringify(data.field));
        }else{
            layer.msg("请先通过滑块验证");
        }
        return false;
    });
})