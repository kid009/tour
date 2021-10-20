<?php

namespace app\models;

use Yii;

class Entrepreneur extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'entrepreneur';
    }

    public function rules()
    {
        return [
            [['entrepreneur_group_id', 'province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['entrepreneur_group_id', 'province_id', 'amphur_id', 'tambon_id', 'entrepreneur_place_id'], 'integer'],
            [['entrepreneur_address', 'entrepreneur_detail', 'entrepreneur_telephone'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['entrepreneur_latitude', 'entrepreneur_longitude'], 'number'],
            [['entrepreneur_name', 'entrepreneur_telephone', 'entrepreneur_email', 'entrepreneur_line', 'create_by', 'update_by', 'entrepreneur_facebook', 'entrepreneur_knowledge', 'entrepreneur_product', 'entrepreneur_service', 'entrepreneur_local_product', 'entrepreneur_information'], 'string', 'max' => 200],
            [['entrepreneur_group_id', 'entrepreneur_name', 'entrepreneur_address'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['entrepreneur_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['entrepreneur_image'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jepg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entrepreneur_group_id' => 'กลุ่มผู้ประกอบการ',
            'entrepreneur_id' => 'entrepreneur ID',
            'entrepreneur_name' => 'ชื่อผู้ประกอบการ',
            'entrepreneur_address' => 'Address',
            'entrepreneur_image' => 'Image',
            'entrepreneur_telephone' => 'เบอร์โทรศัพท์',
            'entrepreneur_email' => 'อีเมล์',
            'entrepreneur_line' => 'Line',
            'entrepreneur_detail' => 'Detail',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'entrepreneur_latitude' => 'Latitude',
            'entrepreneur_longitude' => 'Longitude',
            'province_id' => 'Province ID',
            'amphur_id' => 'Amphur ID',
            'tambon_id' => 'Tambon ID',
        ];
    }

    public function getEntrepreneurGroup()
    {
        return $this->hasOne(EntrepreneurGroup::className(), ['entrepreneur_group_id' => 'entrepreneur_group_id']);
    }
}
