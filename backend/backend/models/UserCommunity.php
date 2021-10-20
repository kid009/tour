<?php

namespace app\models;

use Yii;

class UserCommunity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bb_user_commuity';
    }

    public function rules()
    {
        return [
            [['user_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['user_commuity_name', 'user_commuity_address', 'user_commuity_telephone', 'user_commuity_email', 'user_commuity_line', 'user_commuity_facebook', 'user_commuity_instragram', 'create_by', 'update_by', 'surname'], 'string', 'max' => 200],
            // [['user_login', 'user_password', 'user_email','is_active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            // [['user_login', 'user_email'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['user_commuity_image'], 'file',
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
