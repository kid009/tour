<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "knowhow_group".
 *
 * @property int $knowhow_group_id
 * @property string $knowhow_group_name
 * @property string $knowhow_group_detail
 * @property string $knowhow_group_name_en
 * @property string $knowhow_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $updae_by
 * @property string $update_date
 *
 * @property Knowhow[] $knowhows
 */
class KnowhowGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'knowhow_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['knowhow_group_detail', 'knowhow_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['knowhow_group_name', 'knowhow_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['knowhow_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [['knowhow_group_name',], 'unique', 'message' => '**ชื่อนี้ซ้ำในระบบ**'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'knowhow_group_id' => 'Knowhow Group ID',
            'knowhow_group_name' => 'ชื่อกลุ่ม',
            'knowhow_group_detail' => 'Knowhow Group Detail',
            'knowhow_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'knowhow_group_detail_en' => 'Knowhow Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Updae By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKnowhows()
    {
        return $this->hasMany(Knowhow::className(), ['knowhow_group_id' => 'knowhow_group_id']);
    }
}
