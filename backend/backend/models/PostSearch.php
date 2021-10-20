<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;
use yii\web\Session;

class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'topic_id'], 'integer'],
            [['post_title', 'post_slug', 'post_image', 'post_detail', 'is_active', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
            $query = Post::find()->orderBy('update_date desc');
        } 
        else {
            $query = Post::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'post_id' => $this->post_id,
            'topic_id' => $this->topic_id,
        ]);

        $query->andFilterWhere(['ilike', 'post_title', $this->post_title])
            ->andFilterWhere(['ilike', 'post_slug', $this->post_slug])
            ->andFilterWhere(['ilike', 'post_image', $this->post_image])
            ->andFilterWhere(['ilike', 'post_detail', $this->post_detail])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
