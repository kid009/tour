<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "culture".
 *
 * @property int $researcher_tourism_product_id
 * @property string $researcher_tourism_product_group_id
 * @property string $researcher_tourism_product_name
 * @property string $researcher_tourism_product_name_en
 * @property string $researcher_tourism_product_detail
 * @property string $researcher_tourism_product_detail_en
 * @property string $researcher_tourism_product_image_cover
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property ResearchTourismProductGroup $researchTourismProductGroup
 */
class ResearchTourismProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'researcher_tourism_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['researcher_tourism_product_id', 'researcher_tourism_product_group_id'], 'integer'],
            [['researcher_tourism_product_detail_en', 'researcher_tourism_product_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['researcher_tourism_product_name', 'researcher_tourism_product_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['researcher_tourism_product_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResearchTourismProductGroup::className(), 'targetAttribute' => ['researcher_tourism_product_group_id' => 'researcher_tourism_product_group_id']],

            [['researcher_tourism_product_group_id', 'researcher_tourism_product_name'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['researcher_tourism_product_name', 'researcher_tourism_product_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],

            [
                ['researcher_tourism_product_image_cover'], 'file',
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
            'researcher_tourism_product_id' => 'researcher_tourism_product_id',
            'researcher_tourism_product_group_id' => 'กลุ่มผลิตภัณฑ์',
            'researcher_tourism_product_name' => 'ชื่อผลิตภัณฑ์',
            'researcher_tourism_product_name_en' => 'ชื่อเผลิตภัณฑ์ภาษาอังกฤษ',
            'researcher_tourism_product_detail' => 'researcher_tourism_product_detail',
            'researcher_tourism_product_detail_en' => 'researcher_tourism_product_detail_en',
            'researcher_tourism_product_image_cover' => 'researcher_tourism_product_image_cover',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResearchTourismProductGroup()
    {
        return $this->hasOne(ResearchTourismProductGroup::className(), ['researcher_tourism_product_group_id' => 'researcher_tourism_product_group_id']);
    }
}
