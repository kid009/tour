<?php

namespace app\models;

use Yii;

class TourismImpressiveGroup extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tourism_impressive_group';
    }

    public function rules()
    {
        return [
            [['tourism_impressive_group_name_detail', 'tourism_impressive_group_name_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['tourism_impressive_group_name', 'tourism_impressive_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['tourism_impressive_group_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_impressive_group_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tourism_impressive_group_id' => 'tourism_impressive_group_id',
            'tourism_impressive_group_name' => 'tourism_impressive_group_name',
            'tourism_impressive_group_name_detail' => 'tourism_impressive_group_name_detail',
            'tourism_impressive_group_name_en' => 'tourism_impressive_group_name_en',
            'tourism_impressive_group_name_detail_en' => 'tourism_impressive_group_name_detail_en',
            'tourism_impressive_image_cover' => 'tourism_impressive_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchKnows()
    {
        return $this->hasMany(ResearchKnow::className(), ['tourism_impressive_group_id' => 'tourism_impressive_group_id']);
    }

}
