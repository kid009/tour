
<?php

namespace app\models;

use Yii;

class ResearcherResearchUserTourism extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'researcher_research_user_tourism';
    }

    public function rules()
    {
        return [
            [['user_tourism_id', 'researcher_research_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
        ];
    }

    public function getUserTourism()
    {
        return $this->hasOne(UserTourism::className(), ['user_tourism_id' => 'user_tourism_id']);
    }

    public function getResearcherResearch()
    {
        return $this->hasOne(ResearcherResearch::className(), ['researcher_research_id' => 'researcher_research_id']);
    }

}