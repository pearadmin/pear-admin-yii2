<?php

namespace backend\modules\rbac\models\dao;
use rbac\models\AuthAssignment;
use yii\db\ActiveRecord;
use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * Rbac 控制器
 * @createdBy imbee
 * */
class Rbac extends ActiveRecord 
{
   /* public static function getOptions($data, $parent)
    {
        $return = [];
        foreach ($data as $obj) {
            if (!empty($parent) && $parent->name != $obj->name && Yii::$app->authManager->canAddChild($parent, $obj)) {
                //$return[$obj->name] = $obj->description;
                $return[] = $obj->name;
            }
            if (is_null($parent)) {
                //$return[$obj->name] = $obj->description;
                $return[] = $obj->name;
            }
        }
        return $return;
    }*/

    /**
     * 获取权限或角色列表
     * @param array $params
     * @param int $type
     * @return string
     */
    public static function getItemList($params = null,$type= 2){
        $auth = Yii::$app->authManager;
        $query = (new Query());
        $query->select(new Expression('name name,name _name,description,FROM_UNIXTIME(created_at,"%Y-%m-%d %H:%i:%S") created_at,FROM_UNIXTIME(updated_at,"%Y-%m-%d %H:%i:%S") updated_at'));
        $query->from($auth->itemTable);
        $query->where("1=1");
        if($type == 1){
            $query->andWhere(['type'=> $type]);
        }else if($type = 2){
            $query->where(['not like','name','/%',false]);
            $query->andWhere(['type'=>2]);
        }

        if(!empty($params['page'])&&!empty($params['limit'])){
            $query->offset(($params['page']-1)*$params['limit'])
                ->limit($params['limit']);
        }

        if(!empty($params['perm_name'])){
            $query->andWhere(['like','name',$params['perm_name']]);
        }
        $count = $query->count();
        $data =  $query->orderBy(['description'=>SORT_ASC])->all();
        return json_encode(['code'=>0,'msg'=>'','count'=>$count,"data"=>$data]);
    }

    /**
     * 获取当前权限下的子权限、子路由、可分配的权限、可分配的路由
     * @param string $item 权限名称
     * @return String
     */
    public static function getItemChildren($item = null){
        try{
            $_assigned = self::getChildrenByName($item);
            $role_assigned = array_column(isset($_assigned['roles'])?$_assigned['roles']:[],'value');
            $r_assigned = array_column(isset($_assigned['routes'])?$_assigned['routes']:[],'value');
            $p_assigned = array_column(isset($_assigned['permissions'])?$_assigned['permissions']:[],'value');
            $assigned = array_merge($p_assigned,$r_assigned,$role_assigned);

            $role_available = $r_available = $p_available = [];
            $auth = Yii::$app->authManager;
            $itemList = [];

            if($auth->getRole($item)){
                $roles = [];
                foreach ($auth->getRoles() as $role){
                    if($auth->canAddChild($auth->getRole($item),$role)){
                        array_push($roles,$role);
                    }
                }
                $itemList = array_merge($itemList,$roles);
            }

            $o = $auth->getPermission($item)?$auth->getPermission($item):$auth->getRole($item);
            $permsList = [];
            foreach ($auth->getPermissions() as $perms){
                if($auth->canAddChild($o,$perms)){
                    array_push($permsList,$perms);
                }
            }
            $itemList = array_merge($itemList,$permsList);

            foreach ($itemList as $obj){
                if(!in_array($obj->name,$assigned) && $item != $obj->name){
                    if($obj->type == 1){
                        $role_available[] = $obj->name;
                    }else if(substr($obj->name,0,1) == '/'){
                        $r_available[] = $obj->name;
                    }else{
                        $p_available[] = $obj->name;
                    }
                }
            }
            return json_encode(['code'=>0,'msg'=>'','r_assigned'=>$r_assigned,'p_assigned'=>$p_assigned,'r_available'=>$r_available,'p_available'=>$p_available
            ,'role_assigned'=>$role_assigned,'role_available'=>$role_available]);
        }catch (\ErrorException $e){
            return json_encode(['code'=>400,'msg'=>$e->getMessage(),'data'=>[]]);
        }
    }

