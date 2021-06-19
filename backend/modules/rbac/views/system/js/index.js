layui.use(['table','layer','form','element','ajax','dropdown','form','upload','ajax'], function(){
    var $ = layui.jquery
        ,layer = layui.layer
        ,table  = layui.table
        ,element = layui.element
        ,ajax = layui.ajax
        ,form = layui.form
        ,upload = layui.upload
        ,ajax = layui.ajax;

    // 条件搜索
    form.on('submit(search)', function(data){
        table.reload('dir-table', {
            page: {
                curr: 1 //重新从第 1 页开始
            },where:data.field
        });
        return false;
    });

    $(document).on('click', '.panel-more', function() {
        $(".pannel-list").toggle()
    });

    $(document).on('click', '.open-icon', function() {
        var THIS = $(this).parent();
        var url = ["<?= yii\helpers\Url::to(['/tools/icon?directSubmit=1']); ?>",'yes'];
        var index = layer.open({title:'图标选择', type: 2, area: ['80%', '80%'], fix: true, maxmin: false, content: url,btn: ['确定'],yes:function () {
                $(this).parent().find('input').val();
                THIS.find('input').val($('input[id="icon"]').val())
                THIS.find('span').attr('class',$('input[id="icon"]').val())
                layer.close(index)
            }});
    });

    $(document).on('click', '.dir', function() {
        data = $('input[name="cur_route"]').val()+$(this).attr("data-value")
        reloadDir(data);
    });

    $(document).on('click', '.sli', function() {
        $('.route-text').prop('type','text');
        var _val=$(".route-text").val();
        $(".route-text").val("").focus().val(_val);
        $('.oli,.fli').hide()
    });

    $(document).on('click', '.pannel-add', function() {
        var i = $('input[name="links_title[]"]').length;
        pannel_data.data = [];
        $('tbody').find('tr').each(function (i,v) {
            new_data = {
                'href':$(this).find('input[name="links_href[]"]').val()
                ,'icon':$(this).find('input[name="links_icon[]"]').val()
                ,'title':$(this).find('input[name="links_title[]"]').val()
            }
            pannel_data.data.push(new_data);
        })

        var new_data = {
            'href':''
            ,'icon':''
            ,'title':''
        }
        pannel_data.data.push(new_data);
        table.reload('pannel-table',{
            where:{action:'add',data:pannel_data}
            ,done:function () {
                $('input[name="links_title[]"]').eq(i).focus()
            }
        });

    });

    $(document).on('blur', '.route-text', function() {
        let str = $('input[name="cur_route"]').val()
        let arr = str.split('/')
        let _str = '';
        for(let i = 0 ;i<arr.length - 1;i++){
            _str += arr[i]+'/';
        }
        reloadDir(_str);
        $('.route-text').prop('type','hidden');
        $('.oli,.fli').show()
    })

    $(document).on('click', '.back', function() {
        let str = $('input[name="cur_route"]').val()
        let arr = str.split('/')
        let _str = '';
        for(let i = 0 ;i<arr.length-2;i++){
            _str += arr[i]+'/';
        }
        reloadDir(_str);
    });


    $(document).on('click', '.tz', function() {
        reloadDir($('input[name="cur_route"]').val());
    })

    $(document).on('click', '.oli,.fli', function() {
       let cur_file = $(this).attr('data-value');
        let str = $('input[name="cur_route"]').val()
        let arr = str.split('/')
        let _str = '';
        if(cur_file != ''){
            for(let i = 0 ;i<arr.length-1;i++){
                _str += arr[i]+'/';
                if(cur_file == arr[i]){
                    break;
                }
            }
        }
        reloadDir(_str);
    })

    $(document).on('click', '.fold-count', function() {
        data = $('input[name="cur_route"]').val()+$(this).attr("data-value")
        let This = $(this)
        ajax.post('/rbac/system/get-folder-size',{path:data},function (d) {
            if(d.code == 0){
                This.html(d.size)
                This.removeClass('fold-count');
            }
        })
    });

    window.reloadDir = function(data = ''){
        table.reload('dir-table', {
            page: {
                curr: 1
            },where:{
                data:data
            },done:function (d) {
                let cur_route = $('input[name="cur_route"]');
                cur_route.val(d.cur_route)

                $('.oul .oli').remove()
                $('.oul .sli').remove()
                let arr = d.cur_route.split('/');
                for(let i = 0;i<arr.length-1; i++){
                    $('.oul').append('<li class="oli" data-value="'+arr[i]+'">'+arr[i]+'</li>')
                }
                for(i = 0;i< 10;i++){
                    $('.oul').append('<li class="sli"></li>')
                }
                createFile();
            }
        });
    }

    // 文件table
    table.render({
        method: 'post',
        id:'dir-table',
        elem: '#dir-table',
        page:true,
        skin: 'line',
        limit: 20,
        toolbar: '#main-table-toolbar',
        url: "/rbac/system/getdirs",
        cols: [[
            {checkbox:true},
            {field: 'name', title: '文件名', templet:function (d) {
                if(d.file_type == 'directory'){
                    let arr = d.name.split('/');
                    return '<span class="td-dir td-span"></span><a class="dir" style="cursor: pointer;" data-value="'+d.name+'">'+arr[0]+'</a>';
                }else if(d.file_type == 'jpeg'||d.file_type == 'jpg'||d.file_type == 'png'){
                    return '<span class="td-span td-image"></span><a  data-value="'+d.name+'">'+d.name+'</a>';
                }else if(d.file_type == 'zip'){
                    return '<span class="td-span td-zip"></span><a  data-value="'+d.name+'">'+d.name+'</a>';
                }else if(d.file_type == 'pdf'){
                    return '<span class="td-span td-pdf"></span><a  data-value="'+d.name+'">'+d.name+'</a>';
                }else if(d.file_type == 'txt'){
                    return '<span class="td-span td-txt"></span><a  data-value="'+d.name+'">'+d.name+'</a>';
                }else{
                    return '<span class="td-span td-other"></span><a  data-value="'+d.name+'">'+d.name+'</a>';
                }
                }}
            ,{field: 'size', title: '大小',templet:function (d) {
                if(d.type == '2'){
                    return d.size;
                }else{
                    return '<span class="fold-count" data-value="'+d.name+'">点击计算</span>';
                }
                }}
            ,{field: 'permission', title: '权限'}
            ,{field: 'updated_at', title: '修改时间'}
            ,{field: 'owner', title: '所有者',templet: '<div>{{d.owner.name}}</div>'}
            ,{
                fixed: 'right',
                width:220,
                title:'操作',
                align: 'center',
                toolbar: '#toolbar'
            }
        ]],
        done: function (res, curr, count) {
        } ,height: 'full-180'
    });

    // 面板表单table
    var pannel_data; //临时存储面板表单数据
    table.render({
        method: 'post',
        id: 'pannel-table',
        elem: '#pannel-table',
        skin: 'line',
        escape: true,
        limit: 20,
        toolbar:false,
        url: "/rbac/system/get-links",
        cols: [[
            {field: 'title', title: '标题','edit':'text',width:'30%',templet:function (d) {
    return '<input class="panel-item"  placeholder="请输入标题"  name="links_title[]"  value="'+d.title+'">';
                }},
            {field: 'href', title: '链接','edit':'text',width:'30%',templet:function (d) {
                    return '<input placeholder="请输入链接" class="panel-item" name="links_href[]"  value="'+d.href+'">';
                }
            },
            {field: 'icon', title: '图标',width:'30%',templet:function (d) {
                return '<span class="'+d.icon+'"></span><input placeholder="请选择图标" style="margin-left:10px;cursor:pointer;width:80%;"  class="panel-item open-icon" name="links_icon[]"  value="'+d.icon+'">';
                }
            },{
                width:"8%",
                title:'操作',
                toolbar: '#pannel-tr-set',
                style:"color:red"
            }
        ]],
        done:function (res) {
            pannel_data = res;
        }
    });

    table.on('toolbar(dir-table)', function (obj) {
        switch (obj.event) {
            case 'del':
                ajax.post('/rbac/system/del',{
                    data:layui.table.checkStatus('dir-table').data
                    ,'cur_route':$('input[name="cur_route"]').val()
                },function (d) {
                    layer.msg(d.msg,{icon:d.code == 0 ?1:7 });
                    reloadDir($('input[name="cur_route"]').val());
                })
                break;
        }
    })

    table.on('tool(pannel-table)', function (obj) {
        switch (obj.event) {
            case 'remove':
                obj.del();
                break;
        }
    })

    window.createFile = function (){
        $('.btn-down').click(function () {
            $('.btn-ul').toggle()
        })

        $('.create-file').click(function () {
            let o_type = $(this).attr('data-value');
            let p = o_type =='dir'?'目录名':'文件名'
            layer.open({
                title: o_type == 'dir'?'新建目录':'新建空白文件'
                ,content: '<input type="text" class="layui-input file-name" placeholder="'+p+'" >'
                ,btn: ['确定', '取消']
                ,yes:function (index,layero) {
                    ajax.post('/rbac/system/create'
                        ,{
                            'file_name':$(".file-name").val()
                            ,'type':o_type
                            ,'cur_route':$('input[name="cur_route"]').val()
                        }
                        ,function (d) {
                            if(d.code == 0){
                                layer.msg(d.msg,{icon:1})
                                reloadDir($('input[name="cur_route"]').val());
                            }else{
                                layer.msg(d.msg,{icon:7})
                            }
                        })
                },btn2:function (index,layero) {
                }
            })
        })
    }
    createFile();

    table.on('tool(dir-table)', function(obj){
        if(obj.event === 'rename'){
            layer.open({
                title: '更新名称'+obj.data.name
                ,content: '<input type="text" class="layui-input change-name" >'
                ,btn: ['确定', '取消']
                ,yes:function (index,layero) {
                    ajax.post('/rbac/system/rename'
                        ,{
                            'name':$(".change-name").val()
                            ,'data':obj.data
                            ,'cur_route':$('input[name="cur_route"]').val()
                        }
                        ,function (d) {
                            if(d.code == 0){
                                reloadDir($('input[name="cur_route"]').val());
                                layer.msg(d.msg,{icon:1})
                            }else{
                                layer.msg(d.msg,{icon:7})
                            }
                        })
                },btn2:function (index,layero) {
                }
            });
            let arr = obj.data.name.split('/');
            $(".change-name").val("").focus().val(arr[0]);
        }else if(obj.event === 'compress'){
            layer.open({
                title: '压缩文件'
                ,area : ['70%' , '50%']
                ,content: '压缩类型&nbsp;&nbsp;<input type="text" class="layui-input" style="width: 50%;display: inline-block" value="zip" disabled>' +
                    '<br/>压缩到&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="layui-input" style="width: 80%;margin-top:10px;display: inline-block" ' +
                    'value="/'+$('input[name="cur_route"]').val()+'" disabled>'
                ,btn: ['压缩', '取消']
                ,yes:function (index,layero) {
                        ajax.post('/rbac/system/compressed-file',{'data':obj.data,'cur_route':$('input[name="cur_route"]').val()},function (d) {
                            if(d.code == 0){
                                layer.msg(d.msg,{icon:1})
                                reloadDir($('input[name="cur_route"]').val());
                            }else{
                                layer.confirm(d.msg,{icon:2})
                            }
                        })
                }}
            )
        }else if(obj.event === 'remove'){
            layer.confirm("确认删除",{
                btn: ['删除', '取消']
            }, function () {
                ajax.post('/rbac/system/remove',{route:$('input[name="cur_route"]').val()  + obj.data.name},function (d) {
                    if(d.code == 0 ){
                        layer.msg('删除成功!',{icon:1})
                        reloadDir($('input[name="cur_route"]').val());
                    }else if(d.code == 1){
                        layer.msg(d.msg,{icon:7})
                    }
                })
            });
        }else if(obj.event === 'power'){
            layer.open({
                title: '修改权限:'+obj.data.name
                ,content: '<input type="text" class="layui-input power" value = '+obj.data.permission+' >'
                ,btn: ['确定', '取消']
                ,yes:function (index,layero) {
                    ajax.post('/rbac/system/update-perms'
                        ,{
                            'name':$(".power").val()
                            ,'data':obj.data
                            ,'cur_route':$('input[name="cur_route"]').val()
                        }
                        ,function (d) {
                            if(d.code == 0){
                                reloadDir($('input[name="cur_route"]').val());
                                layer.msg(d.msg,{icon:1})
                            }
                        })
                },btn2:function (index,layero) {
                }
            });
            let arr = obj.data.permission.split('/');
            $(".power").val("").focus().val(arr[0]);
        }
    })

    upload.render({
        elem: '.upload-file'
        ,url:'/rbac/system/upload'
        ,auto: false //选择文件后不自动上传
        ,exts:'png|jpeg|jpg'
        ,choose: function(obj){
            //将每次选择的文件追加到文件队列
            var files = obj.pushFile();
            //预读本地文件，如果是多文件，则会遍历。(不支持ie8/9)
            obj.preview(function(index, file, result){
                $('.pre-img').attr('src',result)
                $('input[name="file_name"]').val(file.name)
                $('input[name="file_content"]').val(result)
            });
            return false;
        }
    });

    form.on('submit(sys-submit)', function(data){
        $.ajax({
            type: "post",
            data: data.field,
            //traditional: true,//必须指定为true
            url: '/rbac/system/upload',
            dataType: "json",
            success: function(d){
                layer.msg(d.msg,{icon:d.icon});
            }
        });
        return false;
    });

    //监听导航点击
    element.on('nav(demo)', function(elem){
        layer.msg(elem.text());
    });

});