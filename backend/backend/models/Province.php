<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $province_id
 * @property string $province_code
 * @property string $province_name
 * @property int $geo_id
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_code', 'province_name', 'geo_id'], 'required'],
            [['geo_id'], 'default', 'value' => null],
            [['geo_id'], 'integer'],
            [['province_code'], 'string', 'max' => 2],
            [['province_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'province_id' => 'Province ID',
            'province_code' => 'Province Code',
            'province_name' => 'Province Name',
            'geo_id' => 'Geo ID',
        ];
    }
    
    /*public function getArs()
    {
        return $this->hasMany(Ar::className(), ['province_id' => 'province_id']);
    }*/
    
}
