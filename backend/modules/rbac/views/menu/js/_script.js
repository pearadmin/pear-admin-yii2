layui.use(['table','layer','form'], function(){
    var $ = layui.jquery
        ,layer = layui.layer
        ,form = layui.form;

    // 打开图标库
    var url = ["<?= yii\helpers\Url::to(['/tools/icon']); ?>",'yes'];
    $('.open-icon').click(function(){
        layer.open({title:'图标选择', type: 2, area: ['100%', '100%'], fix: true, maxmin: false, content: url});
    });

    $("#parentMenu").autocomplete({
        source:function (request,response) {
            var result = [];
            var limit = 5;
            var term = request.term.toLowerCase();
            $.each(r.data,function () {
                var item = this;
                if(term == '' || item.name.toLowerCase().indexOf(term) >= 0){
                    result.push(item);
                    limit--;
                    if(limit == 0){
                        return false;
                    }
                }
            })
            response(result);
        },
        focus: function (event, ui) {
            $('#parentMenu').val(ui.item.name);
            return false;
        },
        select: function (event, ui) {
            $("#parent_id").val(ui.item.id);
            $('#parentMenu').val(ui.item.name);
            return false;
        },
        search: function () {
            $("#parent_id").val('');
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        let parentName = '';
        if(item.parent0 === null){
            parentName = 'null';
        }else{
            parentName = item.parent0.name
        }
        return $("<li style='line-height: 20px;z-index: 999'>")
            .append($('<a>').append($('<b>').text(item.name)).append('<br>')
                .append($('<i>').text(parentName + ' | ' + item.route)))
            .appendTo(ul);
    }

    $("#routes").autocomplete({
        source:routes,
    })

    form.on('submit(addMenu)', function(data){
        $.ajax({
            url: '/rbac/menu/create',
            headers:{ "X-CSRF-Token":"<?= Yii::$app->request->csrfToken?>"},
            data: data.field,
            type: 'post',
            dataType: 'json',
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
    })
});