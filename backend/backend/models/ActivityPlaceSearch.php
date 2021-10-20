<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivityPlace;
use yii\web\Session;
/**
 * ActivityPlaceSearch represents the model behind the search form of `app\models\ActivityPlace`.
 */
class ActivityPlaceSearch extends ActivityPlace
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_place_id', 'activity_id', 'place_id'], 'integer'],
            [['create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = ActivityPlace::find()->orderBy('update_date desc');
        } 
        else {
            $query = ActivityPlace::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'activity_place_id' => $this->activity_place_id,
            'activity_id' => $this->activity_id,
            'place_id' => $this->place_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
