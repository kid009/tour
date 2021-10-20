<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "people".
 *
 * @property string $community_id
 * @property string $people_group_id
 * @property int $people_id
 * @property string $people_name
 * @property string $people_address
 * @property string $people_image
 * @property string $people_telephone
 * @property string $people_email
 * @property string $people_line
 * @property string $people_education
 * @property string $people_detail
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $people_latitude
 * @property string $people_longitude
 * @property int $province_id
 * @property int $amphur_id
 * @property int $tambon_id
 *
 * @property Community $community
 * @property PeopleGroup $peopleGroup
 */
class People extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'people';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'people_group_id', 'province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['community_id', 'people_group_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['people_address', 'people_detail', 'people_telephone', 'people_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['people_latitude', 'people_longitude'], 'number'],
            [['people_name', 'people_telephone', 'people_email', 'people_line', 'people_education', 'create_by', 'update_by', 'people_facebook', 'people_instagram'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['people_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => PeopleGroup::className(), 'targetAttribute' => ['people_group_id' => 'people_group_id']],
            [['community_id', 'people_group_id', 'people_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['people_telephone'], 'number', 'message' => '**กรุณากรอกเฉพาะตัวเลข'],
            [
                ['people_image'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['people_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            ['people_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_id' => 'ชุมชน',
            'people_group_id' => 'กลุ่มบุคคล',
            'people_id' => 'People ID',
            'people_name' => 'ชื่อบุคคล',
            'people_address' => 'People Address',
            'people_image' => 'People Image',
            'people_telephone' => 'เบอร์โทรศัพท์',
            'people_email' => 'อีเมล์',
            'people_line' => 'Line',
            'people_education' => 'People Education',
            'people_detail' => 'People Detail',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'people_latitude' => 'People Latitude',
            'people_longitude' => 'People Longitude',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeopleGroup()
    {
        return $this->hasOne(PeopleGroup::className(), ['people_group_id' => 'people_group_id']);
    }
}
