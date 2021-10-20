<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "poi_group".
 *
 * @property int $poi_group_id
 * @property string $poi_group_name
 * @property string $poi_group_detail
 * @property string $poi_group_name_en
 * @property string $poi_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Poi[] $pois
 */
class PoiGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poi_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['poi_group_detail', 'poi_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['poi_group_name', 'poi_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['poi_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [
                ['poi_group_name','poi_group_name_en',], 
                'unique',
                'message' => '**ชื่อนี้ซ้ำในระบบ**'
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'poi_group_id' => 'Poi Group ID',
            'poi_group_name' => 'ชื่อกลุ่มสถานที่',
            'poi_group_detail' => 'Poi Group Detail',
            'poi_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'poi_group_detail_en' => 'Poi Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPois()
    {
        return $this->hasMany(Poi::className(), ['poi_group_id' => 'poi_group_id']);
    }
}
