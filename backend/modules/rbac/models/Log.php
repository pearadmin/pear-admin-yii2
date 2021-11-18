<?php

namespace rbac\models;


use yii;
use rbac\components\Configs;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "admin_log".
 *
 * @property integer $id admin_log id(autoincrement)
 * @property string $name admin_log controller
 * @since 1.0
 */
class Log extends ActiveRecord
{

    public $userClassName;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ? : 'common\models\User';
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route', 'url', 'user_agent', 'ip'], 'string', 'min' => 0, 'max' => 255],
            [['admin_id', 'route', 'url'], 'required'],
            [['admin_id'], 'integer', 'min' => 0, 'max' => 2147483647],
        ];
    }

    /**
     * 设置自动更新时间戳
     * @return type
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Configs::instance()->adminLogTable;
    }

    /**
     * @param $action Action
     */
    public static function addLog($action)
    {
        $model = new Log();

        $model->route = $action->uniqueId;
        $model->url = Yii::$app->request->absoluteUrl;

        $headers = Yii::$app->request->headers;

        if ($headers->has('User-Agent')) {
            $model->user_agent =  $headers->get('User-Agent');
            //$model->user_agent =  '';
        }
        $post = Yii::$app->request->post();
        if(isset($post['_csrf-backend'])){
            unset($post['_csrf-backend']);
        }
        if(is_array($post)){
            $post = array_filter($post);
        }
        $model->gets = json_encode(Yii::$app->request->get());
        $model->posts = json_encode($post,JSON_UNESCAPED_UNICODE);
        $model->admin_id = Yii::$app->user->identity['id'];
        $model->admin_email = Yii::$app->user->identity['email'];
        $model->ip = Yii::$app->request->userIP;
        if(!empty(Yii::$app->request->post()) && (strpos($model->route, 'update') !==false || strpos($model->route, 'del') !==false || strpos($model->route, 'active') !==false || strpos($model->route, 'add') !==false || strpos($model->route, 'import') !==false)){
            if(strpos($model->route, 'address') ===false){
                $model->save();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'route' => Yii::t('rbac-admin', '路由'),
            'url' => Yii::t('rbac-admin', '链接'),
            'admin' => Yii::t('rbac-admin', '用户'),
            'admin_email' => Yii::t('rbac-admin', '邮箱'),
            'ip' => Yii::t('rbac-admin', 'IP地址'),
            'user_agent' => Yii::t('rbac-admin', '用户浏览器'),
            'updated_at' => Yii::t('rbac-admin', '修改时间'),
            'created_at' => Yii::t('rbac-admin', '创建时间'),
        ];
    }

    /**
     * Get admin name
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        $model = new $this->userClassName;
        return $this->hasOne($model::className(), ['id' => 'admin_id']);
    }
}