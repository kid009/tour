<?php

namespace app\models;

use Yii;

class Researchknowhow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'researcher_knowhow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['researcher_knowhow_id', 'researcher_knowhow_group_id'], 'integer'],
            [['researcher_knowhow_detail_en', 'researcher_knowhow_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_knowhow_name', 'researcher_knowhow_name_en', 'create_by', 'update_by', 'researcher_knowhow_link'], 'string', 'max' => 200],
            [['researcher_knowhow_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchKnowhowGroup::className(), 'targetAttribute' => ['researcher_knowhow_group_id' => 'researcher_knowhow_group_id']],

            [['researcher_knowhow_group_id', 'researcher_knowhow_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['researcher_knowhow_name', 'researcher_knowhow_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['researcher_knowhow_image_cover'], 'file',
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
            'researcher_knowhow_id' => 'researcher_knowhow_id',
            'researcher_knowhow_group_id' => 'researcher_knowhow_group_id',
            'researcher_knowhow_name' => 'researcher_knowhow_name',
            'researcher_knowhow_name_en' => 'researcher_knowhow_name_en',
            'researcher_knowhow_detail' => 'researcher_knowhow_detail',
            'researcher_knowhow_detail_en' => 'researcher_knowhow_detail_en',
            'researcher_knowhow_image_cover' => 'researcher_knowhow_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResearchKnowhowGroup()
    {
        return $this->hasOne(ResearchKnowhowGroup::className(), ['researcher_knowhow_group_id' => 'researcher_knowhow_group_id']);
    }
}
