<?php
use backend\assets\AppAsset;
use backend\assets\PearAsset;

$action_list = [
    'user/login',
    'user/request-password-reset',
    'user/reset-password'
];
if (in_array(Yii::$app->controller->id . '/' . Yii::$app->controller->action->id, $action_list)) {
    //AppAsset::register($this);
    PearAsset::register($this);

    echo $this->render(
        'main-login',
        ['content' => $content]
    );
}else{
    $bootstrp_list = [
        'site/index',
        'site/content',
    ];
    if(in_array(Yii::$app->controller->id . '/' . Yii::$app->controller->action->id, $bootstrp_list)){
        PearAsset::register($this);
    }

    echo $this->render(
        'main-index',
        ['content' => $content]
    );
}
?>
