<?php

namespace backend\modules\rbac\controllers;

use backend\modules\rbac\models\dao\Rbac;
use rbac\models\dao\User;
use rbac\models\form\LoginForm;
use rbac\models\form\Signup;
use yii\web\Controller;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use \GatewayWorker\Lib\Gateway;

/**
 * User controller
 *
 * @author earnest <464605059@qq.com>
 * */
class UserController extends Controller
{
    /**
     * 浏览器跳转'user/login'页面
     * 登录成功后调整主页
     * @return fixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 注销登录
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }

    /**
     * 浏览器跳转'user-list'视图
     * @return fixed
     * */
    public function actionUserList(){
        if(Yii::$app->request->isPost) {
            $p = Yii::$app->request->post();
            if(isset($p['param']['nodeId']) && $p['param']['nodeId'] != '' ){
                $p['dept_id'] = $p['param']['nodeId'];
            }

            $model = new User();
            $data = $model->search(['id','username','nickname','created_at','updated_at','status','dept_id'],$p);

            try{
                require_once Yii::getAlias('@vendor').'/GatewayWorker/vendor/autoload.php';
                $gateway = new Gateway('websocket://127.0.0.1:8282');

                foreach ($data['data'] as $key => $v){
                    $data['data'][$key]['is_online'] = $gateway->isUidOnline($v['id']);
                }
            }catch (ErrorException $e){
            }

            return json_encode(['code' => 0, 'count' => $data['count'], 'msg' => '', 'data' => $data['data']]);
        }

        return $this->render('user-list');
    }

    /**
     * 浏览器跳转'user/user-list'视图
     * @return String
     * */
    public function actionPerson(){
        return $this->render('person');
    }

    /**
     * 用户新增
     * @return String
     * @throws Exception
     */
    public function actionInsert(){
        $model = new Signup();
        if($model->load(Yii::$app->getRequest()->post(),'') && $model->validate()){
            if($model->signup()){
                return json_encode(['code'=>200,'icon'=>1,'msg'=>'新增成功']);
            }
        }else{
            $errMsg = $model->firstErrors;
            return json_encode(['code'=>500,'icon'=>2,'msg'=>reset($errMsg)]);
        }
    }

    /**
     * 用户资料更新
     * @return String
     * */
    public function actionUpdate(){
        try{
            if(Yii::$app->request->isPost) {
                $p = Yii::$app->request->post();
                $model = new User();
                $r = $model->userUpdate($p['data']);
                if($r === true){
                    return json_encode(['code'=>200,'icon'=>1,'msg'=>'SUCCESS']);
                }else{
                    return json_encode(['code'=>400,'icon'=>2,'msg'=>json_encode($r)]);
                }
            }
        }catch (ErrorException $e){
            return json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
    }

    /**
     * 浏览器跳转'user/user-update'视图
     * @return Json
     * */
    public function actionUserUpdate(){
        if(Yii::$app->request->isGet) {
            $p = Yii::$app->request->get();
            $r = Rbac::getChildrenByUser($p['id']);
            return $this->render('user-update',['opts'=>json_encode($r),'parent'=>$p['id']]);
        }
    }

    /**
     * 更新用户角色权限
     * @return String
     * @throws \yii\db\Exception
     */
    public function actionUpdateUserChild(){
        if(Yii::$app->request->isPost) {
            $p = Yii::$app->request->post();
            if($p['index'] == 0){   // 新增
               $r = Rbac::grantUserChild($p['children'],$p['parent']);
            }else if($p['index'] == 1){ // 删除
                $r = Rbac::revokeUserChild($p['children'],$p['parent']);
            }

            if($r === true){
                $_r = Rbac::getChildrenByUser($p['parent']);
                return json_encode(['code'=>200,'msg'=>'','data'=>$_r['items']]);
            }else{
                return json_encode(['code'=>400,'msg'=>$r]);
            }
        }
    }

    /**
     * 删除指定用户集合
     * @return Json
     * */
    public function actionDeleteAll(){
        if(Yii::$app->request->isPost) {
            $p = Yii::$app->request->post();
            if(isset($p['id'])){
                $ids = array($p['id']);
            }else if(isset($p['data'][0]['id'])){
                $ids = array_column($p['data'],'id');
            }

            $user = new User();
            $res = $user::deleteAll(['id'=>$ids]);
            if($res){
                foreach ($ids as $id){
                    Rbac::revokeUserChildAll($id);
                }
                return json_encode(['code'=>200,'icon'=>1,'msg'=>'删除成功']);
            }else{
                $errors = $user->firstErrors;
                return json_encode(['code'=>400,'icon'=>2,"msg"=>reset($errors)]);
            }
        }
    }
}