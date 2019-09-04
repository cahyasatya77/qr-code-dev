<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agregasi_detail".
 *
 * @property int $id
 * @property int $id_agregasi
 * @property string $kode_kemas
 *
 * @property Agregasi $agregasi
 */
class Agregasidetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agregasi_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_kemas'], 'required'],
            [['id_agregasi'], 'integer'],
            [['kode_kemas'], 'string', 'max' => 100],
            [['kode_kemas'], 'unique'],
            [['is_active', 'is_sample', 'is_sold'], 'string', 'max' => 10],
            ['is_active', 'default', 'value' => 'TRUE'],
            ['is_sample','default', 'value' => 'FALSE'],
            ['is_sold','default', 'value' => 'FALSE'],
            //[['id_agregasi'], 'exist', 'skipOnError' => true, 'targetClass' => Agregasi::className(), 'targetAttribute' => ['id_agregasi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_agregasi' => 'Id Agregasi',
            'kode_kemas' => 'Kode Kemas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgregasi()
    {
        return $this->hasOne(Agregasi::className(), ['id' => 'id_agregasi']);
    }
}
