<?php
use yii\widgets\DetailView;
use backend\assets\AppAsset;
AppAsset::register($this);
?>
<div class="menu-view">
    <?=DetailView::widget([
        'model' => $model,
		'options' => ['class' => 'layui-table'],
        'attributes' => [
            'parent0.name:text:父菜单名称',
            'name',
            'route',
            'order',
            'icon',
        ],
		'template' => '<tr><th width="140px">{label}</th><td>{value}</td></tr>',
    ])
    ?>
</div>
