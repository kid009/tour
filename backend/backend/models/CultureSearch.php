<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Culture;
use yii\web\Session;
/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class CultureSearch extends Culture
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'culture_group_id', 'culture_id'], 'integer'],
            [['culture_name', 'culture_detail', 'culture_image_cover', 'culture_name_en', 'culture_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = Culture::find()->orderBy('update_date desc');
        } 
        else {
            $query = Culture::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'community_id' => $this->community_id,
            'culture_group_id' => $this->culture_group_id,
            'culture_id' => $this->culture_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'culture_name', $this->culture_name])
            ->andFilterWhere(['ilike', 'culture_detail', $this->culture_detail])
            ->andFilterWhere(['ilike', 'culture_image_cover', $this->culture_image_cover])
            ->andFilterWhere(['ilike', 'culture_name_en', $this->culture_name_en])
            ->andFilterWhere(['ilike', 'culture_detail_en', $this->culture_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
