<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "place_group".
 *
 * @property int $place_group_id
 * @property string $place_group_name_en
 * @property string $place_group_name
 * @property string $place_group_detail
 * @property string $place_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Place[] $places
 */
class PlaceGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_group_detail', 'place_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['place_group_name_en', 'place_group_name', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['place_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['place_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'place_group_id' => 'Place Group ID',
            'place_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'place_group_name' => 'ชื่อกลุ่ม',
            'place_group_detail' => 'Place Group Detail',
            'place_group_detail_en' => 'Place Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::className(), ['place_group_id' => 'place_group_id']);
    }
}
