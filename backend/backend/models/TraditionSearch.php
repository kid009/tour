<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tradition;
use yii\web\Session;
/**
 * TraditionSearch represents the model behind the search form of `app\models\Tradition`.
 */
class TraditionSearch extends Tradition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'tradition_id', 'global_tradition_id'], 'integer'],
            [['tradition_name', 'tradition_detail', 'tradition_image_cover', 'tradition_start_date', 'tradition_end_date', 'tradition_name_en', 'tradition_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = Tradition::find()->orderBy('update_date desc');
        } 
        else {
            $query = Tradition::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'tradition_id' => $this->tradition_id,
            'tradition_start_date' => $this->tradition_start_date,
            'tradition_end_date' => $this->tradition_end_date,
            'global_tradition_id' => $this->global_tradition_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tradition_name', $this->tradition_name])
            ->andFilterWhere(['ilike', 'tradition_detail', $this->tradition_detail])
            ->andFilterWhere(['ilike', 'tradition_image_cover', $this->tradition_image_cover])
            ->andFilterWhere(['ilike', 'tradition_name_en', $this->tradition_name_en])
            ->andFilterWhere(['ilike', 'tradition_detail_en', $this->tradition_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
