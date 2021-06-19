<?php
namespace common\cache;

use backend\modules\rbac\models\Rbac;
use yii;
use yii\web\Controller;

class Datacache extends Controller {
    /**
     * 缓存RBAC所有权限列表
     *
     * @author earnest
     * */
    public static function getPermissions($isJson = false, $reset = false){
        $cache = Yii::$app->cache;
        if ($reset) {
            $cache->delete('CACHE_PERMISSIONS');
        }

        $data = $cache->get('CACHE_PERMISSIONS');
        if ($data === false) {
            $auth = Yii::$app->authManager;
            $data = $auth->getPermissions();
            $cache->set('CACHE_PERMISSIONS', $data, 86400 * 30); //30天
        }
        if ($isJson) {
            return json_encode($data);
        } else {
            return $data;
        }
    }

    /**
     * 缓存RBAC所有角色列表
     *
     * @author earnest
     * */
    public static function getRoles($isJson = false, $reset = false){
        $cache = Yii::$app->cache;
        if ($reset) {
            $cache->delete('CACHE_ROLES');
        }

        $data = $cache->get('CACHE_ROLES');
        if ($data === false) {
            $auth = Yii::$app->authManager;
            $data = $auth->getRoles();
            $cache->set('CACHE_ROLES', $data, 86400 * 30); //30天
        }
        if ($isJson) {
            return json_encode($data);
        } else {
            return $data;
        }
    }
}