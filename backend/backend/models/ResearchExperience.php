<?php

namespace app\models;

use Yii;

class ResearchExperience extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_experience';
    }

    public function rules()
    {
        return [
            [['researcher_experience_id', 'researcher_experience_group_id'], 'integer'],
            [['researcher_experience_detail_en', 'researcher_experience_detail',], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_experience_name', 'researcher_experience_name_en', 'create_by', 'update_by', 'researcher_experience_vdo', 'researcher_experience_link'], 'string', 'max' => 200],
            [['researcher_experience_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchExperienceGroup::className(), 'targetAttribute' => ['researcher_experience_group_id' => 'researcher_experience_group_id']],

            [['researcher_experience_group_id', 'researcher_experience_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['researcher_experience_name', 'researcher_experience_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['researcher_experience_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'researcher_experience_id' => 'researcher_experience_id',
            'researcher_experience_group_id' => 'กลุ่มประสบการณ์',
            'researcher_experience_name' => 'ชื่อประสบการณ์',
            'researcher_experience_name_en' => 'ชื่อเประสบการณ์ภาษาอังกฤษ',
            'researcher_experience_detail' => 'researcher_experience_detail',
            'researcher_experience_detail_en' => 'researcher_experience_detail_en',
            'researcher_experience_image_cover' => 'researcher_experience_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchExperienceGroup()
    {
        return $this->hasOne(ResearchExperienceGroup::className(), ['researcher_experience_group_id' => 'researcher_experience_group_id']);
    }
}