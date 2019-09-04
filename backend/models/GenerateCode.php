<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GenerateCode extends Model
{
    public $kode_produk;
    public $nomor_nie;
    public $nomor_batch;
    public $jumlah;
    public $expired_date;
    public $date;
    public $isi;

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CREATE = 'create';

    public function rules()
    {
        return [
            [['nomor_nie'],'required'],
            [['nomor_nie', 'jumlah', 'nomor_batch', 'expired_date', 'isi'], 'required', 'on' => self::SCENARIO_CREATE],
            [['nomor_nie', 'date'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['nomor_batch', 'jumlah', 'kode_produk', 'expired_date'],'safe'],
            [['jumlah'],'number'],
            // ['jumlah', 'compare', 'compareValue' => 10, 'operator' => '<=', 'type' => 'number'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode_produk' => 'Nama Produk',
            'nomor_nie' => 'Nomor NIE',
            'nomor_batch' => 'Nomor Batch',
            'jumlah' => 'Jumlah',
            'expired_date' => 'Tanggal Kadaluarsa',
            'date' => 'Tanggal',
            'isi' => 'Isi Karton',
        ];
    }
    
}
