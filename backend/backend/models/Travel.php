<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "travel".
 *
 * @property string $community_id
 * @property int $travel_id
 * @property string $travel_contact
 * @property string $travel_telephone
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 * @property string $travel_group_id
 * @property string $travel_image_map
 * @property string $travel_detail
 * @property string $travel_latitude
 * @property string $travel_longitude
 *
 * @property Community $community
 * @property TravelGroup $travelGroup
 */
class Travel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'travel_group_id'], 'default', 'value' => null],
            [['community_id', 'travel_group_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['travel_detail'], 'string'],
            [['travel_latitude', 'travel_longitude'], 'number'],
            [['travel_contact', 'travel_telephone', 'create_by', 'update_by',], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['travel_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => TravelGroup::className(), 'targetAttribute' => ['travel_group_id' => 'travel_group_id']],
            [['community_id', 'travel_group_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['travel_telephone'], 'number', 'message' => '**กรุณากรอกเฉพาะตัวเลข'],
            [
                ['travel_image_map'], 'file',
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
            'travel_id' => 'Travel ID',
            'travel_contact' => 'Travel Contact',
            'travel_telephone' => 'Travel Telephone',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'travel_group_id' => 'กลุ่มการเดินทาง',
            'travel_image_map' => 'Travel Image Map',
            'travel_detail' => 'Travel Detail',
            'travel_latitude' => 'Travel Latitude',
            'travel_longitude' => 'Travel Longitude',
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
    public function getTravelGroup()
    {
        return $this->hasOne(TravelGroup::className(), ['travel_group_id' => 'travel_group_id']);
    }
}
