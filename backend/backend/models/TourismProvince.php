<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourism_province".
 *
 * @property int $tourism_province_id
 * @property string $province_id
 * @property string $tourism_province_name
 * @property string $tourism_province_name_en
 * @property string $tourism_province_detail
 * @property string $tourism_province_detail_en
 * @property string $tourism_province_image_1
 * @property string $tourism_province_image_2
 * @property string $tourism_province_image_3
 * @property string $tourism_province_info
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 */
class TourismProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourism_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id'], 'default', 'value' => null],
            [['province_id', 'tourism_province_order'], 'integer'],
            [['tourism_province_detail', 'tourism_province_detail_en', 'tourism_province_info', 'tourism_province_vdo'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['tourism_province_name', 'tourism_province_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['tourism_province_image_1',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['tourism_province_image_2', ], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
            ],
            [['tourism_province_image_3',], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,jpeg',
                'maxSize' => 3000000,
                'tooBig' => 'Limit is 3 MB.'
        ],
        [['tourism_province_order',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tourism_province_id' => 'Tourism Province ID',
            'province_id' => 'จังหวัด',
            'tourism_province_name' => 'ชื่อจังหวัด',
            'tourism_province_name_en' => 'ชื่อภาษาอังกฤษ',
            'tourism_province_detail' => 'รายละเอียด',
            'tourism_province_detail_en' => 'รายละเอียดภาษาอังกฤษ',
            'tourism_province_image_1' => 'รูปหน้า site/index',
            'tourism_province_image_2' => 'รูปหน้า site/province',
            'tourism_province_image_3' => 'รูปแผนที่หน้า site/province',
            'tourism_province_info' => 'Infomation',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
            'tourism_province_order' => 'ลำดับ'
        ];
    }
}
