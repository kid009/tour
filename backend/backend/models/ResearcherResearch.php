<?php

namespace app\models;

use Yii;

class ResearcherResearch extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_research';
    }

    public function rules()
    {
        return [
            [['research_budget'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['research_name', 'create_by', 'update_by', 'research_code', 'research_user_bussiness_id','research_user_community_id', 'research_user_research_id', 'research_user_tourism_id'], 'string', 'max' => 200],
            [['research_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            //[['research_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'researcher_research_id' => 'researcher_research_id',
            'research_name' => 'research_name',
            'research_budget' => 'research_budget',
         ];
    }

}
