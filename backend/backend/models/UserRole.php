<?php

namespace app\models;

use Yii;

class UserRole extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bb_user_role';
    }

    public function rules()
    {
        return [
            [['user_id', 'role_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200
            ],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    public function getRole()
    {
        return $this->hasOne(Role::className(), ['role_id' => 'role_id']);
    }

}
