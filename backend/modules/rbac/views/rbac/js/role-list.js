layui.use(['table','layer','form','ajax'], function(){
    var $ = layui.jquery
        ,layer = layui.layer
        ,table  = layui.table
        ,ajax = layui.ajax
        ,form = layui.form;
    //监听单元格编辑
    table.on('edit(main-table)', function(obj){
        layer.confirm("是否确认修改?",{
            btn1:function () {
                //ajax('/rbac/rbac/update-item',obj.data);
                ajax.post('/rbac/rbac/update-item',obj.data,function (d) {
                    if(d.code == 0){
                        layer.msg(d.msg,{icon:1});
                    }
                })
            }
            ,btn2:function () {
                table.reload('main-table', {
                    page: {
                        curr: 1
                    }
                })
            }
        });
    });

    //监听单元格修改和删除
    table.on('tool(main-table)', function(obj){
        if(obj.event === 'power'){
            layer.open({
                type : 2,
                area : ['100%' , '100%'],
                title : "配置 子角色/权限/路由",
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
        }else if(obj.event === 'remove'){
            layer.confirm("是否确认删除?",{
                btn1:function () {
                    obj.data['otype'] = "1";
                    ajax.post('/rbac/rbac/update-role',{name:obj.data.name,description:obj.data.description,otype:obj.data.otype},function (d) {
                        if(d.code==0){
                            layer.msg(d.msg,{icon:1,time:1500});
                        }else{
                            layer.msg(d.msg, {icon: 5,time:1000});
                        }
                    })
                    obj.del();
                    return false;
                }
            });
        }
    })

    // 新增角色
    $("#addRoleBtn").on('click',function () {
        layer.open({
            type:1,//弹出框类型
            shadeClose: true, //点击遮罩关闭层
            area : ["50%" , "50%"],
            shift:1,
            title: '新增角色',
            content:$("#addRoleCard"),
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

    // 新增角色
    form.on('submit(add)', function(data){
        data.field['otype'] = "0";
        ajax.post('/rbac/rbac/update-role', data.field,function (d) {
            if(d.code==0){
                layer.close(layer.index)
                layer.msg(d.msg,{icon:1,time:1500});
                table.reload('main-table', {
                    page: {
                        curr: 1
                    }
                });
                layer.close();
                $(".layui-form")[3].reset();
                form.render();
            }else{
                layer.msg(d.msg, {icon: 5,time:1000});
            }
        })
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
});