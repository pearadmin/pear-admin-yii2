<?php

namespace rbac\models\dao;
use backend\modules\rbac\models\dao\Rbac;
use rbac\models\User as UserModel;
use rbac\models\Dept;
use yii\base\ErrorException;
use yii\db\Exception;
use yii\db\Expression;
use yii\db\Query;
use Yii;
class User extends UserModel
{
    /**
     * 用户表查询
     * @param $p String
     * @return String
     * */
    public function search($columns = [],$p = []){
        $columns = 'u.'.implode($columns,',u.');
        $columns = str_replace('u.created_at','from_unixtime(u.`created_at`,"%Y-%m-%d %H:%i:%S") created_at',$columns);
        $columns = str_replace('u.updated_at','from_unixtime(u.`updated_at`,"%Y-%m-%d %H:%i:%S") updated_at',$columns);
        $columns .= ',d.name dept_name';

        $q = (new Query());
        $q->select(new Expression($columns));
        $q->from(UserModel::tableName().' u');
        $q->leftJoin(Dept::tableName().' d','u.dept_id = d.id');
        if(!empty($p['username'])){
            $q->andWhere(['like','username',$p['username']]);
        }

        if(!empty($p['id'])){
            $q->andWhere(['id'=>$p['id']]);
        }

        if(!empty($p['dept_id'])){
            $q->andWhere(['dept_id'=>$p['dept_id']]);
        }

        if (!empty($p['page']) && !empty($p['limit'])) {
            $q->offset(($p['page'] - 1) * $p['limit'])
              ->limit($p['limit']);
        }

        $r['count'] = $q->count();
        $r['data'] = $q->orderBy(['id'=>SORT_DESC])->all();
        return $r;
    }

    /**
     * 用户表更新
     * @p array
     * @return String|boolean
     * */
    public function userUpdate($p = []){
        $model = UserModel::findOne($p['id']);
        if(!empty($model)){
            $model->username = $p['username'];
            $model->nickname = $p['nickname'];
            $model->dept_id = $p['dept_id'];
            $model->status = (isset($p['status']) && $p['status'] == 'on') ? 10 : 9;
            $model->updated_at = time();
            $r = $model->save();
            if($r === true){
                return $r;
            }else{
                return $model->getErrors();
            }
        }else {
            return '不存在';
        }

    }
}