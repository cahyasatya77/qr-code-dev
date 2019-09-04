<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agregasi".
 *
 * @property int $id
 * @property string $kode_karton
 * @property string $no_nie
 * @property string $no_batch
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property AgregasiDetail[] $agregasiDetails
 */
class Agregasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agregasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_karton', 'no_nie', 'no_batch', 'expired_date'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['kode_karton'], 'string', 'max' => 100],
            [['no_nie'], 'string', 'max' => 50],
            [['no_batch', 'expired_date'], 'string', 'max' => 20],
            [['kode_karton'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_karton' => 'Kode Karton',
            'no_nie' => 'Nomor NIE',
            'no_batch' => 'Nomor Batch',
            'expired_date' => 'Expired Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgregasiDetails()
    {
        return $this->hasMany(Agregasidetail::className(), ['id_agregasi' => 'id']);
    }
    
    public function getProduk()
    {
        return $this->hasOne(Produk::className(), ['kd_produk' => 'kd_produk'])
                ->viaTable(Yii::$app->params['db_name_2'].'.'.Nie::tableName(), ['nomor_nie' => 'no_nie']);
    }
}
