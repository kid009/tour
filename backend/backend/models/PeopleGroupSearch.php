<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PeopleGroup;
use yii\web\Session;
/**
 * PeopleGroupSearch represents the model behind the search form of `app\models\PeopleGroup`.
 */
class PeopleGroupSearch extends PeopleGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['people_group_id'], 'integer'],
            [['people_group_name', 'people_group_detail', 'people_group_name_en', 'people_group_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = PeopleGroup::find()->orderBy('update_date desc');
        // } 
        // else {
        //     $query = PeopleGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'people_group_id' => $this->people_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'people_group_name', $this->people_group_name])
            ->andFilterWhere(['ilike', 'people_group_detail', $this->people_group_detail])
            ->andFilterWhere(['ilike', 'people_group_name_en', $this->people_group_name_en])
            ->andFilterWhere(['ilike', 'people_group_detail_en', $this->people_group_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
