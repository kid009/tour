<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TourismSubRoute;
use yii\web\Session;
/**
 * TourismSubRouteSearch represents the model behind the search form of `app\models\TourismSubRoute`.
 */
class TourismSubRouteSearch extends TourismSubRoute
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_sub_route_id', 'tourism_main_route_id', 'tourism_sub_route_order'], 'integer'],
            [['tourism_sub_route_name', 'tourism_sub_route_detail', 'tourism_sub_route_name_en', 'tourism_sub_route_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = TourismSubRoute::find()->orderBy('update_date desc');
        } 
        else {
            $query = TourismSubRoute::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'tourism_sub_route_id' => $this->tourism_sub_route_id,
            'tourism_main_route_id' => $this->tourism_main_route_id,
            'tourism_sub_route_order' => $this->tourism_sub_route_order,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tourism_sub_route_name', $this->tourism_sub_route_name])
            ->andFilterWhere(['ilike', 'tourism_sub_route_detail', $this->tourism_sub_route_detail])
            ->andFilterWhere(['ilike', 'tourism_sub_route_name_en', $this->tourism_sub_route_name_en])
            ->andFilterWhere(['ilike', 'tourism_sub_route_detail_en', $this->tourism_sub_route_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
