<?php
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/component/pear/css/pear.css');
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/admin/css/other/error.css');
?>
<div class="content">
    <img src="/plugins/admin/images/403.svg" alt="">
    <div class="content-r">
        <h1>403</h1>
        <p>抱歉，你无权访问该页面</p>
        <button class="pear-btn pear-btn-primary home-page">返回首页</button>
    </div>
</div>
