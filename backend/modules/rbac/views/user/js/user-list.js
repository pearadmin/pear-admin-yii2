layui.config({
}).use(['table','layer','form','dtree','treeSelect','ajax'], function(){
    var $ = layui.jquery
        ,layer = layui.layer
        ,table  = layui.table
        ,dtree  = layui.dtree
        ,ajax = layui.ajax
        ,treeSelect  = layui.treeSelect
        ,form = layui.form;
    // 初始化表单
    table.render({
        method: 'post',
        limit: 10,
        id:'main-table',
        skin: 'line',
        height: 'full-150',
        headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
        elem: '#main-table',
        url: "/rbac/user/user-list", //数据接口
        toolbar: '#main-table-toolbar',
        page: true, //开启分页
        cols: [
            [ //表头
                {type:'checkbox'}
                ,{field: 'username', title: '账号'}
                ,{field: 'nickname', title: '昵称' }
                ,{field: 'status', title: '状态', sort: true,templet:function (d) {
                    if(d.status == 10){
                        return '<span style="color: rgb(0, 128, 0)">启用</span>';
                    }else if(d.status == 9){
                        return '<span style="color: rgb(255,73,87)">禁用</span>';
                    }
                }}
                ,{field: 'is_online',align:'center', title: '是否在线',templet:function (d) {
                    if(d.is_online == 1){
                        return '<div class="is_online" style="background:#5FB878"></div>';
                    }else if(d.is_online == 0){
                        return '<div class="is_online" style="background: grey;"></div>';
                    }else{
                        return '<div class="is_online" style="background: red;"></div>';
                    }
                }}
                ,{field: 'dept_name', title: '部门'}
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

    dtree.render({
        url: "/rbac/dept/get-depts",
        method: 'post',
        elem: "#organizationTree",
        initLevel: "4", //默认展开层级为1
        line: true, // 有线树
        ficon: ["1", "-1"], // 设定一级图标样式。0表示方形加减图标，8表示小圆点图标
        icon: ["0", "2"], // 设定二级图标样式。0表示文件夹图标，5表示叶子图标
    });

    dtree.on("node(organizationTree)", function(obj) {
        table.reload('main-table', {
            page: {
                curr: 1 //重新从第 1 页开始
            },where:{
                param:obj.param
                ,childParams:obj.childParams
            }
        });
    });

    treeSelect.render({
        elem: '#dtreeSelect',
        data: '/rbac/dept/get-slt-depts',
        type: 'post',
        placeholder: '修改默认提示信息',
        search: true,
        click: function(d){
            $('input[name="dept_id"]').val(d.current.id);
        },
        success: function (d) {
        }
    });

    table.on('tool(main-table)', function(obj){
        if(obj.event == 'edit'){
            let This = $("#updateUserCard");
            This.find('input[name="status"]').prop("checked",obj.data.status == 10 ? true:false);
            This.find('input[name="username"]').val(obj.data.username);
            This.find('input[name="nickname"]').val(obj.data.nickname);
            This.find('input[name="id"]').val(obj.data.id);
            form.render();
            $('input[name="dept_id"]').val(obj.data.dept_id);
            treeSelect.checkNode('dtreeSelect',obj.data.dept_id);
            treeSelect.refresh('dtreeSelect');
            layer.open({
                type : 1,
                area : ['80%' , '80%'],
                title : "修改",
                content : $("#updateUserCard"),
                success : function(index, layero) {
                }
                ,yes: function(index, layero){
                    var submit = $("#update-btn");
                    submit.trigger('click');
                }
                ,btn : [ '保存','关闭' ]
            });
        }else if(obj.event == 'power'){
            layer.open({
                type : 2,
                area : ['100%' , '100%'],
                title : "权限修改:"+obj.data.username,
                content : ['/rbac/user/user-update?id='+obj.data.id,'no'],
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
        }else if(obj.event == 'remove'){
            layer.confirm('确定删除 '+obj.data.username+' ?',{title:'删除',icon:3},function () {
                ajax.post('/rbac/user/delete-all',obj.data,function (d) {
                    obj.del();
                    layer.msg(d.msg,{icon:d.icon})
                });

            })
        }
    })

    table.on('toolbar(main-table)', function(obj) {
        if (obj.event === 'add') {
            window.add();
        } else if (obj.event === 'refresh') {
            window.refresh();
        } else if (obj.event === 'batchRemove') {
            window.batchRemove(obj);
        }else if(obj.event === 'more'){
            window.more(obj);
        }
    });

    form.on('submit(add)', function(data){
        ajax.post('/rbac/user/insert',data.field,function (d) {
            layer.msg(d.msg,{icon:d.icon,time:1500});
            if(d.code == 200){
                table.reload('main-table', {
                    page: {
                        curr: 1
                    }
                });
                layer.close(add_lay); //再执行关闭
                $(".layui-form")[3].reset();
                form.render();
            }
        })
        return false;
    })

    // 请求更新角色接口
    form.on('submit(update)', function(data){
        ajax.post('/rbac/user/update',{data:data.field},function (d) {
            layer.msg(d.msg,{icon:d.icon})
            table.reload('main-table', {
                page: {
                    curr: 1
                }
            });
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

    // 查询所有
    $('button[data-target="search-all"]').click(function () {
        table.reload('main-table', {
            page: {
                curr: 1 //重新从第 1 页开始
            },where:{
                param:{
                    'nodeId':''
                }
            }
        });
    })

    var add_lay;
    window.add=function () {
        add_lay = layer.open({
            type:1,//弹出框类型
            shadeClose: true, //点击遮罩关闭层
            area : ["50%" , "50%"],
            title:'新增人员',
            content:$("#addUserCard"),
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
    }

    window.batchRemove = function (obj) {
        let data = table.checkStatus(obj.config.id).data;
        if (data.length === 0) {
            layer.msg("未选中数据", {
                icon: 3,
                time: 1000
            });
            return false;
        }

        layer.confirm('确定要删除这些用户', {
            title: '是否删除?   <span style="color:red;font-size:4px;">(确认删除请输入"确认删除")</span>',
            content:'<input type="text" data-target="confirm" class="layui-input" placeholder="确认删除">'
        }, function(index,o) {
            layer.close(index);
            if($('input[data-target="confirm"]').val() != '确认删除'){
                layer.msg('删除取消',{icon:2})
                return false;
            }

            let loading = layer.load();
            ajax.post('/rbac/user/delete-all',{data},function (d) {
                layer.close(loading);
                layer.msg(d.msg,{icon:d.icon})
                table.reload('main-table', {
                    page: {
                        curr: 1
                    }
                });
            })
        });
    }

    window.more = function (obj) {
        $('div[attr="con"]').toggleClass(function () {
            if($(this).index() == 0){
                var c = $(this).hasClass('layui-col-md3')?'layui-col-md3':'hidden';
                var _c = $(this).hasClass('layui-col-md3')?'hidden':'layui-col-md3';
            }else{
                var c = $(this).hasClass('layui-col-md9')?'layui-col-md9':'layui-col-md12';
                var _c = $(this).hasClass('layui-col-md9')?'layui-col-md12':'layui-col-md9';
            }
            $(this).removeClass(c);
            return _c;
        })
    }
})