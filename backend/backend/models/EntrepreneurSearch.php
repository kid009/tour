<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Entrepreneur;

class EntrepreneurSearch extends Entrepreneur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entrepreneur_group_id', 'entrepreneur_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['entrepreneur_name', 'entrepreneur_address', 'entrepreneur_image', 'entrepreneur_telephone', 'entrepreneur_email', 'entrepreneur_line', 'entrepreneur_detail', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['entrepreneur_latitude', 'entrepreneur_longitude'], 'number'],
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
        $query = Entrepreneur::find()->orderBy('update_date desc');

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
            'entrepreneur_group_id' => $this->entrepreneur_group_id,
            'entrepreneur_id' => $this->entrepreneur_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'entrepreneur_latitude' => $this->entrepreneur_latitude,
            'entrepreneur_longitude' => $this->entrepreneur_longitude,
            'province_id' => $this->province_id,
            'amphur_id' => $this->amphur_id,
            'tambon_id' => $this->tambon_id,
        ]);

        $query->andFilterWhere(['ilike', 'entrepreneur_name', $this->entrepreneur_name])
            ->andFilterWhere(['ilike', 'entrepreneur_address', $this->entrepreneur_address])
            ->andFilterWhere(['ilike', 'entrepreneur_image', $this->entrepreneur_image])
            ->andFilterWhere(['ilike', 'entrepreneur_telephone', $this->entrepreneur_telephone])
            ->andFilterWhere(['ilike', 'entrepreneur_email', $this->entrepreneur_email])
            ->andFilterWhere(['ilike', 'entrepreneur_line', $this->entrepreneur_line])
            ->andFilterWhere(['ilike', 'entrepreneur_detail', $this->entrepreneur_detail])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
