<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "yp_order".
 *
 * @property int $id
 * @property string|null $order_num
 * @property int|null $user_id
 * @property int|null $pay_status 0: 未支付 1：已支付
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yp_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'pay_status'], 'integer'],
            [['order_num'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_num' => 'Order Num',
            'user_id' => 'User ID',
            'pay_status' => 'Pay Status',
        ];
    }
}
