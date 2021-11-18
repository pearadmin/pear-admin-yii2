<?php

namespace backend\modules\rbac\controllers;

use yii\web\Controller;
use rbac\components\MenuHelper;
use rbac\models\dao\Menu as MenuDao;
use rbac\models\Menu;
use rbac\models\System;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Menu controller
 *
 * @author earnest <464605059@qq.com>
 * */
class MenuController extends Controller
{
    /**
     * 浏览器跳转'menu/index'页面
     * @return mixed
     */
    public function actionIndex(){
        return $this->render('index');
    }

    /**
     * 显示指定的Menu模型
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 根据主键查询指定Menu模型
     * 如果模型没有, 404 HTTP 异常将会抛出
     * @param  integer $id
     * @return Menu Menu模型
     * @throws NotFoundHttpException 如果模型没有找到
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在！');
        }
    }

    /**
     * 创建一个新的Menu模型
     * 如果创建成功, 浏览器将会跳转到 'view' 页面.
     * @return mixed
     */
    public function actionCreate(){
        $model = new Menu();

        if ($model->load(Yii::$app->getRequest()->post()) && $r = $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $modelDao = new MenuDao();
            $childs = $modelDao->searchByChild();
            $routes = $model->getSavedRoutes();

            return $this->render('form', ['model' => $model,'data'=>json_encode($childs),'routes'=>json_encode($routes)]);
        }
    }

    /**
     * 根据主键更新指定的的Menu模型
     * 如果更新成功，浏览器将跳转到'view'页面
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);
        if(isset($model->parent0->name)){
            $model->parent_name = $model->parent0->name;
        }

        $fieldData = Yii::$app->getRequest()->post();
        if(isset($fieldData['Menu']['parent_name']) && trim($fieldData['Menu']['parent_name']) == ''){
            $fieldData['Menu']['parent'] = '';
        }

        if ($model->load($fieldData) &&  $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $modelDao = new MenuDao();
            $childs = $modelDao->searchByChild();
            $routes = $model->getSavedRoutes();

            return $this->render('form', ['model' => $model,'data'=>json_encode($childs),'routes'=>json_encode($routes)]);
        }
    }

    /**
     * 根据主键删除指定的Menu模型
     * 如果删除成功，浏览器将跳转至index页面
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isPost) {
            $p = Yii::$app->request->post();
            $model = $this->findModel($p['id']);
            if($model->delete()){
                return json_encode(['code'=>200,"msg"=>"删除成功"]);
            }else{
                $errors = $model->firstErrors;
                return json_encode(['code'=>400,"msg"=>reset($errors)]);
            }
        }else{
            return json_encode(['code'=>400,"msg"=>"请选择数据"]);
        }
    }

    /**
     * 获取Menu模型集合
     * @return mixed
     * */
    public function actionGetMenuList(){
        $modelDao = new MenuDao();
        $p = Yii::$app->request->post();

        $menus = $modelDao->searchByChild($p);
        foreach ($menus['data'] as $key => $m){
            $menus['data'][$key]['powerId'] = $m['id'];
            $menus['data'][$key]['powerName'] = $m['name'];
            $menus['data'][$key]['powerUrl'] = $m['route'];
            $menus['data'][$key]['parentId'] = empty($m['parent'])?0:$m['parent'];
            $menus['data'][$key]['sort'] = $m['order'];
            $menus['data'][$key]['powerCode'] = '';
            $menus['data'][$key]['openType'] = '';
            $menus['data'][$key]['checkArr'] = '';
            if(is_array($m['parent0']) && count($m['parent0']) > 0){
                $menus['data'][$key]['powerType'] = 1;

            }else{
                $menus['data'][$key]['powerType'] = 0;
            }
        }
        $menus['code'] = 0;
        return json_encode($menus,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取Menu子模型集合
     * @param array $p
     * @return array
     * */
    private function getMenuChild($p){
        $r = [];
        foreach ($p as $key => $v){
            $r[$key] = $v;
            $r[$key]['title'] = $v['name'];
            $r[$key]['type'] = '1';
            $r[$key]['href'] = $v['route'];

            if(is_array($v['children']) && count($v['children']) != 0){
                $r[$key]['type'] = '0';
                $r[$key]['children'] = self::getMenuChild($v['children']);
            }
        }
        return $r;
    }

    /**
     * 获取系统所有菜单
     * @return Json
     * */
    public function actionGetMenus(){
        $data = System::find()->where(['id'=>1])->asArray()->one();

        $r['code'] = 0;
        $r['msg'] = '';
        $r['logo']['image'] = $data['file_name'];
        $r['logo']['title'] = $data['logo_title'];
        $r['menu']['control'] = $data['menu_control'] == 1?true:false;       // 是否开启多系统菜单模式
        $r['menu']['accordion'] = $data['menu_accordion'] == 1?true:false;     // 是否同时只打开一个菜单目录
        $r['menu']['select'] = 36;
        $r['menu']['async'] = true;

        $r['tab']['muiltTab'] = $data['muilt_tab'] == 1?true:false;
        $r['tab']['keepState'] = true;
        $r['tab']['session'] = $data['session'] == 1?true:false;
        $r['tab']['tabMax'] = $data['tab_max'];
        $r['tab']['index']['id'] = '10';
        $r['tab']['index']['href'] = $data['index_href'];
        $r['tab']['index']['title'] = $data['index_title'];

        $r['theme']['defaultColor'] = '2';
        $r['theme']['defaultMenu'] = 'dark-theme';
        $r['theme']['allowCustom'] = true;

        $r['colors'][0]['id'] = '1';
        $r['colors'][0]['color'] = '#FF5722';

        $r['colors'][1]['id'] = '2';
        $r['colors'][1]['color'] = '#5FB878';

        $r['colors'][2]['id'] = '3';
        $r['colors'][2]['color'] = '#1E9FFF';

        $r['colors'][3]['id'] = '4';
        $r['colors'][3]['color'] = '#FFB800';

        $r['colors'][4]['id'] = '5';
        $r['colors'][4]['color'] = 'darkgray';


        $links_title = json_decode($data['links_title'],true);
        $links_href = json_decode($data['links_href'],true);
        $links_icon = json_decode($data['links_icon'],true);
        foreach (is_array($links_title)?$links_title:[] as $key => $v){
            $r['links'][$key]['icon'] = $links_icon[$key];
            $r['links'][$key]['title'] = $links_title[$key];
            $r['links'][$key]['href'] = $links_href[$key];
        }
        $r['other']['keepLoad'] = $data['keep_load'];

        $func = function($p){
            $p['title'] = $p['name'];
            $p['href'] = $p['route'];
            if(is_array($p['children']) && count($p['children']) > 0){
                $p['type'] = 0;
                $p['children'] = self::getMenuChild($p['children']);
            }
            return $p;
        };

        $m = MenuHelper::getAssignedMenu(Yii::$app->user->id,null,$func);
        $r['menu']['data'] = $m;
        return json_encode($r);
    }

}


