<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "culture".
 *
 * @property string $community_id
 * @property string $culture_group_id
 * @property int $culture_id
 * @property string $culture_name
 * @property string $culture_detail
 * @property string $culture_image_cover
 * @property string $culture_name_en
 * @property string $culture_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Community $community
 * @property CultureGroup $cultureGroup
 */
class Culture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'culture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'culture_group_id', 'province_id', 'amphur_id', 'tambon_id'], 'default', 'value' => null],
            [['community_id', 'culture_group_id', 'province_id', 'amphur_id', 'tambon_id'], 'integer'],
            [['culture_detail_en', 'culture_detail', 'culture_information'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['culture_name', 'culture_name_en', 'create_by', 'update_by', 'culture_place'], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['culture_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => CultureGroup::className(), 'targetAttribute' => ['culture_group_id' => 'culture_group_id']],


            [['community_id', 'culture_group_id', 'culture_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['culture_name', 'culture_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],


            [
                ['culture_image_cover',], 'file',
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
            'culture_group_id' => 'กลุ่มวัฒนธรรม',
            'culture_id' => 'Culture ID',
            'culture_name' => 'ชื่อวัฒนธรรม',
            'culture_detail' => 'Culture Detail',
            'culture_image_cover' => 'Culture Image Cover',
            'culture_name_en' => 'ชื่อวัฒนธรรมภาษาอังกฤษ',
            'culture_detail_en' => 'Culture Detail En',
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
    public function getCultureGroup()
    {
        return $this->hasOne(CultureGroup::className(), ['culture_group_id' => 'culture_group_id']);
    }
}