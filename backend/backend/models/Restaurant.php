<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restaurant".
 *
 * @property string $restaurant_name
 * @property string $restaurant_detail
 * @property string $restaurant_latitude
 * @property string $restaurant_longitude
 * @property string $restaurant_telephone
 * @property string $restaurant_www
 * @property string $restaurant_price_range
 * @property string $restaurant_image_cover
 * @property int $restaurant_id
 * @property string $community_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property int $province_id
 * @property int $amphur_id
 * @property int $tambon_id
 *
 * @property Community $community
 */
class Restaurant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restaurant_detail'], 'string'],
            [['restaurant_latitude', 'restaurant_longitude'], 'number'],
            [['community_id', 'province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['community_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['restaurant_name', 'restaurant_telephone','restaurant_vdo', 'restaurant_www', 'restaurant_price_range', 'create_by', 'update_by', 'restaurant_contact_person_email', 'restaurant_contact_person_line', 'restaurant_contact_person_facebook', 'restaurant_contact_person_instagram', 'restaurant_contact_person_image', 'restaurant_contact_person_name'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['community_id', 'restaurant_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [
                ['restaurant_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['restaurant_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [['restaurant_contact_person_email',], 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'restaurant_name' => 'ชื่อร้านอาหาร',
            'restaurant_detail' => 'Restaurant Detail',
            'restaurant_latitude' => 'Restaurant Latitude',
            'restaurant_longitude' => 'Restaurant Longitude',
            'restaurant_telephone' => 'Restaurant Telephone',
            'restaurant_www' => 'เว็บไซต์',
            'restaurant_price_range' => 'เรตราคา',
            'restaurant_image_cover' => 'Restaurant Image Cover',
            'restaurant_id' => 'Restaurant ID',
            'community_id' => 'ชื่อชุมชน',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'province_id' => 'Province ID',
            'amphur_id' => 'Amphur ID',
            'tambon_id' => 'Tambon ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }
}
