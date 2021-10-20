<?php

namespace app\models;

use app\models\BussinessProductCommunity;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

class BussinessProductCommunitySearch extends BussinessProductCommunity
{
    public function rules()
    {
        return [
            [['bussiness_product_community_group_id', 'bussiness_product_community_id', 'community_id'], 'integer'],
            [['bussiness_product_community_name', 'bussiness_product_community_name_en', 'bussiness_product_community_detail', 'bussiness_product_community_detail_en', 'create_by', 'crate_date', 'update_by', 'update_date' ,'bussiness_product_community_story', 'bussiness_product_community_image_cover', 'bussiness_product_community_vdo', 'bussiness_product_community_link'], 'safe'],
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
            $query = BussinessProductCommunity::find()->orderBy('update_date desc');
        } else {
            $query = BussinessProductCommunity::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'bussiness_product_community_id' => $this->bussiness_product_community_id,
            'bussiness_product_community_group_id' => $this->bussiness_product_community_group_id,
            'community_id' => $this->community_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'bussiness_product_community_name', $this->bussiness_product_community_name])
            ->andFilterWhere(['ilike', 'bussiness_product_community_name_en', $this->bussiness_product_community_name_en])
            ->andFilterWhere(['ilike', 'bussiness_product_community_detail', $this->bussiness_product_community_detail])
            ->andFilterWhere(['ilike', 'bussiness_product_community_detail_en', $this->bussiness_product_community_detail_en])
            ->andFilterWhere(['ilike', 'bussiness_product_community_story', $this->bussiness_product_community_story])
            ->andFilterWhere(['ilike', 'bussiness_product_community_image_cover', $this->bussiness_product_community_image_cover])
            ->andFilterWhere(['ilike', 'bussiness_product_community_vdo', $this->bussiness_product_community_vdo])
            ->andFilterWhere(['ilike', 'bussiness_product_community_link', $this->bussiness_product_community_link])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
