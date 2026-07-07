<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property float $price
 * @property int $created_at
 * @property int $updated_at
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['title', 'price', 'created_at', 'updated_at'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
