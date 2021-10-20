<?php

namespace app\models;

use app\models\Bussiness;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

class BussinessSearch extends Bussiness
{
    public function rules()
    {
        return [
            [['bussiness_id', 'bussiness_group_id'], 'integer'],
            [['bussiness_name', 'bussiness_name_en', 'bussiness_detail', 'bussiness_detail_en', 'create_by', 'crate_date', 'update_by', 'update_date' ,'bussiness_history', 'bussiness_image_cover', 'bussiness_vdo', 'bussiness_link'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $session = new Session();
        $session->open();

        if ($session['user_login'] == 'admin') {
            $query = Bussiness::find()->orderBy('update_date desc');
        } else {
            $query = Bussiness::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'bussiness_id' => $this->bussiness_id,
            'bussiness_group_id' => $this->bussiness_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'bussiness_name', $this->bussiness_name])
            ->andFilterWhere(['ilike', 'bussiness_name_en', $this->bussiness_name_en])
            ->andFilterWhere(['ilike', 'bussiness_detail', $this->bussiness_detail])
            ->andFilterWhere(['ilike', 'bussiness_detail_en', $this->bussiness_detail_en])
            ->andFilterWhere(['ilike', 'bussiness_history', $this->bussiness_history])
            ->andFilterWhere(['ilike', 'bussiness_image_cover', $this->bussiness_image_cover])
            ->andFilterWhere(['ilike', 'bussiness_vdo', $this->bussiness_vdo])
            ->andFilterWhere(['ilike', 'bussiness_link', $this->bussiness_link])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
