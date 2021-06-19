<?php
use backend\assets\AppAsset;
$js = 'var _opts ='.$opts.';var _parent= "'.$parent.'"' ;
$this->registerJs($js);
$this->registerJs($this->render('js/_script.js'));
AppAsset::register($this);
?>
<div class="auth-item-view">
    <div class="row transfer-content">
        <div class="col-sm-5">
            <input class="layui-form-control search" data-target="available" placeholder="查询未添加">
            <select multiple="" size="20" class="layui-form-control list" data-target="available">
            </select>
        </div>
        <div class="col-sm-1">
            <br/><br/>
            <a class="btn btn-success btn-assign" href="/rbac/user/update-user-child" title="Assign" data-target="available">&gt;&gt; </a><br><br>
            <a class="btn btn-success btn-assign" href="/rbac/user/update-user-child" title="Remove" data-target="assigned">&lt;&lt;</a>
        </div>
        <div class="col-sm-5">
            <input class="layui-form-control search" data-target="assigned" placeholder="查询已添加">
            <select multiple="" size="20" class="layui-form-control list" data-target="assigned">
            </select>
        </div>
    </div>
</div>

