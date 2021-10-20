<?php

namespace app\models;

use app\models\ResearchKnowhow;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;
/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class ResearchKnowhowSearch extends ResearchKnowhow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['researcher_knowhow_id', 'researcher_knowhow_group_id'], 'integer'],
            [['researcher_knowhow_name', 'researcher_knowhow_name_en', 'researcher_knowhow_detail', 'researcher_knowhow_detail_en', 'researcher_knowhow_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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

        if($session['user_login'] == 'admin'){
            $query = ResearchKnowhow::find()->orderBy('update_date desc');
        }
        else{
            $query = ResearchKnowhow::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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

            'researcher_knowhow_id' => $this->researcher_knowhow_id,
            'researcher_knowhow_group_id' => $this->researcher_knowhow_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'researcher_knowhow_name', $this->researcher_knowhow_name])
            ->andFilterWhere(['ilike', 'researcher_knowhow_name_en', $this->researcher_knowhow_name_en])
            ->andFilterWhere(['ilike', 'researcher_knowhow_detail', $this->researcher_knowhow_detail])
            ->andFilterWhere(['ilike', 'researcher_knowhow_detail_en', $this->researcher_knowhow_detail_en])
            ->andFilterWhere(['ilike', 'researcher_knowhow_image_cover', $this->researcher_knowhow_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
