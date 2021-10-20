<?php

namespace app\models;

use Yii;

class BussinessServiceGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bussiness_service_group';
    }

    public function rules()
    {
        return [
            [['bussiness_service_group_name_detail', 'bussiness_service_group_name_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_service_group_name', 'bussiness_service_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['bussiness_service_group_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_service_group_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'bussiness_service_group_id' => 'bussiness_service_group_id',
            'bussiness_service_group_name' => 'bussiness_service_group_name',
            'bussiness_service_group_name_detail' => 'bussiness_service_group_name_detail',
            'bussiness_service_group_name_en' => 'bussiness_service_group_name_en',
            'bussiness_service_group_name_detail_en' => 'bussiness_service_group_name_detail_en',
            'bussiness_service_image_cover' => 'bussiness_service_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchKnows()
    {
        return $this->hasMany(ResearchKnow::className(), ['bussiness_service_group_id' => 'bussiness_service_group_id']);
    }

}
