<?php

namespace app\models;

use app\models\BussinessService;
use app\models\BussinessServiceSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class BussinessServiceSearch extends BussinessService
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bussiness_service_id', 'bussiness_service_group_id'], 'integer'],
            [['bussiness_service_name', 'bussiness_service_name_en', 'bussiness_service_detail', 'bussiness_service_detail_en', 'bussiness_service_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = BussinessService::find()->orderBy('update_date desc');
        } else {
            $query = BussinessService::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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

            'bussiness_service_id' => $this->bussiness_service_id,
            'bussiness_service_group_id' => $this->bussiness_service_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'bussiness_service_name', $this->bussiness_service_name])
            ->andFilterWhere(['ilike', 'bussiness_service_name_en', $this->bussiness_service_name_en])
            ->andFilterWhere(['ilike', 'bussiness_service_detail', $this->bussiness_service_detail])
            ->andFilterWhere(['ilike', 'bussiness_service_detail_en', $this->bussiness_service_detail_en])
            ->andFilterWhere(['ilike', 'bussiness_service_image_cover', $this->bussiness_service_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
