<?php

namespace app\models;

use Yii;

class BussinessProductType extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bussiness_product_type';
    }

    public function rules()
    {
        return [
            [['bussiness_product_type_name_detail', 'bussiness_product_type_name_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_product_type_name', 'bussiness_product_type_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['bussiness_product_type_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_product_type_name'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'bussiness_product_type_id' => 'bussiness_product_type_id',
            'bussiness_product_type_name' => 'bussiness_product_type_name',
            'bussiness_product_type_name_detail' => 'bussiness_product_type_name_detail',
            'bussiness_product_type_name_en' => 'bussiness_product_type_name_en',
            'bussiness_product_type_name_detail_en' => 'bussiness_product_type_name_detail_en',
            'bussiness_produc_image_cover' => 'bussiness_produc_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

    public function getResearchKnows()
    {
        return $this->hasMany(ResearchKnow::className(), ['bussiness_product_type_id' => 'bussiness_product_type_id']);
    }

}
