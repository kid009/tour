<?php

namespace app\models;

use Yii;

class TourismStory extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tourism_story';
    }

    public function rules()
    {
        return [
            [['tourism_story_group_id'], 'integer'],
            [['tourism_story_detail', 'tourism_story_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['tourism_story_name', 'tourism_story_name_en', 'create_by', 'update_by', 'tourism_story_vdo', 'tourism_story_link', 'tourism_story_hashtag', 'tourism_story_place'], 'string', 'max' => 200],
            [['is_active'], 'string', 'max' => 1],
            [['tourism_story_name', 'tourism_story_group_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_story_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['tourism_story_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            // 'bussiness_group_id' => 'bussiness_group_id',
            // 'bussiness_group_name' => 'bussiness_group_name',
            // 'bussiness_group_name_detail' => 'bussiness_group_name_detail',
            // 'bussiness_group_name_en' => 'bussiness_group_name_en',
            // 'bussiness_group_name_detail_en' => 'bussiness_group_name_detail_en',
            // 'create_by' => 'Create By',
            // 'create_date' => 'Create Date',
            // 'update_by' => 'Updae By',
            // 'update_date' => 'Update Date',
        ];
    }

    public function getTourismStoryGroup()
    {
        return $this->hasOne(TourismStoryGroup::className(), ['tourism_story_group_id' => 'tourism_story_group_id']);
    }

}
