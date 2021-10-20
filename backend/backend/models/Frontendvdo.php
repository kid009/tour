<?php

namespace app\models;

class Frontendvdo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'frontend_vdo';
    }

    public function rules()
    {
        return [                           
            [
                ['frontend_vdo_name', 'frontend_vdo_link','create_by', 'update_by'], 'string', 'max' => 200
            ],
            [
                ['frontend_vdo_order'], 'integer'
            ],
            [
                ['create_date', 'update_date'], 'safe'
            ],
        ];
    }

}