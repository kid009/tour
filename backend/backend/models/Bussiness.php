<?php

namespace app\models;

use Yii;

class Bussiness extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bussiness';
    }

    public function rules()
    {
        return [
            [['bussiness_group_id'], 'integer'],
            [['bussiness_detail', 'bussiness_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_name', 'bussiness_name_en', 'create_by', 'update_by', 'bussiness_history', 'bussiness_vdo', 'bussiness_link'], 'string', 'max' => 200],
            [['bussiness_name','bussiness_group_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['bussiness_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            // 'bussiness_group_id' => 'bussiness_group_id',
            // 'bussiness_group_name' => 'bussiness_group_name',
            // 'bussiness_group_name_detail' => 'bussiness_group_name_detail',
            // 'bussiness_group_name_en' => 'bussiness_group_name_en',
            // 'bussiness_group_name_detail_en' => 'bussiness_group_name_detail_en',
            // 'create_by' => 'Create By',
            // 'create_date' => 'Create Date',
            // 'update_by' => 'Updae By',
            // 'update_date' => 'Update Date',
        ];
    }

    public function getBussinessGroup()
    {
        return $this->hasOne(BussinessGroup::className(), ['bussiness_group_id' => 'bussiness_group_id']);
    }

}
