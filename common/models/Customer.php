<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yp_customer".
 *
 * @property int $id
 * @property string|null $nickname
 * @property int|null $status 0:正常 1：删除
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yp_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['nickname'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'status' => 'Status',
        ];
    }

    public function getOrder(){
        //SELECT * FROM `order` WHERE `user_id` IN (1,2) AND `pay_status` = 0
        return $this->hasMany(Order::className(),['user_id'=>'id']);
    }
}
