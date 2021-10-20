<?php

namespace app\models;

use Yii;

class UserTourism extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bb_user_tourism';
    }

    public function rules()
    {
        return [
            [['user_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['user_tourism_name', 'user_tourism_address', 'user_tourism_telephone', 'user_tourism_email', 'user_tourism_line', 'user_tourism_facebook', 'user_tourism_instragram', 'create_by', 'update_by'], 'string', 'max' => 200],
            // [['user_login', 'user_password', 'user_email','is_active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            // [['user_login', 'user_email'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['user_tourism_image'], 'file',
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
