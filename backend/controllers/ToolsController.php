<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;

class ToolsController extends Controller {
    public function actionIcon(){
        $param = Yii::$app->getRequest()->get();
        return $this->render('icon',['data'=>$param]);
    }
}