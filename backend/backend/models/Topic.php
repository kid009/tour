<?php

namespace app\models;

use Yii;

class Topic extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'topic';
    }

    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['topic_name', 'topic_slug', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['topic_name', ], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['topic_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'topic_id' => 'topic_id',
            'topic_name' => 'topic_name',
            'topic_slug' => 'topic_slug',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    
    
}
