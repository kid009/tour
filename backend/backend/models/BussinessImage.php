<?php

namespace app\models;

use Yii;

class BussinessImage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bussiness_image';
    }

    public function rules()
    {
        return [
            [['bussiness_type_id', 'ref_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_image_name', 'create_by', 'update_by'], 'string', 'max' => 200],           
            [
                ['bussiness_image_file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ]
        ];
    }

    public function attributeLabels()
    {
        // return [
        //     'bussiness_id' => 'bussiness_id',
        //     'bussiness_group_id' => 'กลุ่มธุรกิจ',
        //     'bussiness_name' => 'ชื่อธุรกิจ',
        //     'bussiness_name_en' => 'ชื่อธุรกิจภาษาอังกฤษ',
        //     'bussiness_detail' => 'bussiness_detail',
        //     'bussiness_detail_en' => 'bussiness_detail_en',
        //     'bussiness_image_cover' => 'bussiness_image_cover',
        //     'bussiness_vdo' => 'bussiness_vdo',
        //     'create_by' => 'Create By',
        //     'create_date' => 'Create Date',
        //     'update_by' => 'Update By',
        //     'update_date' => 'Update Date',
        // ];
    }

    // public function getBussinessGroup()
    // {
    //     return $this->hasOne(BussinessGroup::className(), ['bussiness_group_id' => 'bussiness_group_id']);
    // }
    
}