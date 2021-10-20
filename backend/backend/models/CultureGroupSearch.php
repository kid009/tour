<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CultureGroup;
use yii\web\Session;
/**
 * CultureGroupSearch represents the model behind the search form of `app\models\CultureGroup`.
 */
class CultureGroupSearch extends CultureGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['culture_group_id'], 'integer'],
            [['culture_group_name', 'culture_group_detail', 'culture_group_name_en', 'culture_group_detail_en', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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

        // if ($session['user_login'] == 'admin') {
            $query = CultureGroup::find()->orderBy('update_date desc');
        // } 
        // else {
        //     $query = CultureGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
        // }

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
            'culture_group_id' => $this->culture_group_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'culture_group_name', $this->culture_group_name])
            ->andFilterWhere(['ilike', 'culture_group_detail', $this->culture_group_detail])
            ->andFilterWhere(['ilike', 'culture_group_name_en', $this->culture_group_name_en])
            ->andFilterWhere(['ilike', 'culture_group_detail_en', $this->culture_group_detail_en])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
