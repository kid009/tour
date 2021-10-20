<?php

namespace app\models;

use app\models\TourismImpressive;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * CultureSearch represents the model behind the search form of `app\models\Culture`.
 */
class TourismImpressiveSearch extends TourismImpressive
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_impressive_id', 'tourism_impressive_group_id'], 'integer'],
            [['tourism_impressive_name', 'tourism_impressive_name_en', 'tourism_impressive_detail', 'tourism_impressive_detail_en', 'tourism_impressive_image_cover', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = TourismImpressive::find()->orderBy('update_date desc');
        } else {
            $query = TourismImpressive::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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

            'tourism_impressive_id' => $this->tourism_impressive_id,
            'tourism_impressive_group_id' => $this->tourism_impressive_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'tourism_impressive_name', $this->tourism_impressive_name])
            ->andFilterWhere(['ilike', 'tourism_impressive_name_en', $this->tourism_impressive_name_en])
            ->andFilterWhere(['ilike', 'tourism_impressive_detail', $this->tourism_impressive_detail])
            ->andFilterWhere(['ilike', 'tourism_impressive_detail_en', $this->tourism_impressive_detail_en])
            ->andFilterWhere(['ilike', 'tourism_impressive_image_cover', $this->tourism_impressive_image_cover])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
