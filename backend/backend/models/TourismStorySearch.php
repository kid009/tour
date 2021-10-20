<?php

namespace app\models;

use app\models\TourismStory;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

class TourismStorySearch extends TourismStory
{
    public function rules()
    {
        return [
            [['tourism_story_id', 'tourism_story_group_id'], 'integer'],
            [['tourism_story_name', 'tourism_story_name_en', 'tourism_story_detail', 'tourism_story_detail_en', 'create_by', 'crate_date', 'update_by', 'update_date' , 'tourism_story_image_cover', 'tourism_story_vdo', 'tourism_story_link', 'is_active'], 'safe'],
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

        if ($session['user_login'] == 'admin') {
            $query = TourismStory::find()->orderBy('update_date desc');
        } else {
            $query = TourismStory::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
        }

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
            'tourism_story_id' => $this->tourism_story_id,
            'tourism_story_group_id' => $this->tourism_story_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tourism_story_name', $this->tourism_story_name])
            ->andFilterWhere(['ilike', 'tourism_story_name_en', $this->tourism_story_name_en])
            ->andFilterWhere(['ilike', 'tourism_story_detail', $this->tourism_story_detail])
            ->andFilterWhere(['ilike', 'tourism_story_detail_en', $this->tourism_story_detail_en])
            ->andFilterWhere(['ilike', 'is_active', $this->is_active])
            ->andFilterWhere(['ilike', 'tourism_story_image_cover', $this->tourism_story_image_cover])
            ->andFilterWhere(['ilike', 'tourism_story_vdo', $this->tourism_story_vdo])
            ->andFilterWhere(['ilike', 'tourism_story_link', $this->tourism_story_link])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
