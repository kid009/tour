<?php

namespace app\models;

use Yii;

class Operation extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'bb_operation';
    }

    public function rules()
    {
        return [
            [['parent_id', 'display_order', 'operation_no', 'level'], 'default', 'value' => null],
            [['parent_id', 'display_order', 'operation_no', 'level'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['operation_name_th', 'operation_name_en', 'operation_url','create_by', 'update_by'], 'string', 'max' => 200],
            [['is_active'], 'string', 'max' => 1],
            [['operation_name_th', 'operation_url','parent_id', 'display_order'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['operation_name_th', ], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

}