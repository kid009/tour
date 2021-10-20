<?php

namespace app\models;

use Yii;

class ResearchOutputApplyGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_output_apply_group';
    }

    public function rules()
    {
        return [
            [['researcher_output_apply_group_detail', 'researcher_output_apply_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_output_apply_group_name', 'researcher_output_apply_group_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['researcher_output_apply_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['researcher_experience_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'researcher_output_apply_group_id' => 'researcher_output_apply_group_id',
            'researcher_output_apply_group_name' => 'researcher_output_apply_group_name',
            'researcher_output_apply_group_en' => 'researcher_output_apply_group_en',
            'researcher_output_apply_group_detail' => 'researcher_output_apply_group_detail',
            'researcher_output_apply_group_detail_en' => 'researcher_output_apply_group_detail_en',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

}
