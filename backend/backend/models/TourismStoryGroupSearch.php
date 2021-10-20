<?php

namespace app\models;

use yii\web\Session;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TourismStoryGroup;

class TourismStoryGroupSearch extends TourismStoryGroup
{
    public function rules()
    {
        return [
            [['tourism_story_group_id'], 'integer'],
            [['tourism_story_group_name', 'tourism_story_group_name_en', 'tourism_story_group_name_detail', 'tourism_story_group_name_detail_en', 'create_date', 'update_by', 'update_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $session = new Session();
        $session->open();

        // if ($session['user_login'] == 'admin') {
            $query = TourismStoryGroup::find()->orderBy('update_date desc');
        // } else {
        //     $query = TourismStoryGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'tourism_story_group_id' => $this->tourism_story_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tourism_story_group_name', $this->tourism_story_group_name])
            ->andFilterWhere(['ilike', 'tourism_story_group_name_en', $this->tourism_story_group_name_en])
            ->andFilterWhere(['ilike', 'tourism_story_group_name_detail', $this->tourism_story_group_name_detail])
            ->andFilterWhere(['ilike', 'tourism_story_group_name_detail_en', $this->tourism_story_group_name_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
