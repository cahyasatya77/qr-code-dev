<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "karton".
 *
 * @property int $id
 * @property string $id_karton
 * @property string $nama_produk
 * @property string $deskripsi
 * @property string $no_nie
 * @property string $no_batch
 * @property string $tanggal_produksi
 * @property string $tanggal_ed
 * @property int $last_updated_by
 * @property string $created_at
 * @property string $last_updated_date
 *
 * @property Kemas[] $kemas
 */
class Karton extends \yii\db\ActiveRecord
{
    use \mdm\behaviors\ar\RelationTrait;
    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'karton';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_karton', 'id_produk',  'no_batch', 'tanggal_ed'], 'required'],
            [['id_rekanan', 'no_lot', 'latitude', 'longitude', 'no_gtin','nama_produk','kemasan','no_nie','deskripsi','tanggal_produksi', 'tanggal_ed', 'created_at', 'last_updated_date'], 'safe'],
            [['last_updated_by'], 'integer'],
            [['id_karton', 'nama_produk', 'kemasan'], 'string', 'max' => 100],
            [['no_nie', 'no_lot'], 'string', 'max' => 50],
            [['no_batch', 'latitude', 'longtitude', 'no_gtin'], 'string', 'max' => 20],
            ['id_rekanan', 'default', 'value' => '361'],
            [['id_karton'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_karton' => 'Id Karton',
            'id_produk' => 'Id Produk',
            'id_rekanan' => 'Id Rekanan',
            'nama_produk' => 'Nama Produk',
            'deskripsi' => 'Deskripsi',
            'no_nie' => 'No Nie',
            'no_lot' => 'No Lot',
            'no_batch' => 'No Batch',
            'kemasan' => 'Kemasan',
            'tanggal_produksi' => 'Tanggal Produksi',
            'tanggal_ed' => 'Tanggal ED',
            'latitude' => 'Latitude',
            'longtitude' => 'Longtitude',
            'no_gtin' => 'No Gtin',
            'last_updated_by' => 'Last Updated By',
            'created_at' => 'Created At',
            'last_updated_date' => 'Last Updated Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduk()
    {
        return $this->hasOne(Produk::className(), ['kd_produk' => 'nama_produk']);
    }

    public function getKemas()
    {
        return $this->hasMany(Kemas::className(), ['id_karton' => 'id']);
    }
    
    public function getLastupdatedby()
    {
        return $this->hasOne(User::className(), ['id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function setKemas($value)
    {
        $this->loadRelated('kemas', $value);
    }
}
