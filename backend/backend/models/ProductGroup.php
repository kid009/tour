<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_group".
 *
 * @property int $product_group_id
 * @property string $product_group_name
 * @property string $product_group_detail
 * @property string $product_group_name_en
 * @property string $product_group_detail_en
 * @property string $create_by
 * @property string $create_date
 * @property string $update_by
 * @property string $update_date
 *
 * @property Product[] $products
 */
class ProductGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_group_detail', 'product_group_detail_en'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['product_group_name', 'product_group_name_en', 'create_by', 'update_by'], 'string', 'max' => 200],
            [['product_group_name',], 'required', 'message' => '**กรุณากรอกข้อมูล**'],
            [
                ['product_group_name',], 
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
            'product_group_id' => 'Product Group ID',
            'product_group_name' => 'ชื่อกลุ่มสินค้า',
            'product_group_detail' => 'Product Group Detail',
            'product_group_name_en' => 'ชื่อกลุ่มภาษาอังกฤษ',
            'product_group_detail_en' => 'Product Group Detail En',
            'create_by' => 'Create By',
            'create_date' => 'Create Date',
            'update_by' => 'Update By',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['product_group_id' => 'product_group_id']);
    }
}
