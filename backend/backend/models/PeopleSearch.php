<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\People;
use yii\web\Session;
/**
 * PeopleSearch represents the model behind the search form of `app\models\People`.
 */
class PeopleSearch extends People
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'people_group_id', 'people_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['people_name', 'people_address', 'people_image', 'people_telephone', 'people_email', 'people_line', 'people_education', 'people_detail', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['people_latitude', 'people_longitude'], 'number'],
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
            $query = People::find()->orderBy('update_date desc');
        } 
        else {
            $query = People::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'people_group_id' => $this->people_group_id,
            'people_id' => $this->people_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'people_latitude' => $this->people_latitude,
            'people_longitude' => $this->people_longitude,
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'tambon_id' => $this->tambon_id,
        ]);

        $query->andFilterWhere(['ilike', 'people_name', $this->people_name])
            ->andFilterWhere(['ilike', 'people_address', $this->people_address])
            ->andFilterWhere(['ilike', 'people_image', $this->people_image])
            ->andFilterWhere(['ilike', 'people_telephone', $this->people_telephone])
            ->andFilterWhere(['ilike', 'people_email', $this->people_email])
            ->andFilterWhere(['ilike', 'people_line', $this->people_line])
            ->andFilterWhere(['ilike', 'people_education', $this->people_education])
            ->andFilterWhere(['ilike', 'people_detail', $this->people_detail])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
