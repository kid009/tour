<?php

namespace app\models;

use Yii;

class UserResearcher extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bb_user_researcher';
    }

    public function rules()
    {
        return [
            [['user_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_name', 'researcher_specialize', 'researcher_department', 'researcher_course', 'researcher_faculty', 'researcher_university', 'researcher_image', 'researcher_telephone', 'researcher_email', 'researcher_line', 'researcher_facebook', 'researcher_instragram', 'create_by', 'update_by', 'researcher_address'], 'string', 'max' => 200],
            // [['user_login', 'user_password', 'user_email','is_active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            // [['user_login', 'user_email'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['researcher_image'], 'file',
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
