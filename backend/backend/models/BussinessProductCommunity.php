<?php

namespace app\models;

use Yii;

class BussinessProductCommunity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bussiness_product_community';
    }

    public function rules()
    {
        return [
            [['bussiness_product_community_group_id', 'community_id'], 'integer'],
            [['bussiness_product_community_detail', 'bussiness_product_community_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['bussiness_product_community_name', 'bussiness_product_community_name_en', 'create_by', 'update_by', 'bussiness_product_community_story', 'bussiness_product_community_vdo', 'bussiness_product_community_link', 'bussiness_product_community_promotion'], 'string', 'max' => 200],
            [['bussiness_product_community_name','bussiness_product_community_group_id', 'community_id'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['bussiness_product_community_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['bussiness_product_community_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['bussiness_product_community_price'], 'double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            // 'bussiness_group_id' => 'bussiness_group_id',
            // 'bussiness_group_name' => 'bussiness_group_name',
            // 'bussiness_group_name_detail' => 'bussiness_group_name_detail',
            // 'bussiness_group_name_en' => 'bussiness_group_name_en',
            // 'bussiness_group_name_detail_en' => 'bussiness_group_name_detail_en',
            // 'create_by' => 'Create By',
            // 'create_date' => 'Create Date',
            // 'update_by' => 'Updae By',
            // 'update_date' => 'Update Date',
        ];
    }

    public function getBussinessProductCommunityGroup()
    {
        return $this->hasOne(BussinessProductCommunityGroup::className(), ['bussiness_product_community_group_id' => 'bussiness_product_community_group_id']);
    }

    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }

}
