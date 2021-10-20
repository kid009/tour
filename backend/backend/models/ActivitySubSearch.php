<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivitySub;
use yii\web\Session;
/**
 * ActivitySubSearch represents the model behind the search form of `app\models\ActivitySub`.
 */
class ActivitySubSearch extends ActivitySub
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'activity_sub_id', 'activity_sub_order'], 'integer'],
            [['activity_sub_name', 'activity_sub_name_en', 'activity_sub_detail', 'activity_sub_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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

        if ($session['user_login'] == 'admin') {
            $query = ActivitySub::find()->orderBy('update_date desc');
        } 
        else {
            $query = ActivitySub::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'activity_id' => $this->activity_id,
            'activity_sub_id' => $this->activity_sub_id,
            'activity_sub_order' => $this->activity_sub_order,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'activity_sub_name', $this->activity_sub_name])
            ->andFilterWhere(['ilike', 'activity_sub_name_en', $this->activity_sub_name_en])
            ->andFilterWhere(['ilike', 'activity_sub_detail', $this->activity_sub_detail])
            ->andFilterWhere(['ilike', 'activity_sub_detail_en', $this->activity_sub_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
