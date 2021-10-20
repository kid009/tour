<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "special_group".
 *
 * @property string $community_id
 * @property int $special_group_id
 * @property string $special_group_name
 * @property string $special_group_detail
 * @property string $special_group_telephone
 * @property string $special_group_email
 * @property string $special_group_line
 * @property string $special_group_latitude
 * @property string $special_group_longitude
 * @property string $special_group_contact_person
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Community $community
 * @property SpecialGroupPeople[] $specialGroupPeoples
 */
class SpecialGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'special_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'knowhow_id'], 'default', 'value' => null],
            [['community_id'], 'integer'],
            [['special_group_detail', 'special_group_contact_person', 'special_group_detail_en'], 'string'],
            [['special_group_latitude', 'special_group_longitude'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['special_group_facebook','special_group_name', 'special_group_telephone', 'special_group_email', 'special_group_line', 'create_by', 'update_by', 'special_group_name_en', 'special_group_link', 'special_group_vdo'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['community_id', 'special_group_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['special_group_telephone'], 'number', 'message' => '**กรุณากรอกเฉพาะตัวเลข'],
            [
                ['special_group_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['special_group_image_contact',], 'file',
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
            'community_id' => 'ชุมชน',
            'special_group_id' => 'Special Group ID',
            'special_group_name' => 'กลุ่มอาชีพ',
            'special_group_detail' => 'Special Group Detail',
            'special_group_telephone' => 'Special Group Telephone',
            'special_group_email' => 'อีเมล์',
            'special_group_line' => 'Line',
            'special_group_latitude' => 'Special Group Latitude',
            'special_group_longitude' => 'Special Group Longitude',
            'special_group_contact_person' => 'Special Group Contact Person',
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
    public function getSpecialGroupPeoples()
    {
        return $this->hasMany(SpecialGroupPeople::className(), ['special_group_id' => 'special_group_id']);
    }

    public function getKnowhow()
    {
        return $this->hasOne(Knowhow::className(), ['knowhow_id' => 'knowhow_id']);
    }

}
