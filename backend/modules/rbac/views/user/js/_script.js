layui.use(['table','layer','form'], function(){
    var $ = layui.jquery
        ,layer = layui.layer
    function updateItems(r) {
        _opts.items.available = r.available;
        _opts.items.assigned = r.assigned;
        search('available');
        search('assigned');
    }
    $('.search[data-target]').keyup(function () {
        search($(this).data('target'));
    });

    $('.btn-assign').click(function () {
        var $this = $(this);
        var target = $this.data('target');
        var items = $('select.list[data-target="' + target + '"]').val();
        if (items && items.length) {
            var index = layer.load(2, {time: 60*1000});
            $.post($this.attr('href'), {children: items,index:target=='available'?0:1,parent:_parent}, function (r) {
                r = JSON.parse(r);
                layer.close(index);
                if(r.code == 200){
                    updateItems(r.data);
                }else{
                    layer.msg(r.msg);
                }
            }).always(function () {
            });
        }
        return false;
    });

    function search(target) {
        var $list = $('select.list[data-target="' + target + '"]');
        $list.html('');
        var q = $('.search[data-target="' + target + '"]').val();
        var groups = {
            role: [$('<optgroup label="角色列表">'), false],
            permission: [$('<optgroup label="权限列表">'), false],
            route: [$('<optgroup label="Routes">'), false],
        };
        $.each(_opts.items[target], function (name, group) {
            if (name.indexOf(q) >= 0) {
                $('<option>').text(name).val(name).appendTo(groups[group][0]);
                groups[group][1] = true;
            }
        });
        $.each(groups, function () {
            if (this[1]) {
                $list.append(this[0]);
            }
        });
    }

    // initial
    search('available');
    search('assigned');

});