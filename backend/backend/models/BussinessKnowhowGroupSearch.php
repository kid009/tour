<?php

namespace app\models;

use app\models\BussinessKnowhowGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

class BussinessKnowhowGroupSearch extends BussinessKnowhowGroup
{
    public function rules()
    {
        return [
            [['bussiness_knowhow_group_id'], 'integer'],
            [['bussiness_knowhow_group_name', 'bussiness_knowhow_group_name_en', 'bussiness_knowhow_group_name_detail', 'bussiness_experience_group_name_detail_en', 'bussiness_experience_image_cover', 'create_by', 'crate_date', 'update_by', 'update_date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        //$query = BussinessKnowhowGroup::find()->orderBy('update_date desc');

        $session = new Session();
        $session->open();

        // if ($session['user_login'] == 'admin') {
            $query = BussinessKnowhowGroup::find()->orderBy('update_date desc');
        // } else {
        //     $query = BussinessKnowhowGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'bussiness_knowhow_group_id' => $this->bussiness_knowhow_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'bussiness_knowhow_group_name', $this->bussiness_knowhow_group_name])
            ->andFilterWhere(['ilike', 'bussiness_knowhow_group_name_en', $this->bussiness_knowhow_group_name_en])
            ->andFilterWhere(['ilike', 'bussiness_knowhow_group_name_detail', $this->bussiness_knowhow_group_name_detail])
            ->andFilterWhere(['ilike', 'bussiness_knowhow_group_name_detail_en', $this->bussiness_knowhow_group_name_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
