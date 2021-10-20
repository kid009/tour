<?php

namespace app\models;

use Yii;

class UserBussiness extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bb_user_bussiness';
    }

    public function rules()
    {
        return [
            [['user_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['user_bussiness_name', 'user_bussiness_address', 'user_bussiness_telephone', 'user_bussiness_email', 'user_bussiness_line', 'user_bussiness_facebook', 'user_bussiness_instragram', 'create_by', 'update_by'], 'string', 'max' => 200],
            // [['user_login', 'user_password', 'user_email','is_active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            // [['user_login', 'user_email'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['user_bussiness_image'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jepg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            // 'user_id' => 'user_id',
            // 'user_login' => 'user_login',
            // 'user_password' => 'user_password',
            // 'user_email' => 'user_email',
        ];
    }

}
