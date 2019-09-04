<?php

namespace backend\models;

use yii\base\Model;


/**
 * Model Sample QC Statis
 */
class Sample extends Model
{
    public $kd_produk;
    public $no_batch;
    public $no_nie;
    public $kemasan;
    public $tanggal_ed;
    public $deskripsi;
    public $nama_produk;
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return[
            [['kd_produk','no_batch','no_nie','kemasan','tanggal_ed','deskripsi'],'required'],
            [['nama_produk'],'safe'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'kd_produk' => 'Nama Produk',
            'no_batch' => 'No Batch',
            'no_nie' => 'No NIE',
            'kemasan' => 'Kemasan',
            'tanggal_ed' => 'Tanggal ED',
            'deskripsi' => 'Deskripsi',
        ];
    }
}
