<?php
use backend\assets\PearAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJs($this->render('js/form.js'));

PearAsset::register($this);
?>
<style>
    .layui-form-item{
        text-align: right;margin-top:14px !important;
    }
</style>
<div style="padding:20px;">
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-form-item" style="margin-top:20px;">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-block">
                    <input type="hidden" name="id" value="<?php echo $model->id; ?>">
                    <input type="text" name="name"  lay-verify="required" placeholder="昵称" class="layui-input" value="<?php echo $model->name; ?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="number" name="order" placeholder="排序" lay-verify="required"  value="<?php echo $model->order; ?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">父部门</label>
                <div class="layui-input-block">
                    <input type="hidden" name="parent" value="<?php echo $model->parent; ?>">
                    <input type="text" id="dtreeSelect" lay-filter="dtreeSelect" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" style="">
                <button class="pear-btn pear-btn-primary" lay-submit lay-filter="<?php echo $model->isNewRecord ?"create":"update"; ?>">
                    <?php echo $model->isNewRecord ?"新增":"更新"; ?>
                </button>
            </div>
        </div>
    </form>
</div>
