<?php

namespace rbac\models;

use Yii;
use rbac\components\Configs;

/**
 * This is the model class for table "yp_menu".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent
 * @property string|null $route
 * @property int|null $order
 * @property string|null $icon
 *
 * @property Menu $parent0
 * @property Menu[] $menus
 * @property string $parent_name
 */
class Menu extends \yii\db\ActiveRecord
{
    private static $routes;
    public $parent_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yp_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent', 'order'], 'integer'],
            [['name', 'icon'], 'string', 'max' => 128],
            [['route'], 'string', 'max' => 255],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['parent' => 'id']],
            [['route']
                ,'in'
                ,'range' => static::getSavedRoutes()
                ,'message'=>'路径{value}不存在'],
            [['parent_name']
                ,'in'
                ,'range'=>Menu::find()->select(['name'])->column()
                ,'message'=>'菜单{value}不存在'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名称',
            'parent' => '父菜单',
            'route' => '路由',
            'order' => '排序',
            'icon' => '图标',
            'parent_name'=>'父菜单名称'
        ];
    }

    /**
     * Gets query for [[Parent0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent']);
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parent' => 'id']);
    }

    /**
     * 获取已经存在的路径
     * @return array
     */
    public static function getSavedRoutes()
    {
        if (self::$routes === null) {
            self::$routes = [];
            foreach (Configs::authManager()->getPermissions() as $name => $value) {
                if ($name[0] === '/' && substr($name, -1) != '*') {
                    self::$routes[] = $name;
                }
            }
        }
        return self::$routes;
    }
}
