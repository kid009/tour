<?php

namespace app\models;

use Yii;

class ResearchOutputApply extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_output_apply';
    }

    public function rules()
    {
        return [
            [['researcher_output_apply_group_id'], 'integer'],
            [['researcher_output_apply_detail', 'researcher_output_apply_detail_en',], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_output_apply_name', 'researcher_output_apply_name_en', 'create_by', 'update_by', 'researcher_output_apply_vdo', 'researcher_output_apply_link', 'researcher_output_apply_place'], 'string', 'max' => 200],
            //[['researcher_output_apply_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchOutputApplyGroup::className(), 'targetAttribute' => ['researcher_output_apply_group_id' => 'researcher_output_apply_group_id']],
            [['researcher_output_apply_group_id', 'researcher_output_apply_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['researcher_technology_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['researcher_output_apply_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'researcher_output_apply_id' => 'researcher_output_apply_id',
            'researcher_output_apply_group_id' => 'researcher_output_apply_group_id',
            'researcher_output_apply_name' => 'researcher_output_apply_name',
            'researcher_output_apply_name_en' => 'researcher_output_apply_name_en',
            'researcher_output_apply_detail' => 'researcher_output_apply_detail',
            'researcher_output_apply_detail_en' => 'researcher_output_apply_detail_en',
            'researcher_output_apply_image_cover' => 'researcher_output_apply_image_cover',
            'researcher_output_apply_vdo' => 'researcher_output_apply_vdo',
            'researcher_output_apply_link' => 'researcher_output_apply_link',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchOutputApplyGroup()
    {
        return $this->hasOne(ResearchOutputApplyGroup::className(), ['researcher_output_apply_group_id' => 'researcher_output_apply_group_id']);
    }
    
}