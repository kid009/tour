<?php

namespace app\models;

use Yii;

class Beststudy extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'beststudy';
    }

    public function rules()
    {
        return [
            [['product_id'], 'default', 'value' => null],
            [['product_id'], 'integer'],
            [['best_study_detail', 'best_study_result', 'best_study_apply',], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['best_study_name',  'best_study_vdo', 'best_study_facebook', 'best_study_line', 'create_by', 'update_by', 'best_study_telephone', 'best_study_email', 'best_study_instagram', 'best_study_name_contact'], 'string', 'max' => 200],
            [['best_study_name', 'product_id',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'product_id']],
            [
                ['best_study_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['best_study_image_contact',], 'file',
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
            'product_id' => 'product_id',
            'best_study_detail' => 'best_study_detail',
            'best_study_result' => 'best_study_result',
            'best_study_apply' => 'best_study_apply',
            'best_study_detail' => 'best_study_detail',
            'best_study_name' => 'best_study_name',
            'best_study_vdo' => 'best_study_vdo',
            'best_study_facebook' => 'best_study_facebook',
            'best_study_line' => 'best_study_line',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
    }

}
