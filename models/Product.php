<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Product".
 *
 * @property integer $id
 * @property integer $idProductCategory
 * @property string $name
 * @property string $Price
 *
 * @property ProductCategory $idProductCategory0
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProductCategory'], 'integer'],
            [['name'], 'string'],
            [['Price'], 'number'],
            [['idProductCategory'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['idProductCategory' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idProductCategory' => 'Id Product Category',
            'name' => 'Name',
            'Price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProductCategory0()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'idProductCategory']);
    }
}
