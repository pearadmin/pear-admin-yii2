"<?php use yii\helpers\Url;?>"
$(function(){
    $('#diy_header').on('click',function (){
        var display = $('.option-checkbox-container').css('display');
        if(display == 'none'){
            $('.option-checkbox-container').css('display','inline');
            $(this).parent().parent().find('div').addClass('layui-form-selected layui-form-selectup');
        }else{
            $('.option-checkbox-container').css('display','none');
            $(this).parent().parent().find('div').removeClass('layui-form-selected layui-form-selectup');
        }
    });
    $('.layui-filter-panel li').on('click',function (){
        if($(this).find('input:checkbox').is(':checked')){
            $(this).find('input:checkbox').removeAttr('checked');
            $(this).find('div').removeClass('layui-form-checked');
        }else{
            $(this).find('input:checkbox').attr('checked','');
            $(this).find('div').addClass('layui-form-checked');
        }
    });
    $('#export').on('click',function (){
        var title = [];
        var field = [];
        $('.layui-filter-panel li input[type="checkbox"][checked]').each(function(){
            field.push($(this).attr('name'));
            title.push($(this).attr('title'));
        })
        var url = $('#url').val();
        Post("<?php echo Url::toRoute('"+url+"');?>",[
            { name:'field',value:field.join(',')},
            { name:'title',value:title.join(',')},
            { name:'param',value:$('#param').val()}
        ]);
    });
    /*
    *功能： 模拟form表单的提交
    *参数： URL 跳转地址 PARAMTERS 参数
    */
    function Post(URL, PARAMTERS) {
        //创建form表单
        var temp_form = document.createElement("form");
        temp_form.action = URL;
        //如需打开新窗口，form的target属性要设置为'_blank'
        temp_form.target = "_blank";
        temp_form.method = "post";
        temp_form.style.display = "none";
        //添加参数
        for (var item in PARAMTERS) {
            var opt = document.createElement("textarea");
            opt.name = PARAMTERS[item].name;
            opt.value = PARAMTERS[item].value;
            temp_form.appendChild(opt);
        }
        document.body.appendChild(temp_form);
        //提交数据
        temp_form.submit();
    }
});

