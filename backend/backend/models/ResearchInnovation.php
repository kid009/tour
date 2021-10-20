<?php

namespace app\models;

use Yii;

class ResearchInnovation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_innovation';
    }

    public function rules()
    {
        return [
            [['researcher_knowhow_id', 'researcher_innovation_group_id', 'researcher_experience_id', 'researcher_technology_id'], 'integer'],
            [['researcher_innovation_detail_en', 'researcher_innovation_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_innovation_name', 'researcher_innovation_name_en', 'create_by', 'update_by', 'researcher_innovation_link', 'researcher_innovation_vdo'], 'string', 'max' => 200],
            [['researcher_innovation_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchInnovationGroup::className(), 'targetAttribute' => ['researcher_innovation_group_id' => 'researcher_innovation_group_id']],

            [['researcher_innovation_group_id', 'researcher_innovation_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['researcher_innovation_name', 'researcher_innovation_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['researcher_innovation_image_cover'], 'file',
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
            'researcher_innovation_id' => 'researcher_innovation_id',
            'researcher_innovation_group_id' => 'กลุ่มนวัฒกรรม',
            'researcher_innovation_name' => 'ชื่อเนวัฒกรรม',
            'researcher_innovation_name_en' => 'ชื่อเนวัฒกรรมภาษาอังกฤษ',
            'researcher_innovation_detail' => 'researcher_innovation_detail',
            'researcher_innovation_detail_en' => 'researcher_innovation_detail_en',
            'researcher_innovation_image_cover' => 'researcher_innovation_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchInnovationGroup()
    {
        return $this->hasOne(ResearchInnovationGroup::className(), ['researcher_innovation_group_id' => 'researcher_innovation_group_id']);
    }
}
