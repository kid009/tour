<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activity;
use yii\web\Session;
/**
 * ActivitySearch represents the model behind the search form of `app\models\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_group_id', 'community_id', 'activity_id', 'activity_duration', 'activity_participant_min', 'activity_participant_max'], 'integer'],
            [['activity_name', 'activity_detail', 'activity_image_cover', 'activity_participant_age', 'activity_period', 'activity_duration_text', 'activity_name_en', 'activity_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['activity_latitude', 'activity_longitude', 'activity_price'], 'number'],
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

    /** [ ['INNER JOIN', 'user', 'user.id = author_id'], ['LEFT JOIN', 'team', 'team.id = team_id'], ]
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
            $query = Activity::find()->orderBy('update_date desc');
        } else {
            $query = Activity::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'activity_group_id' => $this->activity_group_id,
            'community_id' => $this->community_id,
            'activity_id' => $this->activity_id,
            'activity_latitude' => $this->activity_latitude,
            'activity_longitude' => $this->activity_longitude,
            'activity_price' => $this->activity_price,
            'activity_duration' => $this->activity_duration,
            'activity_participant_min' => $this->activity_participant_min,
            'activity_participant_max' => $this->activity_participant_max,
            //'create_date' => $this->create_date,
            //'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'activity_name', $this->activity_name])
            ->andFilterWhere(['ilike', 'activity_detail', $this->activity_detail])
            ->andFilterWhere(['ilike', 'activity_image_cover', $this->activity_image_cover])
            ->andFilterWhere(['ilike', 'activity_participant_age', $this->activity_participant_age])
            ->andFilterWhere(['ilike', 'activity_period', $this->activity_period])
            ->andFilterWhere(['ilike', 'activity_duration_text', $this->activity_duration_text])
            ->andFilterWhere(['ilike', 'activity_name_en', $this->activity_name_en])
            ->andFilterWhere(['ilike', 'activity_detail_en', $this->activity_detail_en]);
            //->andFilterWhere(['ilike', 'create_by', $this->create_by])
            //->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
