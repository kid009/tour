<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;
use yii\web\Session;
/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_group_id', 'product_id', 'product_price', 'product_stock_total', 'special_group_id', 'community_id'], 'integer'],
            [['product_name', 'product_detail', 'product_image_cover', 'product_code', 'product_unit', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = Product::find()->orderBy('update_date desc');
        } 
        else {
            $query = Product::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'product_group_id' => $this->product_group_id,
            'product_id' => $this->product_id,
            'product_price' => $this->product_price,
            'product_stock_total' => $this->product_stock_total,
            'special_group_id' => $this->special_group_id,
            'community_id' => $this->community_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'product_name', $this->product_name])
            ->andFilterWhere(['ilike', 'product_detail', $this->product_detail])
            ->andFilterWhere(['ilike', 'product_image_cover', $this->product_image_cover])
            ->andFilterWhere(['ilike', 'product_code', $this->product_code])
            ->andFilterWhere(['ilike', 'product_unit', $this->product_unit])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
