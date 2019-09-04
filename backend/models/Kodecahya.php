<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "KODE_CAHYA".
 *
 * @property int $CAHYA_ID
 * @property string $KODE_KARTON
 * @property string $NIE
 * @property string $KODE_PRODUK
 */
class Kodecahya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'KODE_CAHYA';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_o');
    }
    
    /**
     * @inheritdoc $primarykey
     */
    public static function primaryKey() 
    {
        return ["CAHYA_ID"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CAHYA_ID', 'KODE_KARTON', 'NIE', 'KODE_PRODUK'], 'required'],
            [['CAHYA_ID'], 'integer'],
            [['KODE_KARTON', 'NIE'], 'string', 'max' => 100],
            [['KODE_PRODUK'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CAHYA_ID' => 'Cahya  ID',
            'KODE_KARTON' => 'Kode  Karton',
            'NIE' => 'Nie',
            'KODE_PRODUK' => 'Kode  Produk',
        ];
    }
}
