layui.use(['table','layer','form','jquery','treetable'], function(){
    var layer = layui.layer
        ,table  = layui.table
        ,treetable = layui.treetable
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
        url: "/rbac/menu/get-menu-list",
        page: true,
        cols: [
            [
                {type: 'checkbox'},
                {field: 'powerName', minWidth: 200, title: '菜单名称'},
                {field: 'route', minWidth: 200, title: '路由',templet:function (d) {
                    if(d.route == ''){
                        return '<span style="color:#f56c6c">(未设置)</span>';
                    }else {
                        return d.route;
                    }
                    }},
                {field: 'parent0', title: '父菜单',templet:function (d) {
                    if(d.parent0 !== null){
                        return d.parent0.name;
                    }else{
                        return '目录';
                    }
                }},
                {field: 'sort', title: '排序'},
                {field: 'icon', title: '图标',templet:'#icon'},
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
                area : ['80%' , '90%'],
                title : "菜单修改",
                content : ['/rbac/menu/update?id='+obj.data.id,'no'],
                success : function(layero, index){
                }
                ,end:function () {
                    location.reload();
                }
            });
        }else if(obj.event == 'detail'){
            layer.open({
                type : 2,
                area : ['60%' , '60%'],
                title : "菜单详情",
                content : ['/rbac/menu/view?id='+obj.data.id,'no'],
                success : function(layero, index){
                }
                ,end:function () {
                }
            });
        }else if(obj.event == 'remove'){
            layer.confirm('确定删除？',function () {
                $.ajax({
                    url: "/rbac/menu/delete",
                    headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
                    data: obj.data,
                    type: "Post",
                    dataType: "json",
                    success: function (res) {
                        if(res.code==200){
                            layer.close(layer.index)
                            layer.msg(res.msg,{icon:1,time:1500});
                            layer.close();
                            obj.del();
                        }else{
                            layer.msg(res.msg, {icon: 5,time:1000});
                        }
                    }
                });
            });
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
            area : ["60%" , "90%"],
            title:'新增菜单',
            content:['/rbac/menu/create','no'],
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
            ids += data[i].powerId + ",";
        }
        ids = ids.substr(0, ids.length - 1);
        layer.confirm('确定要删除这些权限', {
            icon: 3,
            title: '提示'
        }, function(index) {
            layer.close(index);
            let loading = layer.load();
            $.ajax({
                url: MODULE_PATH + "batchRemove/" + ids,
                dataType: 'json',
                type: 'delete',
                success: function(result) {
                    layer.close(loading);
                    if (result.success) {
                        layer.msg(result.msg, {
                            icon: 1,
                            time: 1000
                        }, function() {
                            table.reload('user-table');
                        });
                    } else {
                        layer.msg(result.msg, {
                            icon: 2,
                            time: 1000
                        });
                    }
                }
            })
        });
    }

    window.reload = function(data = ''){
        table.reload('main-table', {
            url:"/rbac/menu/get-menu-list",
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

    // 条件搜索
    form.on('submit(search)', function(data){
        if(!(data.field.name == '' && data.field.route == '')){
            window.reload(data.field);
        }else{
            location.reload();
        }
        return false;
    });
});