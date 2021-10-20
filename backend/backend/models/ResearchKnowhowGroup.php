<?php

namespace app\models;

use Yii;

class ResearchKnowhowGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_knowhow_group';
    }

    public function rules()
    {
        return [
            [['researcher_knowhow_group_name_detail', 'researcher_knowhow_group_name_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_knowhow_group_name', 'researcher_knowhow_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['researcher_knowhow_group_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['researcher_knowhow_group_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'researcher_knowhow_group_id' => 'researcher_knowhow_group_id',
            'researcher_knowhow_group_name' => 'researcher_knowhow_group_name',
            'researcher_knowhow_group_name_detail' => 'researcher_knowhow_group_name_detail',
            'researcher_knowhow_group_name_en' => 'researcher_knowhow_group_name_en',
            'researcher_knowhow_group_name_detail_en' => 'researcher_knowhow_group_name_detail_en',
            'researcher_knowhow_image_cover' => 'researcher_knowhow_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchKnows()
    {
        return $this->hasMany(ResearchKnow::className(), ['researcher_knowhow_group_id' => 'researcher_knowhow_group_id']);
    }

}