    /**
     * 获取当前权限下的子权限、子路由、可分配的权限、可分配的路由
     * @param string $perms 权限名称
     * @return String
     */
    public static function getPermsChildren_bak($perms = null){
        try{
            $_assigned = self::getChildrenByName($perms);
            $r_assigned = array_column(isset($_assigned['routes'])?$_assigned['routes']:[],'value');
            $p_assigned = array_column(isset($_assigned['permissions'])?$_assigned['permissions']:[],'value');
            $assigned = array_merge($p_assigned,$r_assigned);

            $r_available = $p_available = [];
            $auth = Yii::$app->authManager;
            $perms_list = $auth->getPermissions();
            foreach ($perms_list as $obj){
                if(!in_array($obj->name,$assigned) && $perms != $obj->name){
                    if(substr($obj->name,0,1) == '/'){
                        $r_available[] = $obj->name;
                    }else{
                        $p_available[] = $obj->name;
                    }
                }
            }
            return json_encode(['code'=>200,'msg'=>'','r_assigned'=>$r_assigned,'p_assigned'=>$p_assigned,'r_available'=>$r_available,'p_available'=>$p_available]);
        }catch (\ErrorException $e){
            return json_encode(['code'=>400,'msg'=>$e->getMessage(),'data'=>[]]);
        }
    }

