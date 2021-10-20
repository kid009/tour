<?php

namespace app\models;

use Yii;

class ResearcherResearchCommunity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_research_community';
    }

    public function rules()
    {
        return [
            [['community_id', 'researcher_research_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
        ];
    }

    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }

    public function getResearcherResearch()
    {
        return $this->hasOne(ResearcherResearch::className(), ['researcher_research_id' => 'researcher_research_id']);
    }

}
