<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KnowhowGroup;

/**
 * KnowhowGroupSearch represents the model behind the search form of `app\models\KnowhowGroup`.
 */
class FrontendvdoSearch extends KnowhowGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['knowhow_group_id'], 'integer'],
            //[['knowhow_group_name', 'knowhow_group_detail', 'knowhow_group_name_en', 'knowhow_group_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
        $query = Frontendvdo::find()->orderBy('update_date desc');

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
            //'knowhow_group_id' => $this->knowhow_group_id,
            //'create_date' => $this->create_date,
            //'update_date' => $this->update_date,
        ]);

//        $query->andFilterWhere(['ilike', 'knowhow_group_name', $this->knowhow_group_name])
//            ->andFilterWhere(['ilike', 'knowhow_group_detail', $this->knowhow_group_detail])
//            ->andFilterWhere(['ilike', 'knowhow_group_name_en', $this->knowhow_group_name_en])
//            ->andFilterWhere(['ilike', 'knowhow_group_detail_en', $this->knowhow_group_detail_en])
//            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
//            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
