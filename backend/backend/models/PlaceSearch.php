<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Place;
use yii\web\Session;
/**
 * PlaceSearch represents the model behind the search form of `app\models\Place`.
 */
class PlaceSearch extends Place
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'place_group_id', 'community_id'], 'integer'],
            [['place_name', 'place_telephone', 'place_detail', 'place_image_cover', 'place_contact_person', 'place_name_en', 'place_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['place_latitude', 'place_longitude'], 'number'],
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
            $query = Place::find()->orderBy('update_date desc');
        } 
        else {
            $query = Place::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'place_id' => $this->place_id,
            'place_latitude' => $this->place_latitude,
            'place_longitude' => $this->place_longitude,
            'place_group_id' => $this->place_group_id,
            'community_id' => $this->community_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'place_name', $this->place_name])
            ->andFilterWhere(['ilike', 'place_telephone', $this->place_telephone])
            ->andFilterWhere(['ilike', 'place_detail', $this->place_detail])
            ->andFilterWhere(['ilike', 'place_image_cover', $this->place_image_cover])
            ->andFilterWhere(['ilike', 'place_contact_person', $this->place_contact_person])
            ->andFilterWhere(['ilike', 'place_name_en', $this->place_name_en])
            ->andFilterWhere(['ilike', 'place_detail_en', $this->place_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
