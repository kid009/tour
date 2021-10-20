<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivityGroup;
use yii\web\Session;

class ActivityGroupSearch extends ActivityGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_group_id'], 'integer'],
            [['activity_group_name', 'activity_group_detail', 'activity_group_name_en', 'activity_group_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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

        //if ($session['user_login'] == 'admin') {
            $query = ActivityGroup::find()->orderBy('update_date desc');
        // } 
        // else {
        //     $query = ActivityGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
        // }

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
            'activity_group_id' => $this->activity_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'activity_group_name', $this->activity_group_name])
            ->andFilterWhere(['ilike', 'activity_group_detail', $this->activity_group_detail])
            ->andFilterWhere(['ilike', 'activity_group_name_en', $this->activity_group_name_en])
            ->andFilterWhere(['ilike', 'activity_group_detail_en', $this->activity_group_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
