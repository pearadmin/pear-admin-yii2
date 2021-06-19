<?php

namespace rbac\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "yp_dept".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $parent
 * @property int|null $order
 */
class Dept extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yp_dept';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'order'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['parent'], 'filterParent', 'when' => function() {
                return !$this->isNewRecord;
            }],
            [['name'],'filterName']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent' => 'Parent',
            'order' => 'Order',
        ];
    }

    /**
     * Use to get parents.
     * */
    public function getParent0(){
        return $this->hasOne(Dept::className(),['id'=>'parent']);
    }

    /**
     * Use to loop detected.
     */
    public function filterParent()
    {
        $parent = $this->parent;
        $db = static::getDb();
        $query = (new Query)->select(['parent'])
            ->from(static::tableName())
            ->where('[[id]]=:id');
        while ($parent) {
            if ($this->id == $parent) {
                $this->addError('parent_name', '父部门设置错误.');
                return;
            }
            $parent = $query->params([':id' => $parent])->scalar($db);
        }
    }

    public function filterName(){
        $name = $this->name;
        $db = static::getDb();
        $_name = (new Query)->select(['name'])
            ->from(static::tableName())
            ->where(['name'=>$name])
            ->scalar();
        if($_name != ''){
            $this->addError('name', '部门名称重复');
            return;
        }

    }
}
