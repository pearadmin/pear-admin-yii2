<?php

namespace rbac\models\form;

use rbac\components\Configs;
use rbac\models\Menu;
use yii\base\Model;


/**
 * This is the model class for table "yp_menu".
 *
 * @property string $name
 * @property int|null $parent
 * @property string|null $route
 * @property int|null $order
 * @property string|null $icon
 *
 */
class MenuForm extends Model
{
    public $name;
    public $route;
    public $parent;
    public $order;
    public $icon;

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
            [['name','parent','route'], 'required'],
            [['order'], 'integer'],
            [['name', 'icon'], 'string', 'max' => 128],
            [['route']
                ,'in'
                ,'range' => static::getSavedRoutes()
                ,'message'=>'路径{value}不存在'],
            [['parent']
                ,'in'
                ,'range'=>Menu::find()->select(['name'])->column()
                ,'message'=>'菜单{value}不存在'],

        ];
    }

    private static $routes;
}
