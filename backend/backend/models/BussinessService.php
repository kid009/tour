<?php

namespace app\models;

use Yii;

class BussinessService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bussiness_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bussiness_service_id', 'bussiness_service_group_id'], 'integer'],
            [['bussiness_service_detail_en', 'bussiness_service_detail', 'bussiness_service_promotion'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_service_name', 'bussiness_service_name_en', 'create_by', 'update_by', 'bussiness_service_link', 'bussiness_service_vdo', 'bussiness_service_price'], 'string', 'max' => 200],
            [['bussiness_service_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => BussinessServiceGroup::className(), 'targetAttribute' => ['bussiness_service_group_id' => 'bussiness_service_group_id']],

            [['bussiness_service_group_id', 'bussiness_service_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_service_name', 'bussiness_service_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['bussiness_service_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jepg',
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
            'bussiness_service_id' => 'bussiness_service_id',
            'bussiness_service_group_id' => 'bussiness_service_group_id',
            'bussiness_service_name' => 'bussiness_service_name',
            'bussiness_service_name_en' => 'bussiness_service_name_en',
            'bussiness_service_detail' => 'bussiness_service_detail',
            'bussiness_service_detail_en' => 'bussiness_service_detail_en',
            'bussiness_service_image_cover' => 'bussiness_service_image_cover',

            'bussiness_service_vdo' => 'bussiness_service_vdo',
            'bussiness_service_link' => 'bussiness_service_link',
            'bussiness_service_promotion' => 'bussiness_service_promotion',

            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBussinessServiceGroup()
    {
        return $this->hasOne(BussinessServiceGroup::className(), ['bussiness_service_group_id' => 'bussiness_service_group_id']);
    }
}
