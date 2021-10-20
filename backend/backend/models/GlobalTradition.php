<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "global_tradition".
 *
 * @property int $global_tradition_id
 * @property string $global_tradition_name
 * @property string $global_tradition_name_en
 * @property string $global_tradition_detail
 * @property string $global_tradition_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Tradition[] $traditions
 */
class GlobalTradition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'global_tradition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['global_tradition_detail'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['global_tradition_name', 'global_tradition_name_en', 'global_tradition_detail_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['global_tradition_name', ], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['global_tradition_name_en','global_tradition_name_en'], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'global_tradition_id' => 'Global Tradition ID',
            'global_tradition_name' => 'กลุ่มประเพณี',
            'global_tradition_name_en' => 'ชื่อภาษาอังกฤษ',
            'global_tradition_detail' => 'Global Tradition Detail',
            'global_tradition_detail_en' => 'Global Tradition Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTraditions()
    {
        return $this->hasMany(Tradition::className(), ['global_tradition_id' => 'global_tradition_id']);
    }
}
