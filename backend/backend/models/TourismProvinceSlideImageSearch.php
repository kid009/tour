<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TourismProvinceSlideImage;

/**
 * TourismProvinceSlideImageSearch represents the model behind the search form of `app\models\TourismProvinceSlideImage`.
 */
class TourismProvinceSlideImageSearch extends TourismProvinceSlideImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_province_slide_image_id'], 'integer'],
            [['tourism_province_silde_image_name', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
        $query = TourismProvinceSlideImage::find()->orderBy('tourism_province_slide_order');

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
            'tourism_province_slide_image_id' => $this->tourism_province_slide_image_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tourism_province_silde_image_name', $this->tourism_province_silde_image_name])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
