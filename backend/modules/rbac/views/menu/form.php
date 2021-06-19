<?php
$js = 'var r = '.$data.',routes = '.$routes.';';
$this->registerJs($js);
$this->registerJsFile(Yii::$app->request->baseUrl . '/plugins/admin/js/jquery-ui/js/jquery-ui.js');
$this->registerCssFile(Yii::$app->request->baseUrl . '/plugins/admin/js/jquery-ui/css/jquery-ui.css');
$this->registerJs($this->render('js/_script.js'));
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\AppAsset;
AppAsset::register($this);
?>
<div style="padding:20px;">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <?= Html::activeHiddenInput($model, 'parent', ['id' => 'parent_id']); ?>
    <?= $form->field($model, 'name',['labelOptions' => ['label' => '名称']])->textinput(['placeholder' => '请填写名称','class'=>'layui-input']) ?>
    <?= $form->field($model, 'parent_name',['labelOptions' => ['label' => '父菜单']])->textinput(['placeholder' => '请填写父菜单','id'=>'parentMenu','class'=>'layui-input']) ?>
    <?= $form->field($model, 'route',['labelOptions' => ['label' => '路由']])->textinput(['placeholder' => '请填写路由','id'=>'routes','class'=>'layui-input']) ?>
    <?= $form->field($model, 'order',['labelOptions' => ['label' => '排序']])->textinput(['placeholder' => '请填写排序','id'=>'order','class'=>'layui-input']) ?>
    <div class="layui-input-inline" style='width:240px'>
        <label class="control-label" for="menu-order">图标</label>
        <input placeholder="请输入或选择图标" id="icon" type="text" name="Menu[icon]" value='<?=$model->icon?>' class="layui-input">
    </div>

    <?php echo Html::button('打开图标',['class'=>'layui-btn open-icon','style'=>'margin-top: 25px;']);?>
    <div align='right' style="margin-top:15px;">
        <?=
        Html::submitButton($model->isNewRecord ? Yii::t('backend-rbac', 'Create') : Yii::t('backend-rbac', 'Update')
            , ['class' => $model->isNewRecord? 'layui-btn' : 'layui-btn layui-btn-normal'])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
