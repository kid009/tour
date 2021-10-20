<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tradition".
 *
 * @property string $community_id
 * @property int $tradition_id
 * @property string $tradition_name
 * @property string $tradition_detail
 * @property string $tradition_image_cover
 * @property string $tradition_start_date
 * @property string $tradition_end_date
 * @property string $global_tradition_id
 * @property string $tradition_name_en
 * @property string $tradition_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Community $community
 * @property GlobalTradition $globalTradition
 */
class Tradition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tradition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'global_tradition_id','province_id', 'amphur_id', 'tambon_id',], 'default', 'value' => null],
            [['community_id', 'global_tradition_id','province_id', 'amphur_id', 'tambon_id',], 'integer'],
            [['tradition_detail', 'tradition_detail_en', 'active', 'tradition_information'], 'string'],
            [['tradition_start_date', 'tradition_end_date', 'create_date', 'update_date'], 'safe'],
            [['tradition_name', 'tradition_name_en', 'create_by', 'update_by', 'tradition_place'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['global_tradition_id'], 'exist', 'skipOnError' => true, 'targetClass' => GlobalTradition::className(), 'targetAttribute' => ['global_tradition_id' => 'global_tradition_id']],
            [['community_id', 'global_tradition_id', 'tradition_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tradition_name', 'tradition_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['tradition_image_cover'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_id' => 'ชุมชน',
            'tradition_id' => 'Tradition ID',
            'tradition_name' => 'ชื่อประเพณี',
            'tradition_detail' => 'Tradition Detail',
            'tradition_image_cover' => 'Tradition Image Cover',
            'tradition_start_date' => 'Tradition Start Date',
            'tradition_end_date' => 'Tradition End Date',
            'global_tradition_id' => 'ประเพณีทั่วไป',
            'tradition_name_en' => 'ชื่อภาษาอังกฤษ',
            'tradition_detail_en' => 'Tradition Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::className(), ['community_id' => 'community_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGlobalTradition()
    {
        return $this->hasOne(GlobalTradition::className(), ['global_tradition_id' => 'global_tradition_id']);
    }
}