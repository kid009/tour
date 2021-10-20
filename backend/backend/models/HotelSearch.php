<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hotel;
use yii\web\Session;
/**
 * HotelSearch represents the model behind the search form of `app\models\Hotel`.
 */
class HotelSearch extends Hotel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'community_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['hotel_name', 'hotel_detail', 'hotel_telephone', 'hotel_www', 'hotel_email', 'hotel_image_cover', 'hotel_mobile', 'hotel_rate', 'hotel_room_detail', 'hotel_address', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['hotel_latitude', 'hotel_longitude', 'hotel_room_price_min', 'hotel_room_price_max'], 'number'],
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
            $query = Hotel::find()->orderBy('update_date desc');
        } 
        else {
            $query = Hotel::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'hotel_id' => $this->hotel_id,
            'hotel_latitude' => $this->hotel_latitude,
            'hotel_longitude' => $this->hotel_longitude,
            'hotel_room_price_min' => $this->hotel_room_price_min,
            'community_id' => $this->community_id,
            'hotel_room_price_max' => $this->hotel_room_price_max,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'tambon_id' => $this->tambon_id,
        ]);

        $query->andFilterWhere(['ilike', 'hotel_name', $this->hotel_name])
            ->andFilterWhere(['ilike', 'hotel_detail', $this->hotel_detail])
            ->andFilterWhere(['ilike', 'hotel_telephone', $this->hotel_telephone])
            ->andFilterWhere(['ilike', 'hotel_www', $this->hotel_www])
            ->andFilterWhere(['ilike', 'hotel_email', $this->hotel_email])
            ->andFilterWhere(['ilike', 'hotel_image_cover', $this->hotel_image_cover])
            ->andFilterWhere(['ilike', 'hotel_mobile', $this->hotel_mobile])
            ->andFilterWhere(['ilike', 'hotel_rate', $this->hotel_rate])
            ->andFilterWhere(['ilike', 'hotel_room_detail', $this->hotel_room_detail])
            ->andFilterWhere(['ilike', 'hotel_address', $this->hotel_address])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
