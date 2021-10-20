<?php

namespace app\models;

use Yii;

class TourismExperienceGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tourism_experience_group';
    }

    public function rules()
    {
        return [
            [['tourism_experience_group_name_detail', 'tourism_experience_group_name_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['tourism_experience_group_name', 'tourism_experience_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['tourism_experience_group_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_experience_group_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tourism_experience_group_id' => 'tourism_experience_group_id',
            'tourism_experience_group_name' => 'tourism_experience_group_name',
            'tourism_experience_group_name_detail' => 'tourism_experience_group_name_detail',
            'tourism_experience_group_name_en' => 'tourism_experience_group_name_en',
            'tourism_experience_group_name_detail_en' => 'tourism_experience_group_name_detail_en',
            'tourism_experience_image_cover' => 'tourism_experience_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

    
}
