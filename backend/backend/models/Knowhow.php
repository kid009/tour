<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "knowhow".
 *
 * @property string $knowhow_group_id
 * @property string $community_id
 * @property int $knowhow_id
 * @property string $khowhow_name
 * @property string $knowhow_detail
 * @property string $knowhow_image_cover
 * @property string $knowhow_name_en
 * @property string $knowhow_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Community $community
 * @property KnowhowGroup $knowhowGroup
 * @property KnowhowPeople[] $knowhowPeoples
 */
class Knowhow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'knowhow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['knowhow_group_id', 'community_id'], 'default', 'value' => null],
            [['knowhow_group_id', 'community_id'], 'integer'],
            [[
                'knowhow_detail', 'knowhow_detail_en', 'knowhow_resource', 'knowhow_process', 'knowhow_result', 'knowhow_apply',  'knowhow_innovation_resource', 'knowhow_innovation_process', 'knowhow_innovation_result', 'knowhow_innovation_apply'
                , 'knowhow_technology_resource', 'knowhow_technology_process', 'knowhow_technology_result', 'knowhow_technology_apply'
            ], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [[
                'knowhow_name',  'knowhow_name_en', 'create_by', 'update_by', 'knowhow_contact_person', 'knowhow_telephone', 'knowhow_email', 'knowhow_facebook', 'knowhow_line', 'knowhow_link', 'knowhow_vdo'
                , 'knowhow_innovation_link', 'knowhow_innovation_vdo', 'knowhow_innovation_name'
                , 'knowhow_technology_link', 'knowhow_technology_vdo', 'knowhow_technology_name'
            ], 'string', 'max' => 200],
            [['community_id'], 'exist', 'skipOnError' => true, 'targetClass' => Community::className(), 'targetAttribute' => ['community_id' => 'community_id']],
            [['knowhow_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => KnowhowGroup::className(), 'targetAttribute' => ['knowhow_group_id' => 'knowhow_group_id']],
            [['knowhow_group_id', 'community_id', 'knowhow_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [
                ['knowhow_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['knowhow_image_contact',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['knowhow_innovation_image',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['knowhow_technology_image',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            //[['knowhow_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'knowhow_group_id' => 'กลุ่มความรู้',
            'community_id' => 'ชุมชน',
            'knowhow_id' => 'Knowhow ID',
            'knowhow_name' => 'ชื่อองค์ความรู้',
            'knowhow_detail' => 'Knowhow Detail',
            'knowhow_image_cover' => 'Knowhow Image Cover',
            'knowhow_name_en' => 'ชื่อภาษาอังกฤษ',
            'knowhow_detail_en' => 'Knowhow Detail En',
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
    public function getKnowhowGroup()
    {
        return $this->hasOne(KnowhowGroup::className(), ['knowhow_group_id' => 'knowhow_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKnowhowPeoples()
    {
        return $this->hasMany(KnowhowPeople::className(), ['knowhow_id' => 'knowhow_id']);
    }

    public function getSpecialGroup()
    {
        return $this->hasMany(SpecialGroup::className(), ['knowhow_id' => 'knowhow_id']);
    }
}
