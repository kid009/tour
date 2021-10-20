<?php

namespace app\models;

use Yii;

class RoleOperation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bb_role_operation';
    }

    public function rules()
    {
        return [
            [['role_id', 'operation_id'], 'default', 'value' => null],
            [['role_id', 'operation_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['is_view'], 'string', 'max' => 1],
        ];
    }

}
