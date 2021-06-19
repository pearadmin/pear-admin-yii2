<?php

namespace backend\modules\rbac\controllers;

use backend\modules\rbac\models\dao\Rbac;
use yii\web\Controller;
use Yii;
use yii\helpers\Json;

/**
 * Rbac controller
 *
 * @author earnest <464605059@qq.com>
 * */
class RbacController extends Controller
{
    /**
     * 浏览器跳转'rbac/role-list'页面
     * @return mixed
     * */
    public function actionRoleList()
    {
        return $this->render('role-list');
    }

    /**
     * 角色的新增和删除
     * @return Json
     * */
    public function actionUpdateRole(){
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            if(isset($params['name']) && $params['name']!=''){
                return Rbac::updateRole($params);
            }
        }
    }

    /**
     * 获取所有角色列表
     * @return String
     * */
    public function actionGetRoleList()
    {
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            return Rbac::getItemList($params,1);
        }

    }

/*-----------------------------------------------------权限分配--------------------------------------------------------*/

    /**
     * 浏览器跳转'rbac/perms-list'页面
     * @return mixed
     * */
    public function actionPermsList()
    {
        return $this->render('perms-list');
    }

    /**
     * 获取权限列表
     * @return String
     * */
    public function actionGetPermsList(){
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            return Rbac::getItemList($params);
        }
    }

    /**
     * 获取当前权限下的子权限、子路由、可分配的权限、可分配的路由
     * @param string $item 权限名称
     * @return String
     */
    public function getItemChildren($item = ''){
        $res =  Rbac::getItemChildren($item);
        $res = json_decode($res,true);
        if(isset($res['code']) && $res['code'] == 0){
            foreach ($res['r_assigned'] as $v){
                $r['items']['assigned'][$v] = 'route';
            }
            foreach ($res['p_assigned'] as $v){
                $r['items']['assigned'][$v] = 'permission';
            }
            foreach ($res['role_assigned'] as $v){
                $r['items']['assigned'][$v] = 'role';
            }

            foreach ($res['r_available'] as $v){
                $r['items']['available'][$v] = 'route';
            }
            foreach ($res['p_available'] as $v){
                $r['items']['available'][$v] = 'permission';
            }
            foreach ($res['role_available'] as $v){
                $r['items']['available'][$v] = 'role';
            }
        }

        return $r;
    }

    /**
     * 浏览器跳转'rbac/perms-update'页面
     * @return mixed
     * */
    public function actionItemUpdate(){
        $r = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->get();
            $r = $this->getItemChildren($params['item']);
        }
        return $this->render('item-update',['opts'=>json_encode($r),'parent'=>$params['item']]);
    }

    /**
     * 权限的添加和删除
     * @throws \yii\db\Exception
     * @return string
     */
    public function actionUpdatePermissions(){
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            foreach ($params['perms'] as $v) {
                if(substr($v['value'],'0',1) == '/'){
                    return json_encode(['code'=>400,'msg'=>'字母数字开头']);
                }
            }
            return Rbac::updateItems($params['perms'],$params['oType']);
        }
    }

    /**
     * 更新权限、角色、规则
     * @return string
     * */
    public function actionUpdateItem(){
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            return Rbac::updateitem($params);
        }
    }

    /**
     * 权限和角色的子节点的添加和删除
     * @throws \yii\db\Exception
     * @return Json
     */
    public function actionUpdateChild(){
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            $_res = Rbac::updateChild($params['children'],$params['parent'],$params['index']);
            $res = json_decode($_res,true);
            if($res['code'] == 200){
                $r = $this->getItemChildren($params['parent']);
                return json_encode(['code'=>200,'data'=>$r['items']]);
            }else{
                return $_res;
            }
        }
    }

    /**
     * 新增权限
     * @return false|string
     * @throws \yii\db\Exception
     */
    public function actionAddPerms(){
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            if(substr($params['name'],0,1) == '/'){
                return json_encode(['code'=>400,'msg'=>'禁止添加路由']);
            }
            $p[0]['description'] = $params['description'];
            $p[0]['value'] = $params['name'];
            return Rbac::updateItems($p,0);
        }
    }

/*-----------------------------------------------------路由分配--------------------------------------------------------*/

    /**
     * 浏览器跳转'rbac/routes'页面
     * @return fixed
     * */
    public function actionRoutes()
    {
        $r = self::getRoutes();
        return $this->render('routes',['opts'=>$r,'parent'=>0]);
    }

    /**
     * 获取所有路由列表
     * @return Json
     * */
    private function getRoutes(){
        $func = function ($_perms_assigned,$_perms){
            $r['items'] = [];
            foreach ($_perms_assigned as $v){
                if(substr($v->name,0,1) == '/'){
                    $r['items']['assigned'][$v->name] = 'route';
                }
            }
            $assigned_keys = array_keys($r['items']['assigned']);
            foreach ($_perms as $v){
                if(!in_array($v,$assigned_keys)){
                    $r['items']['available'][$v] = 'route';
                }
            }
            return json_encode($r);
        };
        $r = Rbac::getroutes($func);

        return $r;
    }

    /**
     * 更新路由列表
     * @throws \yii\db\Exception
     * * @return Json
     */
    public function actionUpdateroutes(){
        try{
            if(Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
                if(isset($params['index']) && $params['index'] != ''){
                    foreach ($params['children'] as $v){
                        $_p[]['value'] = $v;
                    }
                    Rbac::updateItems($_p,$params['index']);
                    return $this->redirect(['/rbac/rbac/routes']);
                }else{
                    return json_encode(['code'=>400,'msg'=>'请求参数异常','data'=>[]]);
                }
            }
        }catch (ErrorException $e){
            return json_encode(['code'=>400,'msg'=>$e->getMessage(),'data'=>[]]);
        }
    }

    /**
     * 自动导入路由，一般用作手动执行
     * @return String
     * @throws \yii\db\Exception
     */
    public function actionInit(){
        $trans = Yii::$app->db->beginTransaction();
        try {
            $dir = dirname(dirname(__FILE__)).'/../';
            $modules = glob($dir. '/*');
            $permissions = [];
            foreach ($modules as $module) {
                $controllers = glob($module. '/controllers/*');
                foreach ($controllers as $controller) {
                    $content = file_get_contents($controller);
                    preg_match('/class ([a-zA-Z0-9]+)Controller/', $content, $match);
                    $cName = $match[1];
                    $permissions[] = strtolower('/'.$cName. '/*');
                    preg_match_all('/public function action([a-zA-Z0-9_]+)/', $content, $matches);
                    foreach ($matches[1] as $aName) {
                        $permissions[] = strtolower('/'.$cName. '/'. namecut($aName));
                    }
                }
            }
            $auth = Yii::$app->authManager;
            foreach ($permissions as $permission) {
                if (!$auth->getPermission($permission)) {
                    $obj = $auth->createPermission($permission);
                    $obj->description = $permission;
                    $auth->add($obj);
                }
            }
            $trans->commit();

            return json_encode(['code'=>200,'msg'=>'sccess']);
        } catch(\Exception $e) {
            $trans->rollback();
            return json_encode(['code'=>400,'msg'=>'文件或控制器名称不规范，导入失败']);
        }
    }

}