<?php

namespace app\models;

use Yii;

class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id', 'post_id'], 'integer'],
            [['post_detail',], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['post_title', 'post_slug', 'is_active', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['post_title', 'topic_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [
                ['post_image',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['post_title'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'post_id',
            'topic_id' => 'topic_id',
            'post_title' => 'post_title',
            'post_slug' => 'post_slug',
            'post_detail' => 'post_detail',
            'post_image' => 'post_image',
            'is_active' => 'is_active',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
}
