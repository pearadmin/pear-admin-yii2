layui.use(['form','treeSelect','ajax'], function(){
    var treeSelect  = layui.treeSelect
        ,form = layui.form
        ,ajax = layui.ajax;

    treeSelect.render({
        elem: '#dtreeSelect',
        data: '/rbac/dept/get-slt-depts',
        type: 'get',
        placeholder: '无父部门',
        value:'0',
        search: true,
        click: function(d){
            $('input[name="parent"]').val(d.current.id)
        },
        success: function (d) {
            if($('input[name="parent"]').val() == ''){
                $('input[name="parent"]').val(0)
            }else if($('input[name="parent"]').val() != 0){
                treeSelect.checkNode('dtreeSelect', $('input[name="parent"]').val());
            }
        }
    });

    form.on('submit(update)', function(data){
        ajax.post('/rbac/dept/update',{"Dept":data.field},function (d) {
            if(d.code == 200){
                layer.msg(d.msg,{icon:1});
                window.parent.location.reload()
            }else if(d.code == 400){
                layer.msg(d.msg,{icon:2});
            }

        })
        return false;
    })

    form.on('submit(create)', function(data){
        ajax.post('/rbac/dept/create',{"Dept":data.field},function (d) {
            if(d.code == 200){
                layer.msg(d.msg,{icon:1});
                window.parent.location.reload()
            }else if(d.code == 400){
                layer.msg(d.msg,{icon:2});
            }

        })
        return false;
    })
});
