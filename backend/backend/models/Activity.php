<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property string $activity_group_id
 * @property string $community_id
 * @property int $activity_id
 * @property string $activity_name
 * @property string $activity_detail
 * @property string $activity_image_cover
 * @property string $activity_latitude
 * @property string $activity_longitude
 * @property double $activity_price
 * @property int $activity_duration
 * @property int $activity_participant_min
 * @property string $activity_participant_age
 * @property string $activity_period
 * @property string $activity_duration_text
 * @property string $activity_name_en
 * @property string $activity_detail_en
 * @property int $activity_participant_max
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property ActivityGroup $activityGroup
 * @property Community $community
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_group_id', 'community_id', 'activity_duration', 'activity_participant_min', 'activity_participant_max', 'knowhow_id'], 'default', 'value' => null],
            [['activity_group_id', 'community_id', 'activity_duration', 'activity_participant_min', 'activity_participant_max', 'knowhow_id'], 'integer'],
            [['activity_detail', 'activity_detail_en', 'activity_link_vdo'], 'string'],
            [['activity_latitude', 'activity_longitude'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['activity_name', 'activity_participant_age', 'activity_period', 'activity_duration_text', 'activity_name_en', 'create_by', 'update_by', 'activity_price', 'activity_link', 'activity_contact_name', 'activity_telephone', 'activity_email', 'activity_facebook', 'activity_line'], 'string', 'max' => 200],
            [['activity_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityGroup::className(), 'targetAttribute' => ['activity_group_id' => 'activity_group_id']],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['activity_group_id', 'community_id', 'activity_name', 'knowhow_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],

            [['activity_name', 'activity_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['activity_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['activity_contact_image'], 'file',
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
            'activity_group_id' => 'กลุ่มกิจกรรม',
            'community_id' => 'ชุมชน',
            'activity_id' => 'Activity ID',
            'activity_name' => 'ชื่อกิจกรรม',
            'activity_detail' => 'Activity Detail',
            'activity_image_cover' => 'Activity Image Cover',
            'activity_latitude' => 'Activity Latitude',
            'activity_longitude' => 'Activity Longitude',
            'activity_price' => 'อัตราค่าบริการ',
            'activity_duration' => 'เวลาทำกิจกรรม',
            'activity_participant_min' => 'จำนวนผู้ร่วมกิจกรรม(ต่ำสุด)',
            'activity_participant_age' => 'ช่วงอายุผู้ร่วมกิจกรรม',
            'activity_period' => 'ช่วงเวลาที่ทำกิจกรรม',
            'activity_duration_text' => 'รายละเอียดเวลาทำกิจกรรม',
            'activity_name_en' => 'ชื่อภาษาอังกฤษ',
            'activity_detail_en' => 'Activity Detail En',
            'activity_participant_max' => 'จำนวนผู้ร่วมกิจกรรม(มากสุด)',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityGroup()
    {
        return $this->hasOne(ActivityGroup::className(), ['activity_group_id' => 'activity_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }
}