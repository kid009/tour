<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SpecialGroup;
use yii\web\Session;
/**
 * SpecialGroupSearch represents the model behind the search form of `app\models\SpecialGroup`.
 */
class SpecialGroupSearch extends SpecialGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'special_group_id'], 'integer'],
            [['special_group_name', 'special_group_detail', 'special_group_telephone', 'special_group_email', 'special_group_line', 'special_group_contact_person', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['special_group_latitude', 'special_group_longitude'], 'number'],
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
            $query = SpecialGroup::find()->orderBy('update_date desc');
        } 
        else {
            $query = SpecialGroup::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'special_group_id' => $this->special_group_id,
            'special_group_latitude' => $this->special_group_latitude,
            'special_group_longitude' => $this->special_group_longitude,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'special_group_name', $this->special_group_name])
            ->andFilterWhere(['ilike', 'special_group_detail', $this->special_group_detail])
            ->andFilterWhere(['ilike', 'special_group_telephone', $this->special_group_telephone])
            ->andFilterWhere(['ilike', 'special_group_email', $this->special_group_email])
            ->andFilterWhere(['ilike', 'special_group_line', $this->special_group_line])
            ->andFilterWhere(['ilike', 'special_group_contact_person', $this->special_group_contact_person])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
