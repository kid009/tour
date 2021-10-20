<?php

namespace app\models;

use Yii;

class TourismImpressive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourism_impressive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tourism_impressive_id', 'tourism_impressive_group_id'], 'integer'],
            [['tourism_impressive_detail_en', 'tourism_impressive_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['tourism_impressive_name', 'tourism_impressive_name_en', 'create_by', 'update_by', 'tourism_impressive_link', 'tourism_impressive_vdo', 'tourism_impressive_hashtag', 'tourism_impressive_place'], 'string', 'max' => 200],
            [['tourism_impressive_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => TourismImpressiveGroup::className(), 'targetAttribute' => ['tourism_impressive_group_id' => 'tourism_impressive_group_id']],

            [['tourism_impressive_group_id', 'tourism_impressive_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_impressive_name', 'tourism_impressive_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['tourism_impressive_image_cover'], 'file',
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
            'tourism_impressive_id' => 'tourism_impressive_id',
            'tourism_impressive_group_id' => 'tourism_impressive_group_id',
            'tourism_impressive_name' => 'tourism_impressive_name',
            'tourism_impressive_name_en' => 'tourism_impressive_name_en',
            'tourism_impressive_detail' => 'tourism_impressive_detail',
            'tourism_impressive_detail_en' => 'tourism_impressive_detail_en',
            'tourism_impressive_image_cover' => 'tourism_impressive_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTourismImpressiveGroup()
    {
        return $this->hasOne(TourismImpressiveGroup::className(), ['tourism_impressive_group_id' => 'tourism_impressive_group_id']);
    }
}
