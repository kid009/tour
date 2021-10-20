<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Homestay;
use yii\web\Session;
/**
 * HomestaySearch represents the model behind the search form of `app\models\Homestay`.
 */
class HomestaySearch extends Homestay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'homestay_id', 'homestay_occupancy_max', 'homestay_occupancy_min', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['homestay_name', 'homestay_owner_address', 'homestay_owner_name', 'homestay_owner_telephone', 'homestay_detail', 'homestay_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['homestay_latitude', 'homestay_longitude'], 'number'],
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
            $query = Homestay::find()->orderBy('update_date desc');
        } 
        else {
            $query = Homestay::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'homestay_id' => $this->homestay_id,
            'homestay_latitude' => $this->homestay_latitude,
            'homestay_longitude' => $this->homestay_longitude,
            'homestay_occupancy_max' => $this->homestay_occupancy_max,
            'homestay_occupancy_min' => $this->homestay_occupancy_min,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'tambon_id' => $this->tambon_id,
        ]);

        $query->andFilterWhere(['ilike', 'homestay_name', $this->homestay_name])
            ->andFilterWhere(['ilike', 'homestay_owner_address', $this->homestay_owner_address])
            ->andFilterWhere(['ilike', 'homestay_owner_name', $this->homestay_owner_name])
            ->andFilterWhere(['ilike', 'homestay_owner_telephone', $this->homestay_owner_telephone])
            ->andFilterWhere(['ilike', 'homestay_detail', $this->homestay_detail])
            ->andFilterWhere(['ilike', 'homestay_image_cover', $this->homestay_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
