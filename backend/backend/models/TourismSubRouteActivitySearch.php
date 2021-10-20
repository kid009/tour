<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TourismSubRouteActivity;
use yii\web\Session;
/**
 * TourismSubRouteActivitySearch represents the model behind the search form of `app\models\TourismSubRouteActivity`.
 */
class TourismSubRouteActivitySearch extends TourismSubRouteActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_sub_route_id', 'tourism_sub_route_activity_id', 'activity_id', 'tourism_sub_route_activity_order', 'tourism_main_route_id'], 'integer'],
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
            $query = TourismSubRouteActivity::find()->orderBy('update_date desc');
        } 
        else {
            $query = TourismSubRouteActivity::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'tourism_sub_route_activity_id' => $this->tourism_sub_route_activity_id,
            'activity_id' => $this->activity_id,
            'tourism_sub_route_activity_order' => $this->tourism_sub_route_activity_order,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'tourism_main_route_id' => $this->tourism_main_route_id,
        ]);

        $query->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
