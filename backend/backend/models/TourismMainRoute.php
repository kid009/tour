<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourism_main_route".
 *
 * @property int $tourism_main_route_id
 * @property string $tourism_main_route_name
 * @property string $tourism_main_route_detail
 * @property string $tourism_main_route_name_en
 * @property string $tourism_main_route_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property TourismSubRoute[] $tourismSubRoutes
 */
class TourismMainRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourism_main_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_main_route_detail', 'tourism_main_route_detail_en', 'active'], 'string'],
            [['create_date', 'update_date', 'user_group_id'], 'safe'],
            [['tourism_main_route_name', 'tourism_main_route_name_en', 'create_by', 'update_by', 'tourism_main_route_vdo', 'tourism_main_route_link', 'tourism_main_route_contact_name', 'tourism_main_route_telephone', 'tourism_main_route_email', 'tourism_main_route_facebook', 'tourism_main_route_line'], 'string', 'max' => 200],
            [['tourism_main_route_name', 'active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_main_route_image'], 'file',
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['tourism_main_route_image'], 'file',
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['tourism_main_route_contact_image',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourism_main_route_id' => 'Tourism Main Route ID',
            'tourism_main_route_name' => 'ชื่อเส้นทางท่องเที่ยว',
            'tourism_main_route_detail' => 'Tourism Main Route Detail',
            'tourism_main_route_name_en' => 'ชื่อภาษาอังกฤษ',
            'tourism_main_route_detail_en' => 'Tourism Main Route Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourismSubRoutes()
    {
        return $this->hasMany(TourismSubRoute::className(), ['tourism_main_route_id' => 'tourism_main_route_id']);
    }
    
    public function getTourismSubRouteActivitys()
    {
        return $this->hasMany(TourismSubRouteActivity::className(), ['tourism_main_route_id' => 'tourism_main_route_id']);
    }
    
}
