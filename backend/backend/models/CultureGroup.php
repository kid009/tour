<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "culture_group".
 *
 * @property int $culture_group_id
 * @property string $culture_group_name
 * @property string $culture_group_detail
 * @property string $culture_group_name_en
 * @property string $culture_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Culture[] $cultures
 */
class CultureGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'culture_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['culture_group_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['culture_group_name', 'culture_group_name_en', 'culture_group_detail_en', 'create_by', 'update_by'], 'string', 'max' => 200],

            [['culture_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล'],
            [['culture_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'culture_group_id' => 'Culture Group ID',
            'culture_group_name' => 'ชื่อกลุ่ม',
            'culture_group_detail' => 'Culture Group Detail',
            'culture_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'culture_group_detail_en' => 'Culture Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCultures()
    {
        return $this->hasMany(Culture::className(), ['culture_group_id' => 'culture_group_id']);
    }
}