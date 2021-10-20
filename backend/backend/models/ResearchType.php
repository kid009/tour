<?php

namespace app\models;

use Yii;

class ResearchType extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_type';
    }

    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['research_type_name', 'research_type_detail', 'create_by', 'update_by'], 'string', 'max' => 200],
        ];
    }

}
