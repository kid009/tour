<?php

namespace app\models;

use app\models\ResearchKnowhowGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

class ResearchKnowhowGroupSearch extends ResearchKnowhowGroup
{
    public function rules()
    {
        return [
            [['researcher_knowhow_group_id'], 'integer'],
            [['researcher_knowhow_group_name', 'researcher_knowhow_group_name_en', 'researcher_knowhow_group_name_detail', 'researcher_experience_group_name_detail_en', 'researcher_experience_image_cover', 'create_by', 'crate_date', 'update_by', 'update_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        //$query = ResearchKnowhowGroup::find()->orderBy('update_date desc');

        $session = new Session();
        $session->open();

        // if($session['user_login'] == 'admin'){
            $query = ResearchKnowhowGroup::find()->orderBy('update_date desc');
        // }
        // else{
        //     $query = ResearchKnowhowGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
        // }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'researcher_knowhow_group_id' => $this->researcher_knowhow_group_id,
            'create_date' => $this->create_date, 
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'researcher_knowhow_group_name', $this->researcher_knowhow_group_name])
            ->andFilterWhere(['ilike', 'researcher_knowhow_group_name_en', $this->researcher_knowhow_group_name_en])
            ->andFilterWhere(['ilike', 'researcher_knowhow_group_name_detail', $this->researcher_knowhow_group_name_detail])
            ->andFilterWhere(['ilike', 'researcher_knowhow_group_name_detail_en', $this->researcher_knowhow_group_name_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
