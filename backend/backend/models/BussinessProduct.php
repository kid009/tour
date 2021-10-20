<?php

namespace app\models;

use Yii;

class BussinessProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bussiness_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bussiness_product_id', 'bussiness_product_group_id', 'bussiness_product_type_id'], 'integer'],
            [['bussiness_product_detail_en', 'bussiness_product_detail', 'bussiness_product_promotion'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_product_name', 'bussiness_product_name_en', 'create_by', 'update_by', 'bussiness_product_link', 'bussiness_product_vdo', 'bussiness_product_price'], 'string', 'max' => 200],
            [['bussiness_product_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => BussinessProductGroup::className(), 'targetAttribute' => ['bussiness_product_group_id' => 'bussiness_product_group_id']],

            [['bussiness_product_group_id', 'bussiness_product_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_product_name', 'bussiness_product_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['bussiness_product_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bussiness_product_id' => 'bussiness_product_id',
            'bussiness_product_group_id' => 'bussiness_product_group_id',
            'bussiness_product_type_id' => 'bussiness_product_type_id',
            'bussiness_product_name' => 'bussiness_product_name',
            'bussiness_product_name_en' => 'bussiness_product_name_en',
            'bussiness_product_detail' => 'bussiness_product_detail',
            'bussiness_product_detail_en' => 'bussiness_product_detail_en',
            'bussiness_product_image_cover' => 'bussiness_product_image_cover',

            'bussiness_product_vdo' => 'bussiness_product_vdo',
            'bussiness_product_link' => 'bussiness_product_link',
            'bussiness_product_promotion' => 'bussiness_product_promotion',

            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBussinessProductGroup()
    {
        return $this->hasOne(BussinessProductGroup::className(), ['bussiness_product_group_id' => 'bussiness_product_group_id']);
    }

    public function getBussinessProductType()
    {
        return $this->hasOne(BussinessProductType::className(), ['bussiness_product_type_id' => 'bussiness_product_type_id']);
    }
}
