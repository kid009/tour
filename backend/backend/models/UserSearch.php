<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\web\Session;
/**
 * UserGroupSearch represents the model behind the search form of `app\models\UserGroup`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['user_login', 'user_password', 'user_email', 'is_active', 'create_by', 'create_date', 'update_by', 'update_date', 'user_image_cover'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
            $query = User::find()->orderBy('update_date desc');
        }
        else{
            $query = User::find()->where(['user_login' => $session['user_login']])->orderBy('update_date desc');
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
            'user_id' => $this->user_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'user_login', $this->user_login])
            ->andFilterWhere(['ilike', 'user_password', $this->user_password])
            ->andFilterWhere(['ilike', 'user_email', $this->user_email])
            ->andFilterWhere(['ilike', 'is_active', $this->is_active])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by])
            ->andFilterWhere(['ilike', 'user_image_cover', $this->user_image_cover]);

        return $dataProvider;
    }
}
