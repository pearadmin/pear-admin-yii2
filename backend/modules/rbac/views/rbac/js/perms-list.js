layui.use(['table','layer','form','ajax'], function(){
    var $ = layui.jquery
        ,layer = layui.layer
        ,table  = layui.table
        ,ajax  = layui.ajax
        ,form = layui.form;
    //监听单元格编辑
    table.on('edit(main-table)', function(obj){
        layer.confirm("是否确认修改?",{
            btn1:function () {
                ajax.post('/rbac/rbac/update-item',obj.data,function (d) {
                    layer.msg(d.msg,{icon:d.code == 200?1:7});
                    table.reload('main-table', {
                        page: {
                            curr: 1
                        }
                    });
                })
            }
            ,btn2:function () {
                table.reload('main-table', {
                    page: {
                        curr: $(".layui-laypage-em").next().html()
                    }
                })
            }
        });
    });

    //监听单元格修改和删除
    table.on('tool(main-table)', function(obj){
        if(obj.event === 'edit'){
            layer.open({
                type : 2,
                area : ['100%' , '100%'],
                title : '权限管理 / '+obj.data.name,
                content : ['/rbac/rbac/item-update?item='+obj.data.name,'no'],
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500);
                }
                ,end:function () {
                }
            });
        }else if(obj.event === 'del'){
            layer.confirm("是否确认删除?",{
                btn1:function () {
                    ajax.post('/rbac/rbac/update-permissions',{perms:[{value:obj.data.name}],oType:1},function (d) {
                        layer.msg(d.msg,{icon:d.code == 200?1:7});
                        obj.del();
                    })
                }
            })
        }
    })

    // 新增权限
    $("#addPermsBtn").on('click',function () {
        layer.open({
            type:1,//弹出框类型
            shadeClose: true, //点击遮罩关闭层
            area : ["50%" , "50%"],
            shift:1,
            content:$("#addPermsCard"),
            success: function(res, index){
            }
            ,yes: function(index, layero){
                var submit = $("#btnSubmit");
                submit.trigger('click');
            },btn2:function () {
                $(".layui-form")[3].reset();
                form.render();
            }
            ,btn : [ '保存','关闭' ]
        });
        return false;
    });

    // 新增权限
    form.on('submit(add)', function(data){
        $.ajax({
            url: "/rbac/rbac/add-perms",
            headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
            data: data.field,
            type: "Post",
            dataType: "json",
            success: function (res) {
                if(res.code==200){
                    layer.close(layer.index)
                    layer.msg(res.msg,{icon:1,time:1500});
                    table.reload('main-table', {
                        page: {
                            curr: 1
                        }
                    });
                    layer.close();
                    $(".layui-form")[3].reset();
                    form.render();
                }else{
                    layer.msg(res.msg, {icon: 5,time:1000});
                }
            }
        });
        return false;
    })

    // 条件搜索
    form.on('submit(search)', function(data){
        table.reload('main-table', {
            page: {
                curr: 1 //重新从第 1 页开始
            },where:data.field
        });
        return false;
    });

    function ajax(url,data,dataType = 'json',type = 'post') {
        $.ajax({
            url: url,
            headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
            data: data,
            type: type,
            dataType: dataType,
            success: function (res) {
                if(res.code==0){
                    layer.msg(res.msg,{icon:1,time:1500});
                }else{
                    layer.msg(res.msg, {icon: 5,time:1000});
                }
            }
        });
        table.reload('main-table', {
            page: {
                curr: 1
            }
        });
        return false;
    }
});