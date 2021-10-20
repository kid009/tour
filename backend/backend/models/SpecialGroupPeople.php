<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "special_group_people".
 *
 * @property string $special_group_id
 * @property string $people_id
 * @property int $special_group_people_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property People $people
 * @property SpecialGroup $specialGroup
 */
class SpecialGroupPeople extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'special_group_people';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_group_id', 'people_id'], 'default', 'value' => null],
            [['special_group_id', 'people_id'], 'required', 'message' => '**กรุณากรอกข้อมูล'],
            [['special_group_id', 'people_id',], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['people_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['people_id' => 'people_id']],
            [['special_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecialGroup::className(), 'targetAttribute' => ['special_group_id' => 'special_group_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'special_group_id' => 'กลุ่มอาชีพ',
            'people_id' => 'บุคคล',
            'special_group_people_id' => 'Special Group People ID',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasOne(People::className(), ['people_id' => 'people_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialGroup()
    {
        return $this->hasOne(SpecialGroup::className(), ['special_group_id' => 'special_group_id']);
    }
}
