<?php

namespace app\models;

use Yii;

class ResearcherResearchUserBussiness extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_research_user_bussiness';
    }

    public function rules()
    {
        return [
            [['user_bussiness_id', 'researcher_research_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
        ];
    }

    public function getUserBussiness()
    {
        return $this->hasOne(UserBussiness::className(), ['user_bussiness_id' => 'user_bussiness_id']);
    }

    public function getResearcherResearch()
    {
        return $this->hasOne(ResearcherResearch::className(), ['researcher_research_id' => 'researcher_research_id']);
    }

}
