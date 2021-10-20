<?php

namespace app\models;

use Yii;

class TourismExperience extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * @property int $province_id
     * @property int $amphur_id
     * @property int tambon_id
     */
    public static function tableName()
    {
        return 'tourism_experience';
    }

    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [['tourism_experience_id', 'tourism_experience_group_id','province_id','amphur_id','tambon_id'], 'integer'],
            [['tourism_experience_detail_en', 'tourism_experience_detail'], 'string'],
            [['tourism_experience_latitude', 'tourism_experience_longitude'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['is_active'], 'string', 'max' => 1],
            [['tourism_experience_name', 'tourism_experience_name_en', 'create_by', 'update_by', 'tourism_experience_link', 'tourism_experience_vdo', 'tourism_experience_hashtag', 'tourism_experience_place'], 'string', 'max' => 200],
            [['tourism_experience_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => TourismExperienceGroup::className(), 'targetAttribute' => ['tourism_experience_group_id' => 'tourism_experience_group_id']],

            [['tourism_experience_group_id', 'tourism_experience_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_experience_name', 'tourism_experience_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['tourism_experience_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourism_experience_id' => 'tourism_experience_id',
            'tourism_experience_group_id' => 'tourism_experience_group_id',
            'tourism_experience_name' => 'tourism_experience_name',
            'tourism_experience_name_en' => 'tourism_experience_name_en',
            'tourism_experience_detail' => 'tourism_experience_detail',
            'tourism_experience_detail_en' => 'tourism_experience_detail_en',
            'tourism_experience_latitude' => 'tourism_experience Latitude',
            'tourism_experience_longitude' => 'tourism_experience Longitude',
            'tourism_experience_image_cover' => 'tourism_experience_image_cover',
            'tourism_experience_hashtag' => 'tourism_experience_hashtag',
            'is_active' => 'is_active',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourismExperienceGroup()
    {
        return $this->hasOne(TourismExperienceGroup::className(), ['tourism_experience_group_id' => 'tourism_experience_group_id']);
    }
}
