<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Travel;
use yii\web\Session;
/**
 * TravelSearch represents the model behind the search form of `app\models\Travel`.
 */
class TravelSearch extends Travel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'travel_id', 'travel_group_id'], 'integer'],
            [['travel_contact', 'travel_telephone', 'create_by', 'create_date', 'update_by', 'update_date', 'travel_image_map', 'travel_detail'], 'safe'],
            [['travel_latitude', 'travel_longitude'], 'number'],
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
            $query = Travel::find()->orderBy('update_date desc');
        } 
        else {
            $query = Travel::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'community_id' => $this->community_id,
            'travel_id' => $this->travel_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'travel_group_id' => $this->travel_group_id,
            'travel_latitude' => $this->travel_latitude,
            'travel_longitude' => $this->travel_longitude,
        ]);

        $query->andFilterWhere(['ilike', 'travel_contact', $this->travel_contact])
            ->andFilterWhere(['ilike', 'travel_telephone', $this->travel_telephone])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by])
            ->andFilterWhere(['ilike', 'travel_image_map', $this->travel_image_map])
            ->andFilterWhere(['ilike', 'travel_detail', $this->travel_detail]);

        return $dataProvider;
    }
}
