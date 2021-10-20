<?php

namespace app\models;

use app\models\BussinessKnowhow;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class BussinessKnowhowSearch extends BussinessKnowhow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bussiness_knowhow_id', 'bussiness_knowhow_group_id'], 'integer'],
            [['bussiness_knowhow_name', 'bussiness_knowhow_name_en', 'bussiness_knowhow_detail', 'bussiness_knowhow_detail_en', 'bussiness_knowhow_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = BussinessKnowhow::find()->orderBy('update_date desc');
        } else {
            $query = BussinessKnowhow::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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

            'bussiness_knowhow_id' => $this->bussiness_knowhow_id,
            'bussiness_knowhow_group_id' => $this->bussiness_knowhow_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'bussiness_knowhow_name', $this->bussiness_knowhow_name])
            ->andFilterWhere(['ilike', 'bussiness_knowhow_name_en', $this->bussiness_knowhow_name_en])
            ->andFilterWhere(['ilike', 'bussiness_knowhow_detail', $this->bussiness_knowhow_detail])
            ->andFilterWhere(['ilike', 'bussiness_knowhow_detail_en', $this->bussiness_knowhow_detail_en])
            ->andFilterWhere(['ilike', 'bussiness_knowhow_image_cover', $this->bussiness_knowhow_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
