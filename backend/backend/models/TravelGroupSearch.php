<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TravelGroup;
use yii\web\Session;
/**
 * TravelGroupSearch represents the model behind the search form of `app\models\TravelGroup`.
 */
class TravelGroupSearch extends TravelGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_group_id'], 'integer'],
            [['travel_group_name', 'travel_group_name_en', 'travel_group_detail', 'travel_group_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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

        // if ($session['user_login'] == 'admin') {
            $query = TravelGroup::find()->orderBy('update_date desc');
        // } 
        // else {
        //     $query = TravelGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'travel_group_id' => $this->travel_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'travel_group_name', $this->travel_group_name])
            ->andFilterWhere(['ilike', 'travel_group_name_en', $this->travel_group_name_en])
            ->andFilterWhere(['ilike', 'travel_group_detail', $this->travel_group_detail])
            ->andFilterWhere(['ilike', 'travel_group_detail_en', $this->travel_group_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
