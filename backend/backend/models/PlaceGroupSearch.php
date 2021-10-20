<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlaceGroup;
use yii\web\Session;
/**
 * PlaceGroupSearch represents the model behind the search form of `app\models\PlaceGroup`.
 */
class PlaceGroupSearch extends PlaceGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_group_id'], 'integer'],
            [['place_group_name_en', 'place_group_name', 'place_group_detail', 'place_group_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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

        // if ($session['user_login'] == 'admin') {
            $query = PlaceGroup::find()->orderBy('update_date desc');
        // } 
        // else {
        //     $query = PlaceGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
        // } 

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
            'place_group_id' => $this->place_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'place_group_name_en', $this->place_group_name_en])
            ->andFilterWhere(['ilike', 'place_group_name', $this->place_group_name])
            ->andFilterWhere(['ilike', 'place_group_detail', $this->place_group_detail])
            ->andFilterWhere(['ilike', 'place_group_detail_en', $this->place_group_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
