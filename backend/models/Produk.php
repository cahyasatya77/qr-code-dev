<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_produk".
 *
 * @property string $kd_produk
 * @property string $nama_produk
 * @property string $deskripsi
 * @property string $bentuk_sediaan
 * @property string $bentuk_sed_berkas
 * @property string $klasifikasi_farmakologi
 * @property int $batch_size
 * @property string $ringkasan_riwayat
 * @property int $dok_reg_masa_edar
 * @property int $aktual_masa_edar
 * @property string $status
 * @property int $last_updated_by
 * @property string $last_updated_date
 */
class Produk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{coba_product_management_2}}.{{tbl_produk}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pm');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_produk'], 'required'],
            [['deskripsi', 'ringkasan_riwayat'], 'string'],
            [['batch_size', 'dok_reg_masa_edar', 'aktual_masa_edar', 'last_updated_by'], 'integer'],
            [['last_updated_date'], 'safe'],
            [['kd_produk'], 'string', 'max' => 10],
            [['nama_produk', 'bentuk_sed_berkas', 'klasifikasi_farmakologi'], 'string', 'max' => 50],
            [['bentuk_sediaan', 'status'], 'string', 'max' => 20],
            [['kd_produk'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => TblUser::className(), 'targetAttribute' => ['last_updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_produk' => 'Kd Produk',
            'nama_produk' => 'Nama Produk',
            'deskripsi' => 'Deskripsi',
            'bentuk_sediaan' => 'Bentuk Sediaan',
            'bentuk_sed_berkas' => 'Bentuk Sed Berkas',
            'klasifikasi_farmakologi' => 'Klasifikasi Farmakologi',
            'batch_size' => 'Batch Size',
            'ringkasan_riwayat' => 'Ringkasan Riwayat',
            'dok_reg_masa_edar' => 'Dok Reg Masa Edar',
            'aktual_masa_edar' => 'Aktual Masa Edar',
            'status' => 'Status',
            'last_updated_by' => 'Last Updated By',
            'last_updated_date' => 'Last Updated Date',
        ];
    }
}
