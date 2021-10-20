<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nature".
 *
 * @property int $nature_id
 * @property string $community_id
 * @property string $nature_group_id
 * @property string $nature_name
 * @property string $nature_name_en
 * @property string $nature_caretaker
 * @property string $nature_telephone
 * @property string $nature_detail
 * @property string $nature_detail_en
 * @property string $nature_latitude
 * @property string $nature_longitude
 * @property string $nature_image_cover
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Community $community
 * @property NatureGroup $natureGroup
 */
class Nature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nature';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'nature_group_id'], 'default', 'value' => null],
            [['community_id', 'nature_group_id'], 'integer'],
            [['community_id', 'nature_group_id', 'nature_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['nature_detail', 'nature_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['nature_name', 'nature_name_en', 'nature_caretaker', 'create_by', 'update_by','nature_caretaker_email','nature_caretaker_line','nature_caretaker_facebook','nature_caretaker_instagram'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['nature_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => NatureGroup::className(), 'targetAttribute' => ['nature_group_id' => 'nature_group_id']],
            [['nature_latitude', 'nature_longitude'], 'number'],
            [
                ['nature_image_cover','nature_caretaker_image'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['nature_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            ['nature_caretaker_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nature_id' => 'Nature ID',
            'community_id' => 'ชุมชน',
            'nature_group_id' => 'กลุ่มสถานที่',
            'nature_name' => 'ชื่อสถานที่',
            'nature_name_en' => 'สถานที่ธรรมชาติภาษาอังกฤษ',
            'nature_caretaker' => 'ผู้ดูแลสถานที่',
            'nature_telephone' => 'เบอร์โทรศัพท์ผู้ดูแลสถานที่',
            'nature_detail' => 'รายละเอียด',
            'nature_detail_en' => 'รายละเอียดภาษาอังกฤษ',
            'nature_latitude' => 'ละติจูด',
            'nature_longitude' => 'ลองติจูด',
            'nature_image_cover' => 'รูปภาพสถานที่',
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
    public function getNatureGroup()
    {
        return $this->hasOne(NatureGroup::className(), ['nature_group_id' => 'nature_group_id']);
    }
}
