<?php

namespace app\models;

use Yii;

class Ar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['ar_url', 'ar_url_ios', 'create_by', 'update_by', 'active'], 'string', 'max' => 200],
            //[['ar_url', ], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_id' => 'ar_id',
            'community_id' => 'ชชุมชน',
            'ar_url' => 'URL',
            'ar_url_ios' => 'ar_url_ios',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }
    
    /*public function getProvince()
    {
        return $this->hasOne(Province::className(), ['province_id' => 'province_id']);
    }*/

    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }
    
}
