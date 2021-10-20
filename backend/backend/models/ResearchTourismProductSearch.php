<?php

namespace app\models;

use app\models\ResearchTourismProduct;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

class ResearchTourismProductSearch extends ResearchTourismProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['researcher_tourism_product_id', 'researcher_tourism_product_group_id'], 'integer'],
            [['researcher_tourism_product_name', 'researcher_tourism_product_name_en', 'researcher_tourism_product_detail', 'researcher_tourism_product_detail_en', 'researcher_tourism_product_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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

        if($session['user_login'] == 'admin'){
            $query = ResearchTourismProduct::find()->orderBy('update_date desc');
        }
        else{
            $query = ResearchTourismProduct::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
        }

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

            'researcher_tourism_product_id' => $this->researcher_tourism_product_id,
            'researcher_tourism_product_group_id' => $this->researcher_tourism_product_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'researcher_tourism_product_name', $this->researcher_tourism_product_name])
            ->andFilterWhere(['ilike', 'researcher_tourism_product_name_en', $this->researcher_tourism_product_name_en])
            ->andFilterWhere(['ilike', 'researcher_tourism_product_detail', $this->researcher_tourism_product_detail])
            ->andFilterWhere(['ilike', 'researcher_tourism_product_detail_en', $this->researcher_tourism_product_detail_en])
            ->andFilterWhere(['ilike', 'researcher_tourism_product_image_cover', $this->researcher_tourism_product_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
