<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserGroup;

/**
 * UserGroupSearch represents the model behind the search form of `app\models\UserGroup`.
 */
class UserGroupSearch extends UserGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_group_id', 'community_id'], 'integer'],
            [['user_group_name', 'user_group_detail', 'user_group_status', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = UserGroup::find()->orderBy('update_date desc');

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
            'user_group_id' => $this->user_group_id,
            'community_id' => $this->community_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'user_group_name', $this->user_group_name])
            ->andFilterWhere(['ilike', 'user_group_detail', $this->user_group_detail])
            ->andFilterWhere(['ilike', 'user_group_status', $this->user_group_status])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
