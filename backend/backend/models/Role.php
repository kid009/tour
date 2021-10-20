<?php

namespace app\models;

use Yii;

class Role extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'bb_role';
    }

    public function rules()
    {
        return [
            [['role_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['role_name', 'create_by', 'update_by', 'redirect'], 'string', 'max' => 200],
            [['is_active'], 'string', 'max' => 1],
            [['role_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['role_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

}