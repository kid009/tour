<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operation;

class OperationSerach extends Operation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operation_id', 'operation_no', 'parent_id', 'display_order'], 'integer'],
            [['operation_name_th', 'operation_name_en', 'operation_url', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
        $query = Operation::find()->orderBy('display_order asc');

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
            'operation_id' => $this->operation_id,
            'operation_no' => $this->operation_no,
            'parent_id' => $this->parent_id,
            'display_order' => $this->display_order,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'operation_name_th', $this->operation_name_th])
            ->andFilterWhere(['ilike', 'operation_name_en', $this->operation_name_en])
            ->andFilterWhere(['ilike', 'operation_url', $this->operation_url])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
