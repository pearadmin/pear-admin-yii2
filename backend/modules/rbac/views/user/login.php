<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->registerJs($this->render('js/login.js'));
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/admin/css/other/login.css',['position'=>\yii\web\View::POS_END,'depends'=>'yii\web\YiiAsset']);
$css = '.layui-form-item{margin-top:20px !important;}
        .help-block-error{color: #5FB878;text-indent: 4px;padding-top: 2px;}';
$this->registerCss($css);
?>
<body background="/plugins/admin/images/background2.svg" style="background-size: cover;">
    <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class' => 'layui-form']]); ?>
    <div class="layui-form-item">
        <img class="logo" src="/plugins/admin/images/logo.png" />
        <div class="title">Yii2 Template</div>
        <div class="desc">
            相 城 区 最 具 影 响 力 的 设 计 规 范 之 一
        </div>
    </div>
    <div class="layui-form-item">
        <?= $form->field($model, 'username')->label(false)->textInput(['class'=>'layui-input','placeholder'=>'账 户:admin','value'=>'xiaowu']) ?>
    </div>
    <div class="layui-form-item">
        <?= $form->field($model, 'password')->label(false)->passwordInput(['class'=>'layui-input','placeholder'=>'密 码 : admin ','value'=>'123']) ?>
    </div>
    <!--<div class="layui-form-item" >
        <input placeholder="验证码 : "  hover class="code layui-input layui-input-inline"  />
        <img src="/plugins/admin/images/captcha.gif" class="codeImage" />
    </div>-->
    <div class="layui-form-item">
        <div id="slider"></div>
    </div>
    <div class="layui-form-item">
        <?= $form->field($model, 'rememberMe')->label(false)->checkbox(["class"=>"input",'lay-skin'=>"primary",'title'=>'30天内自动登录']) ?>
    </div>
    <div class="layui-form-item">
        <?= Html::submitButton("登录", ['class' => 'pear-btn pear-btn-success login','lay-submit'=>'','name' => 'login-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<!-- 资 源 引 入 -->
</body>
