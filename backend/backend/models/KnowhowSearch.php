<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Knowhow;
use yii\web\Session;
/**
 * KnowhowSearch represents the model behind the search form of `app\models\Knowhow`.
 */
class KnowhowSearch extends Knowhow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['knowhow_group_id', 'community_id', 'knowhow_id'], 'integer'],
            [['knowhow_name', 'knowhow_detail', 'knowhow_image_cover', 'knowhow_name_en', 'knowhow_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = Knowhow::find()->orderBy('update_date desc');
        } 
        else {
            $query = Knowhow::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'knowhow_group_id' => $this->knowhow_group_id,
            'community_id' => $this->community_id,
            'knowhow_id' => $this->knowhow_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'knowhow_name', $this->knowhow_name])
            ->andFilterWhere(['ilike', 'knowhow_detail', $this->knowhow_detail])
            ->andFilterWhere(['ilike', 'knowhow_image_cover', $this->knowhow_image_cover])
            ->andFilterWhere(['ilike', 'knowhow_name_en', $this->knowhow_name_en])
            ->andFilterWhere(['ilike', 'knowhow_detail_en', $this->knowhow_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
