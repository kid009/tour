<?php

namespace app\models;

use Yii;

class TourismStoryGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tourism_story_group';
    }

    public function rules()
    {
        return [
            [['tourism_story_group_name_detail', 'tourism_story_group_name_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['tourism_story_group_name', 'tourism_story_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['tourism_story_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['tourism_story_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
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

}
