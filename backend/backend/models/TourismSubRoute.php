<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourism_sub_route".
 *
 * @property int $tourism_sub_route_id
 * @property string $tourism_main_route_id
 * @property string $tourism_sub_route_name
 * @property string $tourism_sub_route_detail
 * @property string $tourism_sub_route_name_en
 * @property string $tourism_sub_route_detail_en
 * @property int $tourism_sub_route_order
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property TourismMainRoute $tourismMainRoute
 * @property TourismSubRouteActivity[] $tourismSubRouteActivities
 */
class TourismSubRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourism_sub_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_main_route_id', 'tourism_sub_route_order'], 'default', 'value' => null],
            [['tourism_main_route_id',], 'integer'],
            [['tourism_sub_route_detail', 'tourism_sub_route_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['tourism_sub_route_name', 'tourism_sub_route_name_en', 'create_by', 'update_by', 'tourism_sub_route_name_initial','tourism_sub_route_name_initial_eng', 'tourism_sub_route_vdo', 'tourism_sub_route_link', 'tourism_sub_route_contact_name', 'tourism_sub_route_telephone', 'tourism_sub_route_email', 'tourism_sub_route_facebook', 'tourism_sub_route_line'], 'string', 'max' => 200],
            [['tourism_main_route_id'], 'exist', 'skipOnError' => true, 'targetClass' => TourismMainRoute::className(), 'targetAttribute' => ['tourism_main_route_id' => 'tourism_main_route_id']],
            [['tourism_main_route_id','tourism_sub_route_name','tourism_sub_route_order'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_sub_route_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            //[['tourism_sub_route_order'], 'number', 'message' => '**กรุณากรอกเฉพาะตัวเลข'],
            
            [['tourism_sub_route_image_cover'], 'file',
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['tourism_sub_route_contact_image'], 'file',
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourism_sub_route_id' => 'Tourism Sub Route ID',
            'tourism_main_route_id' => 'เส้นทางท่องเที่ยวหลัก',
            'tourism_sub_route_name' => 'ชื่อเส้นทางท่องเที่ยวย่อย',
            'tourism_sub_route_detail' => 'Tourism Sub Route Detail',
            'tourism_sub_route_name_en' => 'ชื่อเส้นทางท่องเที่ยวภาษาอังกฤษ',
            'tourism_sub_route_detail_en' => 'Tourism Sub Route Detail En',
            'tourism_sub_route_order' => 'ลำดับเส้นทาง',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'tourism_sub_route_name_initial' => 'ชื่อเส้นทางท่องเที่ยวย่อย (ย่อ)',
            'tourism_sub_route_name_initial_eng' => 'ชื่อเส้นทางภาษาอังกฤษ (ย่อ)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourismMainRoute()
    {
        return $this->hasOne(TourismMainRoute::className(), ['tourism_main_route_id' => 'tourism_main_route_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourismSubRouteActivities()
    {
        return $this->hasMany(TourismSubRouteActivity::className(), ['tourism_sub_route_id' => 'tourism_sub_route_id']);
    }
}
