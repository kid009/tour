<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EntrepreneurGroup;

class EntrepreneurGroupSearch extends EntrepreneurGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entrepreneur_group_id'], 'integer'],
            [['entrepreneur_group_name', 'entrepreneur_group_detail', 'entrepreneur_group_name_en', 'entrepreneur_group_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
        $query = EntrepreneurGroup::find()->orderBy('update_date desc');

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
            'entrepreneur_group_id' => $this->entrepreneur_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'entrepreneur_group_name', $this->entrepreneur_group_name])
            ->andFilterWhere(['ilike', 'entrepreneur_group_detail', $this->entrepreneur_group_detail])
            ->andFilterWhere(['ilike', 'entrepreneur_group_name_en', $this->entrepreneur_group_name_en])
            ->andFilterWhere(['ilike', 'entrepreneur_group_detail_en', $this->entrepreneur_group_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}