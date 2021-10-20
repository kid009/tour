<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TourismProvince;
use yii\web\Session;
/**
 * TourismProvinceSearch represents the model behind the search form of `app\models\TourismProvince`.
 */
class TourismProvinceSearch extends TourismProvince
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_province_id', 'province_id'], 'integer'],
            [['tourism_province_name', 'tourism_province_name_en', 'tourism_province_detail', 'tourism_province_detail_en', 'tourism_province_image_1', 'tourism_province_image_2', 'tourism_province_image_3', 'tourism_province_info', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = TourismProvince::find()->orderBy('update_date desc');
        } 
        else {
            $query = TourismProvince::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'tourism_province_id' => $this->tourism_province_id,
            'province_id' => $this->province_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tourism_province_name', $this->tourism_province_name])
            ->andFilterWhere(['ilike', 'tourism_province_name_en', $this->tourism_province_name_en])
            ->andFilterWhere(['ilike', 'tourism_province_detail', $this->tourism_province_detail])
            ->andFilterWhere(['ilike', 'tourism_province_detail_en', $this->tourism_province_detail_en])
            ->andFilterWhere(['ilike', 'tourism_province_image_1', $this->tourism_province_image_1])
            ->andFilterWhere(['ilike', 'tourism_province_image_2', $this->tourism_province_image_2])
            ->andFilterWhere(['ilike', 'tourism_province_image_3', $this->tourism_province_image_3])
            ->andFilterWhere(['ilike', 'tourism_province_info', $this->tourism_province_info])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
