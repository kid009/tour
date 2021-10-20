<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nature;
use yii\web\Session;
/**
 * NatureSearch represents the model behind the search form of `app\models\Nature`.
 */
class NatureSearch extends Nature
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nature_id', 'community_id', 'nature_group_id'], 'integer'],
            [['nature_name', 'nature_name_en', 'nature_caretaker', 'nature_telephone', 'nature_detail', 'nature_detail_en', 'nature_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['nature_latitude', 'nature_longitude'], 'number'],
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
            $query = Nature::find()->orderBy('update_date desc');
        } 
        else {
            $query = Nature::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'nature_id' => $this->nature_id,
            'community_id' => $this->community_id,
            'nature_group_id' => $this->nature_group_id,
            'nature_latitude' => $this->nature_latitude,
            'nature_longitude' => $this->nature_longitude,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'nature_name', $this->nature_name])
            ->andFilterWhere(['ilike', 'nature_name_en', $this->nature_name_en])
            ->andFilterWhere(['ilike', 'nature_caretaker', $this->nature_caretaker])
            ->andFilterWhere(['ilike', 'nature_telephone', $this->nature_telephone])
            ->andFilterWhere(['ilike', 'nature_detail', $this->nature_detail])
            ->andFilterWhere(['ilike', 'nature_detail_en', $this->nature_detail_en])
            ->andFilterWhere(['ilike', 'nature_image_cover', $this->nature_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
