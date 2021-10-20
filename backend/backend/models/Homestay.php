<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "homestay".
 *
 * @property string $community_id
 * @property int $homestay_id
 * @property string $homestay_name
 * @property string $homestay_owner_address
 * @property string $homestay_owner_name
 * @property string $homestay_owner_telephone
 * @property string $homestay_latitude
 * @property string $homestay_longitude
 * @property int $homestay_occupancy_max
 * @property string $homestay_detail
 * @property string $homestay_image_cover
 * @property int $homestay_occupancy_min
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
class Homestay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homestay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'homestay_occupancy_max', 'homestay_occupancy_min', 'province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['community_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['homestay_owner_address', 'homestay_detail','homestay_news'], 'string'],
            [['homestay_latitude', 'homestay_longitude'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['homestay_name', 'homestay_owner_name', 'homestay_owner_telephone', 'create_by', 'update_by', 'homestay_line', 'homestay_facebook', 'homestay_web', 'homestay_instagram', 'homestay_contact_person_email'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [
                [
                    'community_id', 'homestay_name', 'homestay_owner_name'
                ],
                'required', 'message' => '**กรุณากรอกข้อมูล**'
            ],
            [['homestay_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [['homestay_owner_telephone', 'homestay_occupancy_min', 'homestay_occupancy_max'], 'number', 'message' => '**กรุณากรอกเฉพาะตัวเลข**'],
            [
                ['homestay_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['homestay_image_people',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            ['homestay_contact_person_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_id' => 'ชุมชน',
            'homestay_id' => 'Homestay ID',
            'homestay_name' => 'ชื่อโฮมสเตย์',
            'homestay_owner_address' => 'Homestay Owner Address',
            'homestay_owner_name' => 'ชื่อเจ้าของบ้าน',
            'homestay_owner_telephone' => 'เบอร์โทรศัพท์',
            'homestay_latitude' => 'Homestay Latitude',
            'homestay_longitude' => 'Homestay Longitude',
            'homestay_occupancy_max' => 'จำนวนรับนักท่องเที่ยวมากสุด',
            'homestay_detail' => 'Homestay Detail',
            'homestay_image_cover' => 'Homestay Image Cover',
            'homestay_occupancy_min' => 'จำนวนรับนักท่องเที่ยวน้อยที่สุด',
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