    /**
     * 权限、角色添加或删除子节点
     * @param $children 子节点
     * @param $parent   父节点
     * @param $oType    操作类型
     * @return String
     * @throws \yii\db\Exception
     */
    public static function updateChild($children, $parent, $oType)
    {
        $auth = Yii::$app->authManager;
        $pObj = $auth->getRole($parent)?$auth->getRole($parent):$auth->getPermission($parent);
        if (empty($pObj)) {
            return json_encode(['code'=>400,'msg'=>'ERROR']);
        }

        $trans = Yii::$app->db->beginTransaction();
        try {
            foreach ($children as $item) {
                $obj = $auth->getRole($item) ? $auth->getRole($item) : $auth->getPermission($item);
                if($oType == 0 ){
                    if(Yii::$app->authManager->canAddChild($pObj, $obj)){
                        $auth->addChild($pObj, $obj);
                    }else{
                        $trans->rollback();
                        return json_encode(['code'=>400,'msg'=>$item.' 权限不够，无法添加']);
                    }
                }else{
                    $res = $auth->removeChild($pObj,$obj);
                    if($res !== true){
                        $trans->rollBack();
                        return json_encode(['code'=>400,'msg'=>'ERROR']);
                    }
                }
            }
            $trans->commit();
        } catch(\Exception $e) {
            $trans->rollback();
            return json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
        return json_encode(['code'=>200,'msg'=>'SUCCESS']);
    }

    /**
     * 路由和权限的新增、删除
     * @param $permissions
     * @param $oType 0:新增 1:删除
     * @return false|string
     * @throws \yii\db\Exception
     */
    public static function updateItems($permissions = [],$oType){
        $trans = Yii::$app->db->beginTransaction();
        try{
            $auth = Yii::$app->authManager;
            foreach ($permissions as $p) {
                if ($oType == 0 && !$auth->getPermission($p['value'])) {
                    $obj = $auth->createPermission($p['value']);
                    $obj->description = !empty($p['description']) ? $p['description'] : $p['value'];
                    $res = $auth->add($obj);
                    if($res !== true){
                        $trans->rollback();
                        return json_encode(['code'=>400,'msg'=>'ERROR']);
                    }
                }else if($oType == 1 && $auth->getPermission($p['value'])){
                    $obj = $auth->getPermission($p['value']);
                    $res = $auth->remove($obj);
                    if($res !== true){
                        $trans->rollback();
                        return json_encode(['code'=>400,'msg'=>'ERROR']);
                    }
                }else{
                    $trans->rollback();
                    return json_encode(['code'=>400,'msg'=>$oType == 0 ? '权限已经存在':'禁止重复删除']);
                }

            }

            $trans->commit();
            return json_encode(['code'=>200,'msg'=>'SUCCESS']);
        }catch (\Exception $e){
            $trans->rollback();
            return json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
    }

    /**
     * 更新节点属性
     * @param String $p
     * @return String
     * */
    public static function updateitem($p){
        try{
            $auth = Yii::$app->authManager;
            $r = false;
            if($auth->getRole($p['_name'])){
                $_auth = $auth->createRole($p['name']);
                $_auth->description = $p['description'];
                $_auth->updatedAt = time();
                $r = $auth->update($p['_name'],$_auth);
            }else if($auth->getPermission($p['_name'])){
                $_auth = $auth->createPermission($p['name']);
                $_auth->description = $p['description'];
                $_auth->updatedAt = time();
                $r = $auth->update($p['_name'],$_auth);
            }

            if($r){
                return json_encode(['code'=>200,'msg'=>'SUCCESS']);
            }else{
                return json_encode(['code'=>400,'msg'=>'FAILED']);
            }
        }catch (\Exception $e){
            return json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
    }

    /**
     * 获取当前节点下所有的子角色、权限、路由
     * @param string $name
     * @return array
     */
    public static function getChildrenByName($name)
    {
        if (empty($name)) {
            return [];
        }
        $return = [];
        $auth = Yii::$app->authManager;
        $children = $auth->getChildren($name);
        if (empty($children)) {
            return [];
        }
        $i = 0 ;
        foreach ($children as $k => $obj) {
            if ($obj->type == 1) {
                $return['roles'][$i]['title'] = $obj->name;
                $return['roles'][$i]['value'] = $obj->name;
            } else {
                if(substr($obj->name,0,1) == '/'){
                    $return['routes'][$i]['title'] = $obj->name;
                    $return['routes'][$i]['value'] = $obj->name;
                }else{
                    $return['permissions'][$i]['title'] = $obj->name;
                    $return['permissions'][$i]['value'] = $obj->name;
                }
            }
            $i++ ;
        }
        return $return;
    }

    /**
     * 分配用户权限和角色
     * @param String $children 子节点
     * @param int $adminid 用户id
     * @return boolean
     * @throws \yii\db\Exception
     */
    public static function grantUserChild($children, $adminid)
    {
        $trans = Yii::$app->db->beginTransaction();
        try {
            $auth = Yii::$app->authManager;
            foreach ($children as $item) {
                $obj = is_null($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->assign($obj, $adminid);
            }
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            return $e->getMessage();
        }
        return true;
    }

    /**
     * 移除用户权限和角色
     * @param String $adminid
     * @param int $children
     * @return boolean
     * @throws \yii\db\Exception
     */
    public static function revokeUserChild($children,$adminid)
    {
        $trans = Yii::$app->db->beginTransaction();
        try {
            $auth = Yii::$app->authManager;
            foreach ($children as $item) {
                $obj = is_null($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->revoke($obj, $adminid);
            }
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            return $e->getMessage();
        }
        return true;
    }

    /**
     * 删除用户所有的角色和权限
     * @param int $adminid
     * @return boolean
     * */
    public static function revokeUserChildAll($adminid)
    {
        $auth = Yii::$app->authManager;
        return $auth->revokeAll($adminid);
    }


    /**
     * 获取用户的角色和权限
     * @param int $adminid
     * @param int $type
     * @return array
     * */
    private static function _getItemByUser($adminid, $type)
    {
        $func = 'getPermissionsByUser';
        if ($type == 1) {
            $func = 'getRolesByUser';
        }
        $data = [];
        $auth = Yii::$app->authManager;
        $items = $auth->$func($adminid);
        foreach ($items as $item) {
            $data[] = $item->name;
        }
        return $data;
    }

    /**
     * 获取用户的角色和权限
     * @param int $adminid
     * @return array
     * */
    public static function getChildrenByUser($adminid)
    {
        $return = [];
        $return['role'] = self::_getItemByUser($adminid, 1);
        $return['permission'] = self::_getItemByUser($adminid, 2);
        $model = new AuthAssignment();
        $d = $model->find()->select(['item_name'])->where(['user_id'=>$adminid])->asArray()->all();
        $_d = array_column($d,'item_name');
        foreach ($return as $k => $r){
            foreach ($r as $_k => $v){
                if(!in_array($return[$k][$_k],$_d)){
                    unset($return[$k][$_k]);
                }
            }
        }

        $_return['items']['assigned'] = [];
        foreach ($return as $k =>$v){
            foreach ($v as $_v){
                $_return['items']['assigned'][$_v] = $k;
            }
        }
        $roles = Rbac::getItemList('',1);
        $roles = json_decode($roles,true);
        $roles = array_column($roles['data'],'name');
        foreach ($roles as $v){
            if(!in_array($v,$return['role'])){
                $_return['items']['available'][$v] = 'role';
            }
        }

        $perms = Rbac::getItemList('',2);
        $perms = json_decode($perms,true);
        $perms = array_column($perms['data'],'name');
        foreach ($perms as $v){
            if(!in_array($v,$return['permission'])){
                $_return['items']['available'][$v] = 'permission';
            }
        }
        return $_return;
    }


    /**
     * 角色新增和删除
     * @param array $p
     * @return string
     */
    public static function updateRole($p){
        try {
            $auth = Yii::$app->authManager;
            if($p['otype'] == 0){
                $_role = $auth->createRole($p['name']);
                $_role->description = $p['description'];
                $res = $auth->add($_role);
            }else if($p['otype'] == 1){
                $_role = $auth->getRole($p['name']);
                $res = $auth->remove($_role);
            }

            if($res == true){
                echo json_encode(['code'=>200,'msg'=>'SUCCESS']);
            }else{
                json_encode(['code'=>400,'msg'=>'ERROR']);
            }
        }catch (\Exception $e){
            echo json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
    }

    /**
     * 路由分配页面
     * @return String
     * */
    public static function getroutes($func){
        $dir = dirname(dirname(__FILE__)).'/../../../';
        $modules = glob($dir. '/*');
        foreach ($modules as $module) {
            $fileArr = explode('//',$module);
            $controllers = [];
            if($fileArr[1] == 'controllers'){
                $controllers = glob($module. '/*');
            }else if($fileArr[1] == 'modules'){
                $_modules = glob($module.'/*');
                foreach ($_modules as $_module){
                    $_controllers = glob($_module. '/controllers/*');
                    foreach ($_controllers as $c) {
                        $controllers[] = $c;
                    }
                }
            }else{
                continue;
            }

            foreach ($controllers as $controller) {
                preg_match('/\/\/modules\/([a-zA-Z0-9]+)\//',$controller,$m);
                $_m = isset($m[1])?'/'.$m[1]:'';
                $content = file_get_contents($controller);
                preg_match('/class ([a-zA-Z0-9]+)Controller/', $content, $match);
                if(isset($match[1])){
                    $cName = $match[1];
                    $_perms[] = strtolower('/'.$cName. '/*');
                    preg_match_all('/public function action([a-zA-Z0-9_]+)/', $content, $matches);
                    foreach ($matches[1] as $aName) {
                        $_perms[] = strtolower($_m.'/'.$cName. '/'. namecut($aName));
                    }
                }
            }
        }
        $auth = Yii::$app->authManager;
        $_perms_assigned = $auth->getPermissions();
        return $func($_perms_assigned,$_perms);
    }
}
