<?php

namespace rbac\models\dao;
use rbac\models\Menu as MenuModel;
use yii\db\Expression;
use yii\db\Query;
use Yii;
class Menu extends MenuModel
{
    /**
     * 获取所有的父菜单以及子菜单
     * @param $params
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    function searchByParent($params = 0){
        $query = MenuModel::find()
            ->from(MenuModel::tableName().' m')
            ->joinWith(['menus'=>function($q){}]);

        $r = $query
            ->andWhere(['m.parent'=>null])
            ->asArray()
            ->all();
        return $r;
    }

    /**
     * 获取所有的菜单以及父菜单
     * */
    public function searchByChild($p = []){
        $query = MenuModel::find()
            ->from(MenuModel::tableName().' m')
            ->joinWith(['parent0'=>function($q){
               $q->from(MenuModel::tableName().' _m');
            }]);
        if(isset($p['name']) && $p['name'] != ''){
            $query->andWhere(['like','m.name',$p['name']]);
        }

        if(isset($p['route']) && $p['route'] != ''){
            $query->andWhere(['like','m.route',$p['route']]);
        }

        $count = $query->count();

        if(!empty($p['page'])&&!empty($p['limit'])){
            $query->offset(($p['page']-1)*$p['limit'])
                ->limit($p['limit']);
        }

        $data = $query
            ->orderBy(['order'=>SORT_ASC])
            ->asArray()
            ->all();

        return ['data'=>$data,'count'=>$count];
    }
}