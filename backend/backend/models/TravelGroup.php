<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "travel_group".
 *
 * @property int $travel_group_id
 * @property string $travel_group_name
 * @property string $travel_group_name_en
 * @property string $travel_group_detail
 * @property string $travel_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Travel[] $travels
 */
class TravelGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_group_detail', 'travel_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['travel_group_name', 'travel_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['travel_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['travel_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'travel_group_id' => 'Travel Group ID',
            'travel_group_name' => 'ชื่อกลุ่ม',
            'travel_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'travel_group_detail' => 'Travel Group Detail',
            'travel_group_detail_en' => 'Travel Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravels()
    {
        return $this->hasMany(Travel::className(), ['travel_group_id' => 'travel_group_id']);
    }
}
