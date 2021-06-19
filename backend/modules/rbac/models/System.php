<?php

namespace rbac\models;

use Yii;

/**
 * This is the model class for table "yp_system".
 *
 * @property int $id
 * @property string|null $logo_title
 * @property int|null $tab_max
 * @property int|null $keep_load
 * @property string|null $index_title
 * @property string|null $index_href
 * @property string|null $links_title
 * @property string|null $links_href
 * @property string|null $links_icon
 * @property int|null $session
 * @property int|null $muilt_tab
 * @property int|null $verify_code
 * @property string|null $file_name
 * @property int|null $menu_control
 * @property int|null $menu_accordion
 */
class System extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yp_system';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tab_max', 'keep_load', 'session', 'muilt_tab', 'verify_code', 'menu_control', 'menu_accordion'], 'integer'],
            [['links_title', 'links_href'], 'string'],
            [['logo_title', 'index_title'], 'string', 'max' => 50],
            [['index_href', 'links_icon', 'file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo_title' => 'Logo Title',
            'tab_max' => 'Tab Max',
            'keep_load' => 'Keep Load',
            'index_title' => 'Index Title',
            'index_href' => 'Index Href',
            'links_title' => 'Links Title',
            'links_href' => 'Links Href',
            'links_icon' => 'Links Icon',
            'session' => 'Session',
            'muilt_tab' => 'Muilt Tab',
            'verify_code' => 'Verify Code',
            'file_name' => 'File Name',
            'menu_control' => 'Menu Control',
            'menu_accordion' => 'Menu Accordion',
        ];
    }
}
