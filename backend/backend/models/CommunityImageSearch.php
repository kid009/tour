<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CommunityImage;
use yii\web\Session;
/**
 * CommunityImageSearch represents the model behind the search form of `app\models\CommunityImage`.
 */
class CommunityImageSearch extends CommunityImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_image_id', 'community_id', 'ref_id'], 'integer'],
            [['community_image_name', 'community_image_type', 'community_image_subtype', 'create_by', 'create_date', 'update_by', 'update_date', 'community_image_file'], 'safe'],
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
            $query = CommunityImage::find()->orderBy('update_date desc');
        } 
        else {
            $query = CommunityImage::find()->where(['create_by' => $session['user_login']])->orderBy('update_date desc');
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
            'community_image_id' => $this->community_image_id,
            'community_id' => $this->community_id,
            'ref_id' => $this->ref_id,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['ilike', 'community_image_name', $this->community_image_name])
            ->andFilterWhere(['ilike', 'community_image_type', $this->community_image_type])
            ->andFilterWhere(['ilike', 'community_image_subtype', $this->community_image_subtype])
            ->andFilterWhere(['ilike', 'create_by', $this->create_by])
            ->andFilterWhere(['ilike', 'update_by', $this->update_by])
            ->andFilterWhere(['ilike', 'community_image_file', $this->community_image_file]);

        return $dataProvider;
    }
}
