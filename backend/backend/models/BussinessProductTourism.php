<?php

namespace app\models;

use Yii;

class BussinessProductTourism extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bussiness_product_tourism';
    }

    public function rules()
    {
        return [
            [['bussiness_product_tourism_group_id'], 'integer'],
            [['bussiness_product_tourism_detail', 'bussiness_product_tourism_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_product_tourism_name', 'bussiness_product_tourism_name_en', 'create_by', 'update_by', 'bussiness_product_tourism_story', 'bussiness_product_tourism_vdo', 'bussiness_product_tourism_link', 'bussiness_product_tourism_promotion'], 'string', 'max' => 200],
            [['bussiness_product_tourism_name','bussiness_product_tourism_group_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_product_tourism_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['bussiness_product_tourism_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['bussiness_product_tourism_price'], 'double'],
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

    public function getBussinessProductTourismGroup()
    {
        return $this->hasOne(BussinessProductTourismGroup::className(), ['bussiness_product_tourism_group_id' => 'bussiness_product_tourism_group_id']);
    }

}
