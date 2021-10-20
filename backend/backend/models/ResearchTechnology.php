<?php

namespace app\models;

use Yii;

class ResearchTechnology extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_technology';
    }

    public function rules()
    {
        return [
            [['researcher_technology_id'], 'integer'],
            [['researcher_technology_detail_en', 'researcher_technology_detail',], 'string'],
            [['researcher_technology_vdo',], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_technology_name', 'researcher_technology_name_en', 'create_by', 'update_by', 'researcher_technology_link'], 'string', 'max' => 200],
            //[['researcher_technology_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchTechnologyGroup::className(), 'targetAttribute' => ['researcher_technology_group_id' => 'researcher_technology_group_id']],

            [['researcher_technology_group_id', 'researcher_technology_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['researcher_technology_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['researcher_technology_image_cover',], 'file',
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
            'researcher_technology_id' => 'researcher_technology ID',
            'researcher_technology_group_id' => 'กลุ่มเทคโนโลยี',
            'researcher_technology_name' => 'ชื่อเทคโนโลยี',
            'researcher_technology_name_en' => 'ชื่อเทคโนโลยีภาษาอังกฤษ',
            'researcher_technology_detail' => 'researcher_technology Detail',
            'researcher_technology_detail_en' => 'researcher_technology Detail En',
            'researcher_technology_image_cover' => 'researcher_technology Image Cover',
            'researcher_technology_vdo' => 'researcher_technology vdo ',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchTechnologyGroup()
    {
        return $this->hasOne(ResearchTechnologyGroup::className(), ['researcher_technology_group_id' => 'researcher_technology_group_id']);
    }
    
}