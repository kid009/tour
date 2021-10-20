<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GlobalTradition;
use yii\web\Session;
/**
 * GlobalTraditionSearch represents the model behind the search form of `app\models\GlobalTradition`.
 */
class GlobalTraditionSearch extends GlobalTradition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['global_tradition_id'], 'integer'],
            [['global_tradition_name', 'global_tradition_name_en', 'global_tradition_detail', 'global_tradition_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = GlobalTradition::find()->orderBy('update_date desc');
        // } 
        // else {
        //     $query = GlobalTradition::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'global_tradition_id' => $this->global_tradition_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'global_tradition_name', $this->global_tradition_name])
            ->andFilterWhere(['ilike', 'global_tradition_name_en', $this->global_tradition_name_en])
            ->andFilterWhere(['ilike', 'global_tradition_detail', $this->global_tradition_detail])
            ->andFilterWhere(['ilike', 'global_tradition_detail_en', $this->global_tradition_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
