<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ar;
use yii\web\Session;
/**
 * ActivityGroupSearch represents the model behind the search form of `app\models\ActivityGroup`.
 */
class ArSearch extends Ar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_id', 'community_id'], 'integer'],
            [['ar_url', 'ar_url_ios', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = Ar::find()->orderBy('update_date desc');
        } 
        else {
            $query = Ar::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'ar_id' => $this->ar_id,
            'community_id' => $this->community_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'ar_url', $this->ar_url])
        ->andFilterWhere(['ilike', 'ar_url', $this->ar_url_ios])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
