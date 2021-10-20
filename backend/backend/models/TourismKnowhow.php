<?php

namespace app\models;

use Yii;

class TourismKnowhow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourism_knowhow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_knowhow_id', 'tourism_knowhow_group_id'], 'integer'],
            [['tourism_knowhow_detail_en', 'tourism_knowhow_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['is_active'], 'string', 'max' => 1],
            [['tourism_knowhow_name', 'tourism_knowhow_name_en', 'create_by', 'update_by', 'tourism_knowhow_link', 'tourism_knowhow_vdo', 'tourism_knowhow_hashtag', 'tourism_knowhow_place'], 'string', 'max' => 200],
            [['tourism_knowhow_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => TourismKnowhowGroup::className(), 'targetAttribute' => ['tourism_knowhow_group_id' => 'tourism_knowhow_group_id']],

            [['tourism_knowhow_group_id', 'tourism_knowhow_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_knowhow_name', 'tourism_knowhow_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['tourism_knowhow_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourism_knowhow_id' => 'tourism_knowhow_id',
            'tourism_knowhow_group_id' => 'tourism_knowhow_group_id',
            'tourism_knowhow_name' => 'tourism_knowhow_name',
            'tourism_knowhow_name_en' => 'tourism_knowhow_name_en',
            'tourism_knowhow_detail' => 'tourism_knowhow_detail',
            'tourism_knowhow_detail_en' => 'tourism_knowhow_detail_en',
            'tourism_knowhow_image_cover' => 'tourism_knowhow_image_cover',
            'is_active' => 'is_active',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourismKnowhowGroup()
    {
        return $this->hasOne(TourismKnowhowGroup::className(), ['tourism_knowhow_group_id' => 'tourism_knowhow_group_id']);
    }
}
