<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "community".
 *
 * @property int $community_id
 * @property int $province_id
 * @property int $amphur_id
 * @property int tambon_id
 * @property string $community_name
 * @property int $community_number_of_population
 * @property int $community_number_of_houses
 * @property string $community_image_cover
 * @property string $community_ethnicty
 * @property string $community_detail
 * @property string $community_career
 * @property string $community_latitude
 * @property string $community_longitude
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class Community extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_name', 'active'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['province_id', 'amphur_id', 'tambon_id', 'community_number_of_population', 'community_number_of_houses'], 'default', 'value' => null],
            [['community_detail', 'community_detail_en', 'community_vdo', 'active', 'community_facebook'], 'string'],
            [['community_latitude', 'community_longitude'], 'number'],
            [['create_date', 'update_date'], 'safe'],
            [['community_name', 'community_name_en', 'community_ethnicty', 'community_career', 'create_by', 'update_by', 'community_contact', 'community_email', 'community_line', 'community_instagram', 'community_telephone', 'community_link'], 'string', 'max' => 200],
            [['community_name', 'community_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [
                ['community_image_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['community_image_contact',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [
                ['community_image_background_cover',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            ['community_email', 'email', 'message' => '**รูปแบบอีเมลไม่ถูกต้อง**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_id' => 'Community ID',
            'province_id' => 'Province ID',
            'amphur_id' => 'Amphur ID',
            'tambon_id' => 'District ID',
            'community_name' => 'ชื่อชุมชน',
            'community_number_of_population' => 'Community Number Of Population',
            'community_number_of_houses' => 'Community Number Of Houses',
            'community_image_cover' => 'ภาพชุมชน',
            'community_ethnicty' => 'Community Ethnicty',
            'community_detail' => 'Community Detail',
            'community_career' => 'Community Career',
            'community_latitude' => 'Community Latitude',
            'community_longitude' => 'Community Longitude',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    public function getArs()
    {
        return $this->hasMany(Ar::className(), ['community_id' => 'community_id']);
    }
}