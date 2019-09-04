<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agregasi_line".
 *
 * @property int $id
 * @property int $id_agregasi
 * @property string $kode_kemas
 * @property string $is_active
 * @property string $is_sample
 * @property string $is_sold
 *
 * @property AgregasiHeader $agregasi
 */
class Agregasiline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agregasi_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_kemas'], 'required'],
            [['id_agregasi'], 'integer'],
            [['kode_kemas'], 'string', 'min' => 51, 'max' => 51],
            [['kode_kemas'], 'unique'],
            [['is_active', 'is_sample', 'is_sold'], 'string', 'max' => 10],
            ['is_active', 'default', 'value' => 'TRUE'],
            ['is_sample','default', 'value' => 'FALSE'],
            ['is_sold','default', 'value' => 'FALSE'],
            // [['id_agregasi'], 'exist', 'skipOnError' => true, 'targetClass' => AgregasiHeader::className(), 'targetAttribute' => ['id_agregasi' => 'id']],
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
            'is_active' => 'Is Active',
            'is_sample' => 'Is Sample',
            'is_sold' => 'Is Sold',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgregasi()
    {
        return $this->hasOne(AgregasiHeader::className(), ['id' => 'id_agregasi']);
    }
}
