<?php
use backend\assets\PearAsset;
PearAsset::register($this);
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/admin/css/other/login.css');

?>
<body background="/plugins/admin/images/background2.svg" style="background-size: cover;">
<form class="layui-form" action="javascript:void(0);">
    <div class="layui-form-item">
        <img class="logo" src="/plugins/admin/images/logo.png" />
        <div class="title">Pear Admin</div>
        <div class="desc">
            明 湖 区 最 具 影 响 力 的 设 计 规 范 之 一
        </div>
    </div>
    <div class="layui-form-item">
        <input placeholder="账 户 : admin " hover class="layui-input"  />
    </div>
    <div class="layui-form-item">
        <input placeholder="密 码 : admin " hover class="layui-input"  />
    </div>
    <div class="layui-form-item">
        <input placeholder="验证码 : "  hover class="code layui-input layui-input-inline"  />
        <img src="/plugins/admin/images/captcha.gif" class="codeImage" />
    </div>
    <div class="layui-form-item">
        <input type="checkbox" name="" title="记住密码" lay-skin="primary" checked>
    </div>
    <div class="layui-form-item">
        <button type="button" class="pear-btn pear-btn-success login" lay-submit lay-filter="login">
            登 入
        </button>
    </div>
</form>
<!-- 资 源 引 入 -->
</body>
