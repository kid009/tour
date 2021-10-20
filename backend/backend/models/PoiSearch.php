<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Poi;
use yii\web\Session;
/**
 * PoiSearch represents the model behind the search form of `app\models\Poi`.
 */
class PoiSearch extends Poi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'poi_group_id', 'poi_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['poi_name', 'poi_detail', 'poi_telephone', 'poi_website', 'poi_image_cover', 'create_by', 'create_date', 'update_by', 'update_date', 'poi_contanct_name'], 'safe'],
            [['poi_latitude', 'poi_longitude'], 'number'],
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
            $query = Poi::find()->orderBy('update_date desc');
        } 
        else {
            $query = Poi::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'community_id' => $this->community_id,
            'poi_group_id' => $this->poi_group_id,
            'poi_id' => $this->poi_id,
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'tambon_id' => $this->tambon_id,
            'poi_latitude' => $this->poi_latitude,
            'poi_longitude' => $this->poi_longitude,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'poi_name', $this->poi_name])
            ->andFilterWhere(['ilike', 'poi_detail', $this->poi_detail])
            ->andFilterWhere(['ilike', 'poi_telephone', $this->poi_telephone])
            ->andFilterWhere(['ilike', 'poi_website', $this->poi_website])
            ->andFilterWhere(['ilike', 'poi_image_cover', $this->poi_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by])
            ->andFilterWhere(['ilike', 'poi_contanct_name', $this->poi_contanct_name]);

        return $dataProvider;
    }
}
