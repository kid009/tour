<?php

namespace app\models;

use app\models\TourismExperience;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class TourismExperienceSearch extends TourismExperience
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_experience_id', 'tourism_experience_group_id'], 'integer'],
            [['tourism_experience_name', 'tourism_experience_name_en', 'tourism_experience_detail', 'tourism_experience_detail_en', 'tourism_experience_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $session = new Session();
        $session->open();

        if ($session['user_login'] == 'admin') {
            $query = TourismExperience::find()->orderBy('update_date desc');
        } else {
            $query = TourismExperience::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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

            'tourism_experience_id' => $this->tourism_experience_id,
            'tourism_experience_group_id' => $this->tourism_experience_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tourism_experience_name', $this->tourism_experience_name])
            ->andFilterWhere(['ilike', 'tourism_experience_name_en', $this->tourism_experience_name_en])
            ->andFilterWhere(['ilike', 'tourism_experience_detail', $this->tourism_experience_detail])
            ->andFilterWhere(['ilike', 'tourism_experience_detail_en', $this->tourism_experience_detail_en])
            ->andFilterWhere(['ilike', 'tourism_experience_image_cover', $this->tourism_experience_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
