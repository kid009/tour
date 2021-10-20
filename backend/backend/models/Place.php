<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "place".
 *
 * @property int $place_id
 * @property string $place_name
 * @property string $place_telephone
 * @property string $place_detail
 * @property string $place_latitude
 * @property string $place_longitude
 * @property string $place_image_cover
 * @property string $place_group_id
 * @property string $community_id
 * @property string $place_contact_person
 * @property string $place_name_en
 * @property string $place_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Community $community
 * @property PlaceGroup $placeGroup
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_detail', 'place_detail_en'], 'string'],
            [['place_latitude', 'place_longitude'], 'number'],
            [['place_group_id', 'community_id'], 'default', 'value' => null],
            [['community_id', 'place_group_id', 'place_name','active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['place_group_id', 'community_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['place_name', 'place_telephone', 'place_contact_person', 'place_name_en', 'create_by', 'update_by', 'active', 'place_vdo','place_contact_person_email','place_contact_person_line','place_contact_person_facebook','place_contact_person_instagram'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['place_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlaceGroup::className(), 'targetAttribute' => ['place_group_id' => 'place_group_id']],
            [['place_image_cover','place_contact_person_image'], 'file',
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['place_name',], 
                'unique',
                'message' => '**ชื่อนี้ซ้ำในระบบ**'
            ],
            ['place_contact_person_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'place_id' => 'Place ID',
            'community_id' => 'ชื่อชุมชน',
            'place_group_id' => 'กลุ่มสถานที่ประวัติศาสตร์',
            'place_name' => 'ชื่อสถานที่',
            'place_name_en' => 'ชื่อภาษาอังกฤษ',
            'place_image_cover' => 'Place Image Cover',
            'place_contact_person' => 'Place Contact Person',
            'place_telephone' => 'Place Telephone',
            'place_detail' => 'รายละเอียด',
            'place_detail_en' => 'รายละเอียดภาษาอังกฤษ',
            'place_latitude' => 'Place Latitude',
            'place_longitude' => 'Place Longitude',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
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
    public function getPlaceGroup()
    {
        return $this->hasOne(PlaceGroup::className(), ['place_group_id' => 'place_group_id']);
    }
}
