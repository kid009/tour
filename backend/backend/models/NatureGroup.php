<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nature_group".
 *
 * @property int $nature_group_id
 * @property string $nature_group_name
 * @property string $nature_group_detail
 * @property string $nature_group_name_en
 * @property string $nature_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Nature[] $natures
 */
class NatureGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nature_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nature_group_detail', 'nature_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['nature_group_name', 'nature_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['nature_group_name', ], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['nature_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nature_group_id' => 'Nature Group ID',
            'nature_group_name' => 'ชื่อกลุ่ม',
            'nature_group_detail' => 'รายละเอียด',
            'nature_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'nature_group_detail_en' => 'รายละเอียดภาษาอังกฤษ',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNatures()
    {
        return $this->hasMany(Nature::className(), ['nature_group_id' => 'nature_group_id']);
    }
}
