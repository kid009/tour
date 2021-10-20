<?php

namespace app\models;

use app\models\BussinessProduct;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class BussinessProductSearch extends BussinessProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bussiness_product_id', 'bussiness_product_group_id'], 'integer'],
            [['bussiness_product_name', 'bussiness_product_name_en', 'bussiness_product_detail', 'bussiness_product_detail_en', 'bussiness_product_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = BussinessProduct::find()->orderBy('update_date desc');
        } else {
            $query = BussinessProduct::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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

            'bussiness_product_id' => $this->bussiness_product_id,
            'bussiness_product_group_id' => $this->bussiness_product_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'bussiness_product_name', $this->bussiness_product_name])
            ->andFilterWhere(['ilike', 'bussiness_product_name_en', $this->bussiness_product_name_en])
            ->andFilterWhere(['ilike', 'bussiness_product_detail', $this->bussiness_product_detail])
            ->andFilterWhere(['ilike', 'bussiness_product_detail_en', $this->bussiness_product_detail_en])
            ->andFilterWhere(['ilike', 'bussiness_product_image_cover', $this->bussiness_product_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
