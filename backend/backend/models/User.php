<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bb_user';
    }

    public function rules()
    {
        return [
            [['province_id', 'amphur_id', 'tambon_id', 'user_age'], 'integer'],
            [['province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['create_date', 'update_date'], 'safe'],
            [
                [
                    'user_login'
                    , 'user_password'
                    , 'user_email'
                    , 'create_by'
                    , 'update_by'
                    , 'is_active'
                    , 'user_name'
                    , 'user_surname'
                    , 'user_telephone'
                    , 'user_address'
                    , 'user_line'
                    , 'user_facebook'
                    , 'user_instragram'
                    , 'user_specialize'
                    , 'user_department'
                    , 'user_course'
                    , 'user_faculty'
                    , 'user_university'
                    , 'user_sex'
                    , 'user_education'
                    , 'user_revenue'
                ]
                , 'string', 'max' => 200
            ],
            //[['user_login', 'user_password', ,'is_active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['user_email'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [['user_email'], 'email', 'message' => '**รูปแบบอีเมล์ไม่ถูกต้อง**'],
            [
                ['user_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['user_image_background_cover'], 'file',
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
            // 'user_id' => 'user_id',
            // 'user_login' => 'user_login',
            // 'user_password' => 'user_password',
            // 'user_email' => 'user_email',
        ];
    }

}
