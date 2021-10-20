<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourism_province_slide_image".
 *
 * @property int $tourism_province_slide_image_id
 * @property string $tourism_province_silde_image_name
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class TourismProvinceSlideImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourism_province_slide_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by', 'tourism_province_slide_order', 'type_slide_image','tourism_province_silde_image_header','tourism_province_silde_image_text'], 'string', 'max' => 200],
            [['tourism_province_slide_order'], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['tourism_province_slide_order'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
            [['active'], 'string', 'max' => 1],
            [
                ['tourism_province_silde_image_name',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourism_province_slide_image_id' => 'Tourism Province Slide Image ID',
            'tourism_province_silde_image_name' => 'ชื่อภาพ',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'tourism_province_slide_order' => 'ลำดับ',
            'type_slide_image' => 'ประเภทภาพ'
        ];
    }
}
