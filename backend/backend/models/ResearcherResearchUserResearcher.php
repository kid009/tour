<?php

namespace app\models;

use Yii;

class ResearcherResearchUserResearcher extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_research_user_researcher';
    }

    public function rules()
    {
        return [
            [['user_researcher_id', 'researcher_research_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
        ];
    }

    public function getUserResearcher()
    {
        return $this->hasOne(UserResearcher::className(), ['user_researcher_id' => 'user_researcher_id']);
    }

    public function getResearcherResearch()
    {
        return $this->hasOne(ResearcherResearch::className(), ['researcher_research_id' => 'researcher_research_id']);
    }

}
