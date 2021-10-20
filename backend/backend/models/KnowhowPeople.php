<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "knowhow_people".
 *
 * @property string $people_id
 * @property string $knowhow_id
 * @property int $knowhow_people_id
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Knowhow $knowhow
 * @property People $people
 */
class KnowhowPeople extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'knowhow_people';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['people_id', 'knowhow_id'], 'default', 'value' => null],
            [['people_id', 'knowhow_id'], 'required', 'message' => '**กรุณากรอกข้อมูล'],
            [['people_id', 'knowhow_id'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['create_by', 'update_by'], 'string', 'max' => 200],
            [['knowhow_id'], 'exist', 'skipOnError' => true, 'targetClass' => Knowhow::className(), 'targetAttribute' => ['knowhow_id' => 'knowhow_id']],
            [['people_id'], 'exist', 'skipOnError' => true, 'targetClass' => People::className(), 'targetAttribute' => ['people_id' => 'people_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'people_id' => 'บุคคล',
            'knowhow_id' => 'ความรู้',
            'knowhow_people_id' => 'Knowhow People ID',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKnowhow()
    {
        return $this->hasOne(Knowhow::className(), ['knowhow_id' => 'knowhow_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasOne(People::className(), ['people_id' => 'people_id']);
    }
}
