<?php

namespace rbac\models\dao;

use rbac\models\Dept as DeptModel;
use Yii;

class Dept extends DeptModel
{
    function searchs($p = []){
        $r = [];
        $query = DeptModel::find()->select(['id','name','parent']);

        if(isset($p['name']) && $p['name'] != ''){
            $query->andWhere(['like','name',$p['name']]);
        }

        if(!empty($p['page'])&&!empty($p['limit'])){
            $query->offset(($p['page']-1)*$p['limit'])
                ->limit($p['limit']);
        }

        $depts = $query
            ->orderBy(['order'=>SORT_ASC])
            ->asArray()
            ->all();

        foreach ($depts as $curr){
            if($curr['parent'] == 0){
                $r[] = $this->child($curr,$depts);
            }
        }

        return $r;
    }

    function child($curr,$depts){
        foreach ($depts as $key => $dept){
            if($curr['id'] == $dept['parent']){
                $curr['child'][] = $this->child($dept,$depts);
            }
        }
        return $curr;
    }

    function tableSearchs($p = []){
        $query = DeptModel::find()
            ->from(DeptModel::tableName().' d')
            ->select(['d.id','d.name','d.parent','d.order'])
            ->joinWith(['parent0'=>function($q){
                $q->from(DeptModel::tableName().' _d');
            }]);


        if(isset($p['name']) && $p['name'] != ''){
            $query->andWhere(['like','d.name',$p['name']]);
        }

        if(!empty($p['page'])&&!empty($p['limit'])){
            $query->offset(($p['page']-1)*$p['limit'])
                ->limit($p['limit']);
        }

        $depts = $query
            ->orderBy(['d.order'=>SORT_ASC])
            ->asArray()
            ->all();
        return $depts;
    }
}
