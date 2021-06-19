layui.use(['table','layer','form'], function(){
    //var $ = layui.jquery
      var layer = layui.layer
        ,table  = layui.table
        ,form = layui.form;
    table.render({
        method: 'post',
        limit: 10,
        id:'main-table',
        headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
        elem: '#main-table',
        url: "/rbac/menu/get-menus",
        page: true,
        cols: [
            [ //表头
                {field: 'name', title: '菜单',  sort: true,templet: function (d){
                    return  '<div>'+d.name+'</div>';
                    }}
                ,{field: 'parent0.name', title: '父菜单',  sort: true,templet: function (d) {
                    if(d.parent0 !== null){
                        return d.parent0.name;
                    }else{
                        return '<div style="color:#f56c6c"> [未设置] </div>'
                    }
                }}
                ,{field: 'route', title: '路由', sort: true,templet: function (d) {
                    if(d.route !== ''){
                        return d.route;
                    }else{
                        return '<div style="color:#f56c6c"> [未设置] </div>'
                    }
                }}
                ,{field: 'order', title: '排序',  sort: true}
                ,{field: 'icon', title: '图标',style:"text-align:center",  sort: true,templet:function (d) {
                    return '<i class="'+d.icon+'"></i>';
                }}
                ,{
                fixed: 'right',
                width:220,
                title:'操作',
                align: 'center',
                toolbar: '#toolbar'
            }
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
                    reload()
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
        }else if(obj.event == 'del'){
            $.ajax({
                url: "/rbac/menu/delete",
                headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
                data: obj.data,
                type: "Post",
                dataType: "json",
                success: function (res) {
                    if(res.code==0){
                        layer.close(layer.index)
                        layer.msg(res.msg,{icon:1,time:1500});
                        layer.close();
                        obj.del();
                    }else{
                        layer.msg(res.msg, {icon: 5,time:1000});
                    }
                }
            });
        }
    })

    // 重新加载页面
    function reload(){
        table.reload('main-table', {
            page: {
                curr: 1
            }
        });
    }

    // 新增菜单弹窗
    $("#addMenuBtn").on('click',function () {
        layer.open({
            type:2,//弹出框类型
            shadeClose: true, //点击遮罩关闭层
            area : ["60%" , "100%"],
            title:'新增菜单',
            content:['/rbac/menu/create','no'],
            success: function(res, index){
            }
            ,yes: function(index, layero){
                var submit = $("#btnSubmit");
                submit.trigger('click');
            }
            ,end:function () {
                reload();
            }
        });
        return false;
    });

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

    // 请求更新菜单接口
    form.on('submit(update)', function(data){
        ajax("/rbac/user/update",data.field);
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

    // 异步请求
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
                    setTimeout(function () {
                        layer.closeAll()
                    },1500)
                    table.reload('main-table', {
                        page: {
                            curr: 1
                        }
                    });
                }else{
                    layer.msg(res.msg, {icon: 5,time:1000});
                }
            }
        });
        return false;
    }
});