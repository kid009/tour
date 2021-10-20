<?php

namespace app\models;

use Yii;

class ResearchTechnologyGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_technology_group';
    }

    public function rules()
    {
        return [
            [['researcher_technology_group_name_detail', 'researcher_technology_group_name_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_technology_group_name', 'researcher_technology_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['researcher_technology_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['researcher_technology_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'researcher_technology_group_id' => 'researcher_technology_group_id',
            'researcher_technology_group_name' => 'researcher_technology_group_name',
            'researcher_technology_group_name_detail' => 'researcher_technology_group_name_detail',
            'researcher_technology_group_name_en' => 'researcher_technology_group_name_en',
            'researcher_technology_group_name_detail_en' => 'researcher_technology_group_name_detail_en',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

}
