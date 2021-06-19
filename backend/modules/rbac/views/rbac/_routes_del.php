<style>
    li{margin-left:20px;}
     .pe-title{
        font-size: 18px;
         padding-left:10px;
    }
</style>
<div class="layui-card-body">
        <fieldset class="layui-elem-field layui-field-title"    >
            <legend>添加路由</legend>
        </fieldset>
        <div id="routes" class="routes-transfer"></div>
    </div>
<script>
    layui.use(['transfer', 'layer', 'util'], function(){
        var $ = layui.$
            ,transfer = layui.transfer
            ,layer = layui.layer
            ,util = layui.util;

        // 初始化数据和数据穿梭处理
        $.get("/rbac/rbac/getroutes",{},function (res) {
            //实例调用
            transfer.render({
                elem: '#routes'
                ,data: res.data
                ,value: res.value
                ,width:"45%"
                ,height:650
                ,title:['未配置路由','已配置路由']
                ,showSearch: true
                ,onchange: function(obj, index){    // index 0:左边传值给右边
                    var loading = layer.load(1, {
                        shade: 0.1,
                        time: 60000
                    });
                    $.ajax({
                        url:"/rbac/rbac/updateroutes" ,
                        type:'POST',
                        headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
                        data:{
                            index:index
                            ,obj:obj
                        },
                        dataType : "json",
                        success: function(res) {
                            layer.close(loading);
                            if(res.code != 0){
                                layer.open({
                                    time:5000,
                                    content : "<label style='padding:50px;line-height: 22px;background-color: #122b40;color: red;font-weight: 700 '>"+res.msg+"</label>",
                                });
                            }else{
                                layer.msg(res.msg, {icon: 1,time:1000});
                            }
                        },
                        error:function(){
                            layer.close(loading);
                            layer.msg('System error', {icon: 0,time:2000});
                        }
                    });
                }
            })
            $(".layui-transfer-data").prepend("<span class='pe-title'>Routes</span>")
        },"json");
    });
</script>
