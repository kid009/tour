<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Community;
use yii\web\Session;
/**
 * CommunitySearch represents the model behind the search form of `app\models\Community`.
 */
class CommunitySearch extends Community
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'community_number_of_population', 'community_number_of_houses', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['community_latitude', 'community_longitude'], 'number'],
            [['community_name', 'community_image_cover', 'community_detail', 'community_career', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = Community::find()->orderBy('update_date desc');
        } 
        else {
            $query = Community::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'community_latitude' => $this->community_latitude,
            'community_longitude' => $this->community_longitude,
            'community_number_of_population' => $this->community_number_of_population,
            'community_number_of_houses' => $this->community_number_of_houses,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'tambon_id' => $this->tambon_id,
        ]);

        $query->andFilterWhere(['ilike', 'community_name', $this->community_name])
            ->andFilterWhere(['ilike', 'community_image_cover', $this->community_image_cover])
            ->andFilterWhere(['ilike', 'community_detail', $this->community_detail])
            ->andFilterWhere(['ilike', 'community_career', $this->community_career])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
