<?php

namespace backend\modules\rbac\controllers;

use yii\web\Controller;
use rbac\models\dao\Dept as DeptDao;
use rbac\models\Dept;
use Yii;

/**
 * Dept controller
 *
 * @author earnest <464605059@qq.com>
 * */
class DeptController extends Controller
{
    /**
     * 浏览器跳转'dept/index'页面
     * @return mixed
     * */
    public function actionIndex(){
        return $this->render('index');
    }

    /**
     * 列出所有部门以及对应子部门
     * @return String
     * */
    public function actionGetDepts(){
        $deptDao = new DeptDao();
        $res = $this->buildData($deptDao->searchs());
        return json_encode(['status'=>['code'=>200,'message'=>'操作成功'],'data'=>$res]);
    }

    /**
     * 创建一个新的Dept模型
     * 如果创建成功, 浏览器将会跳转到 'form' 页面.
     * @return mixed
     */
    public function actionCreate(){
        $model = new Dept();
        $post_data = Yii::$app->getRequest()->post();
        if (isset($post_data) && count($post_data) > 0) {
            if($model->load($post_data) && $r = $model->validate()){
                if($model->save()){
                    return json_encode(['code'=>200,"msg"=>"创建成功"]);
                }
            }else{
                $errors = $model->firstErrors;
                return json_encode(['code'=>400,"msg"=>reset($errors)]);
            }
        } else {
            return $this->render('form', ['model' => $model]);
        }
    }

    /**
     * 根据主键更新Dept模型
     * 如果主键不存在，浏览器跳转'form'页面
     * @param integer $id
     * @return mixed
     * */
    public function actionUpdate($id = ''){
        $post_data = Yii::$app->getRequest()->post();
        $id = $id == '' ? $post_data['Dept']['id'] : $id;
        $model = $this->findModel($id);

        if (isset($post_data) && count($post_data) > 0) {
            if ($model->load($post_data) && $model->validate()) {
                if($model->save()){
                    return json_encode(['code'=>200,"msg"=>"修改成功"]);
                }
            }else{
                $errors = $model->firstErrors;
                return json_encode(['code'=>400,"msg"=>reset($errors)]);
            }
        } else {
            return $this->render('form',['model'=>$model]);
        }
    }

    /**
     * 根据主键删除Dept模型
     * @return mixed
     * */
    public function actionDelete(){
        if(Yii::$app->request->isPost){
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
     * 根据主键集合批量删除Dept模型
     * @return mixed
     * */
    public function actionDeleteAll(){
        $ids = Yii::$app->getRequest()->post('ids','');
        if($ids !== ''){
            $model = new Dept();
            $ids = explode(',',$ids);
            $count = $model->deleteAll(["in","id",$ids]);
            if($count>0){
                return json_encode(['code'=>200,"msg"=>"删除成功"]);
            }else{
                $errors = $model->firstErrors;
                return json_encode(['code'=>400,"msg"=>reset($errors)]);
            }
        }else{
            return json_encode(['code'=>400,"msg"=>"请求数据不存在"]);
        }
    }

    /**
     * 根据主键查找Dept模型
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * */
    protected function findModel($id)
    {
        if (($model = Dept::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在！');
        }
    }

    /**
     * 获取下拉框Dept数据结合
     * @return String
     * */
    public function actionGetSltDepts(){
        $deptDao = new DeptDao();
        $res = $this->buildSltData($deptDao->searchs());
        array_push($res,['id'=>0,'name'=>'无父部门']);
        return json_encode($res);
    }

    /**
     * 获取表单Dept数据结合
     * @return String
     * */
    public function actionGetTableDepts(){
        $params = Yii::$app->getRequest()->post();

        $deptDao = new DeptDao();
        $res = $deptDao->tableSearchs($params);
        $parents = array_column($res,'parent');
        foreach ($res as $key => $v){
            $res[$key]['parentId'] = $v['parent'];
            if(in_array($v['id'],$parents)){
                $res[$key]['powerType'] = 0;
            }else{
                $res[$key]['powerType'] = 1;
            }
        }

        echo json_encode(['data'=>$res,'count'=>"6",'code'=>0,'msg'=>'']);
    }

    /**
     * 组装Dept数据集合
     * @return array
     * */
    protected function buildData($r){
        foreach ($r as $key => $v){
            $r[$key]['title'] = $r[$key]['name'];
            unset($r[$key]['name']);

            $r[$key]['parentId'] = $r[$key]['parent'];
            unset($r[$key]['parent']);

            if(isset($r[$key]['child']) && count($r[$key]['child']) > 0){
                $r[$key]['children'] = $this->buildData($r[$key]['child']);
                unset($r[$key]['child']);
                $r[$key]['last'] = false;
            }else{
                $r[$key]['last'] = true;
            }
        }

        return $r;
    }

    /**
     * 组装下拉框Dept数据集合
     * @return array
     * */
    protected function buildSltData($r,$id = 0){
        foreach ($r as $key => $v){
            $r[$key]['open'] = true;
            if($r[$key]['id'] == $id){
                $r[$key]['checked'] = true;
            }else{
                $r[$key]['checked'] = false;
            }

            unset($r[$key]['parent']);

            if(isset($r[$key]['child']) && count($r[$key]['child']) > 0){
                $r[$key]['children'] = $this->buildSltData($r[$key]['child'],$id);
                unset($r[$key]['child']);
            }
        }

        return $r;
    }

    /**
     * 组装表单Dept数据集合
     * @return array
     * */
    protected function buildTableData($r){
        foreach ($r as $key => $v){
            if(isset($r[$key]['child']) && count($r[$key]['child']) > 0){
                $r[$key]['children'] = $this->buildTableData($r[$key]['child']);
                unset($r[$key]['child']);
                $r[$key]['last'] = false;
            }else{
                $r[$key]['last'] = true;
            }
        }

        return $r;
    }
}
