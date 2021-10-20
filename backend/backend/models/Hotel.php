<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hotel".
 *
 * @property int $hotel_id
 * @property string $hotel_name
 * @property string $hotel_detail
 * @property string $hotel_latitude
 * @property string $hotel_longitude
 * @property string $hotel_telephone
 * @property string $hotel_www
 * @property string $hotel_email
 * @property string $hotel_image_cover
 * @property string $hotel_mobile
 * @property string $hotel_rate
 * @property string $hotel_room_detail
 * @property double $hotel_room_price_min
 * @property string $hotel_address
 * @property string $community_id
 * @property double $hotel_room_price_max
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
class Hotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_detail', 'hotel_room_detail', 'hotel_address'], 'string'],
            [['hotel_latitude', 'hotel_longitude'], 'number'],
            [['community_id', 'province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['community_id', 'province_id', 'amphur_id', 'tambon_id', 'hotel_room_price_min', 'hotel_room_price_max' ], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [[
                'hotel_name'
                , 'hotel_www'
                , 'hotel_email'
                , 'hotel_mobile'
                , 'hotel_rate'
                , 'create_by'
                , 'update_by'
                , 'hotel_contact_person_line'
                , 'hotel_contact_person_facebook'
                , 'hotel_contact_person_instagram'
                , 'hotel_contact_person_name'
                , 'hotel_contact_person_email'
                , 'hotel_telephone'
            ], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['community_id', 'hotel_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['hotel_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            ['hotel_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
            ['hotel_contact_person_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
            [
                ['hotel_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['hotel_contact_person_image',], 'file',
                'skipOnEmpty' => true,
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
            'hotel_id' => 'Hotel ID',
            'community_id' => 'ชุมชน',
            'hotel_name' => 'ชื่อโรงแรม',
            'hotel_detail' => 'Hotel Detail',
            'hotel_latitude' => 'Hotel Latitude',
            'hotel_longitude' => 'Hotel Longitude',
            'hotel_telephone' => 'เบอร์โทรศัพท์',
            'hotel_www' => 'เว็บไซต์',
            'hotel_email' => 'อีเมล์',
            'hotel_image_cover' => 'Hotel Image Cover',
            'hotel_mobile' => 'เบอร์มือถือ',
            'hotel_rate' => 'เรตโรงแรม',
            'hotel_room_detail' => 'Hotel Room Detail',
            'hotel_room_price_min' => 'ราคาห้องพักต่ำสุด',
            'hotel_address' => 'ที่อยู่',
            
            'hotel_room_price_max' => 'ราคาห้องพักสูงสุด',
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
