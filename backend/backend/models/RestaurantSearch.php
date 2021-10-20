<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Restaurant;
use yii\web\Session;
/**
 * RestaurantSearch represents the model behind the search form of `app\models\Restaurant`.
 */
class RestaurantSearch extends Restaurant
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restaurant_name', 'restaurant_detail', 'restaurant_telephone', 'restaurant_www', 'restaurant_price_range', 'restaurant_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['restaurant_latitude', 'restaurant_longitude'], 'number'],
            [['restaurant_id', 'community_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
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
            $query = Restaurant::find()->orderBy('update_date desc');
        } 
        else {
            $query = Restaurant::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'restaurant_latitude' => $this->restaurant_latitude,
            'restaurant_longitude' => $this->restaurant_longitude,
            'restaurant_id' => $this->restaurant_id,
            'community_id' => $this->community_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'tambon_id' => $this->tambon_id,
        ]);

        $query->andFilterWhere(['ilike', 'restaurant_name', $this->restaurant_name])
            ->andFilterWhere(['ilike', 'restaurant_detail', $this->restaurant_detail])
            ->andFilterWhere(['ilike', 'restaurant_telephone', $this->restaurant_telephone])
            ->andFilterWhere(['ilike', 'restaurant_www', $this->restaurant_www])
            ->andFilterWhere(['ilike', 'restaurant_price_range', $this->restaurant_price_range])
            ->andFilterWhere(['ilike', 'restaurant_image_cover', $this->restaurant_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
