<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/component/pear/css/pear.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/admin/css/other/error.css');
?>
<div class="content">
    <img src="/plugins/admin/images/404.svg" alt="">
    <div class="content-r">
        <h1>404</h1>
        <p>抱歉，你访问的页面不存在或仍在开发中</p>
        <button class="pear-btn pear-btn-primary home-page">返回首页</button>
    </div>
</div>
