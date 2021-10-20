<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "poi".
 *
 * @property string $community_id
 * @property string $poi_group_id
 * @property int $poi_id
 * @property string $poi_name
 * @property string $poi_detail
 * @property string $poi_telephone
 * @property string $province_id
 * @property string $amphur_id
 * @property string $tambon_id
 * @property string $poi_website
 * @property string $poi_image_cover
 * @property string $poi_latitude
 * @property string $poi_longitude
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $poi_contanct_name
 *
 * @property Community $community
 * @property PoiGroup $poiGroup
 */
class Poi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'poi_group_id', 'province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['community_id', 'poi_group_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['poi_detail'], 'string'],
            [['poi_latitude', 'poi_longitude'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['poi_name', 'poi_telephone', 'poi_website', 'create_by', 'update_by', 'poi_contanct_name', 'poi_contact_person_email', 'poi_contact_person_line', 'poi_contact_person_facebook', 'poi_contact_person_instagram'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['poi_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => PoiGroup::className(), 'targetAttribute' => ['poi_group_id' => 'poi_group_id']],
            [['community_id', 'poi_group_id', 'poi_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            ['poi_contact_person_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
            [
                ['poi_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['poi_contact_person_image',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_id' => 'ชุมชน',
            'poi_group_id' => 'กลุ่มสถานที่',
            'poi_id' => 'Poi ID',
            'poi_name' => 'ชื่อสถานที่',
            'poi_detail' => 'Poi Detail',
            'poi_telephone' => 'Poi Telephone',
            'province_id' => 'Province ID',
            'amphur_id' => 'Amphur ID',
            'tambon_id' => 'Tambon ID',
            'poi_website' => 'เว็บไซต์',
            'poi_image_cover' => 'Poi Image Cover',
            'poi_latitude' => 'Poi Latitude',
            'poi_longitude' => 'Poi Longitude',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'poi_contanct_name' => 'Poi Contanct Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoiGroup()
    {
        return $this->hasOne(PoiGroup::className(), ['poi_group_id' => 'poi_group_id']);
    }
}
