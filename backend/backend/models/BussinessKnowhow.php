<?php

namespace app\models;

use Yii;

class BussinessKnowhow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bussiness_knowhow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bussiness_knowhow_id', 'bussiness_knowhow_group_id'], 'integer'],
            [['bussiness_knowhow_detail_en', 'bussiness_knowhow_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_knowhow_name', 'bussiness_knowhow_name_en', 'create_by', 'update_by', 'bussiness_knowhow_link'], 'string', 'max' => 200],
            [['bussiness_knowhow_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => BussinessKnowhowGroup::className(), 'targetAttribute' => ['bussiness_knowhow_group_id' => 'bussiness_knowhow_group_id']],

            [['bussiness_knowhow_group_id', 'bussiness_knowhow_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_knowhow_name', 'bussiness_knowhow_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['bussiness_knowhow_image_cover'], 'file',
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
            'bussiness_knowhow_id' => 'bussiness_knowhow_id',
            'bussiness_knowhow_group_id' => 'bussiness_knowhow_group_id',
            'bussiness_knowhow_name' => 'bussiness_knowhow_name',
            'bussiness_knowhow_name_en' => 'bussiness_knowhow_name_en',
            'bussiness_knowhow_detail' => 'bussiness_knowhow_detail',
            'bussiness_knowhow_detail_en' => 'bussiness_knowhow_detail_en',
            'bussiness_knowhow_image_cover' => 'bussiness_knowhow_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBussinessKnowhowGroup()
    {
        return $this->hasOne(BussinessKnowhowGroup::className(), ['bussiness_knowhow_group_id' => 'bussiness_knowhow_group_id']);
    }
}
