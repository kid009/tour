<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ResearchTechnology;
use yii\web\Session;
/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class ResearchTechnologySearch extends ResearchTechnology
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['researcher_technology_id','researcher_technology_group_id' ], 'integer'],
            [['researcher_technology_name', 'researcher_technology_name_en', 'researcher_technology_detail', 'researcher_technology_detail_en', 'researcher_technology_image_cover', 'researcher_technology_vdo', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = ResearchTechnology::find()->orderBy('update_date desc');
        }
        else{
            $query = ResearchTechnology::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
        }

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

            'researcher_technology_id' => $this->researcher_technology_id,
            'researcher_technology_group_id' => $this->researcher_technology_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'researcher_technology_name', $this->researcher_technology_name])
            ->andFilterWhere(['ilike', 'researcher_technology_name_en', $this->researcher_technology_name_en])   
            ->andFilterWhere(['ilike', 'researcher_technology_detail', $this->researcher_technology_detail])
            ->andFilterWhere(['ilike', 'researcher_technology_detail_en', $this->researcher_technology_detail_en])   
            ->andFilterWhere(['ilike', 'researcher_technology_image_cover', $this->researcher_technology_image_cover])
            ->andFilterWhere(['ilike', 'researcher_technology_vdo', $this->researcher_technology_vdo])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
