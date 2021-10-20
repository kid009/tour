<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Beststudy;

/**
 * KnowhowSearch represents the model behind the search form of `app\models\Knowhow`.
 */
class BeststudySearch extends Beststudy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['best_study_id', 'product_id'], 'integer'],
            [['best_study_name', 'best_study_vdo', 'best_study_facebook', 'best_study_line', 'best_study_detail', 'best_study_result', 'best_study_apply', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
        $query = Beststudy::find()->orderBy('update_date desc');
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
            'best_study_id' => $this->best_study_id,
            'product_id' => $this->product_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'best_study_name', $this->best_study_name])
            ->andFilterWhere(['ilike', 'best_study_vdo', $this->best_study_vdo])
            ->andFilterWhere(['ilike', 'best_study_facebook', $this->best_study_facebook])
            ->andFilterWhere(['ilike', 'best_study_line', $this->best_study_line])
            ->andFilterWhere(['ilike', 'best_study_detail', $this->best_study_detail])
            ->andFilterWhere(['ilike', 'best_study_result', $this->best_study_result])
            ->andFilterWhere(['ilike', 'best_study_apply', $this->best_study_apply])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
