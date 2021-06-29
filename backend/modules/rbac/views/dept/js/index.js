layui.use(['table','layer','form','jquery','treetable','treeSelect','ajax'], function(){
    var layer = layui.layer
        ,table  = layui.table
        ,treetable = layui.treetable
        ,ajax = layui.ajax
        ,form = layui.form;

    treetable.render({
        treeColIndex: 1,
        treeSpid: 0,
        treeIdName: 'powerId',
        treePidName: 'parentId',
        skin:'line',
        treeDefaultClose: false,
        toolbar:'#power-toolbar',
        method: 'post',
        limit: 10,
        id:'main-table',
        headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
        elem: '#main-table',
        url: "/rbac/dept/get-table-depts",
        page: true,
        cols: [
            [
                {type: 'checkbox'},
                {field: 'name', minWidth: 200, title: '部门'},
                {field: 'id', title: '父部门',templet:function (d) {
                        if(d.parent0 == null){
                            return '<i style="color: #f56c6c;">（未设置）</i>';
                        }else if(d.parent0.name != ''){
                            return d.parent0.name;
                        }
                    }},
                {field: 'order', title: '排序',templet:function (d) {
                        if(d.parent0 == null){
                            return '<i style="color:#f56c6c">'+d.order+'</i>';
                        }else if(d.parent0.name != ''){
                            return d.order;
                        }
                    }},
                {title: '操作',templet: '#power-bar', width: 150, align: 'center'}
            ]
        ],
        done: function (res, curr, count) {
        }
    });

    // 监听操作
    table.on('tool(main-table)', function(obj){
        if(obj.event == 'edit'){
            layer.open({
                type : 2,
                area : ['50%' , '60%'],
                title : "部门修改",
                content : ['/rbac/dept/update?id='+obj.data.id,'no'],
                success : function(layero, index){
                }
            });
        }else if(obj.event == 'remove'){
            ajax.post('/rbac/dept/delete',{id:obj.data.id},function (d) {
                layer.confirm('确定删除此部门?', {
                    icon: 3,
                    title: '提示'
                },function () {
                    if(d.code == 200){
                        obj.del();
                        layer.msg(d.msg,{icon:1,time:1000})
                    }else {
                        layer.msg(d.msg,{icon:2,time:1000})
                    }
                })
            });
            return false;
        }
    })

    table.on('toolbar(main-table)', function(obj){
        if(obj.event === 'add'){
            window.add();
        } else if(obj.event === 'refresh'){
            window.refresh();
        } else if(obj.event === 'batchRemove'){
            window.batchRemove(obj);
        }  else if(obj.event === 'expandAll'){
            treetable.expandAll("#main-table");
        } else if(obj.event === 'foldAll'){
            treetable.foldAll("#main-table");
        }
    });

    window.add = function(){
        layer.open({
            type:2,//弹出框类型
            shadeClose: true, //点击遮罩关闭层
            area : ["50%" , "60%"],
            title:'新增部门',
            content:['/rbac/dept/create','no'],
            success: function(res, index){
            }
            ,yes: function(index, layero){
                var submit = $("#btnSubmit");
                submit.trigger('click');
            }
            ,end:function () {
                location.reload();
            }
        });
        return false;
    }

    window.batchRemove = function(obj) {
        let data = table.checkStatus(obj.config.id).data;
        if (data.length === 0) {
            layer.msg("未选中数据", {
                icon: 3,
                time: 1000
            });
            return false;
        }

        let ids = "";
        for (let i = 0; i < data.length; i++) {
            ids += data[i].id + ",";
        }
        ids = ids.substr(0, ids.length - 1);
        layer.confirm('确定要删除这些部门', {
            icon: 3,
            title: '提示'
        }, function(index) {
            layer.close(index);
            let loading = layer.load();
            ajax.post('/rbac/dept/delete-all',{ids:ids},function (d) {
                layer.close(loading);
                if(d.code == 0){
                    window.location.reload();
                    layer.msg(d.msg,{icon:1,time:1000})
                }else if(d.code == 1){
                    layer.msg(d.msg,{icon:2,time:1000})
                }
            })
        });
    }

    window.reload = function(data = ''){
        let This = $('input[name="name"]');
        if(This.val() == false){
            window.location.reload()
            return false;
        }
        table.reload('main-table', {
            url:"/rbac/dept/get-table-depts",
            method: 'post',
            limit:'10',
            page: true,
            where:data
        });
    }

    form.on('submit(add)', function(data){
        $.ajax({
            url: "/rbac/user/insert",
            headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
            data: data.field,
            type: "Post",
            dataType: "json",
            success: function (res) {
                if(res.code==0){
                    layer.close(layer.index)
                    layer.msg(res.msg,{icon:1,time:1500});
                    layer.close();
                    $(".layui-form")[3].reset();
                    form.render();
                    reload();
                }else{
                    layer.msg(res.msg, {icon: 5,time:1000});
                }
            }
        });
    })

    form.on('submit(search)', function(data){
        if(!(data.field.name == '' && data.field.route == '')){
            window.reload(data.field);
        }else{
            location.reload();
        }
        return false;
    });
});