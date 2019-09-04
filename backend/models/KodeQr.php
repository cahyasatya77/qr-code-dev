<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "kode_qr".
 *
 * @property int $id_qr
 * @property string $kode_item
 * @property string $no_nie
 * @property string $no_batch
 * @property string $expired_date
 */
class KodeQr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kode_qr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_item', 'no_batch','kode_produk'], 'required'],
            [['expired_date, rand_char'], 'safe'],
            [['kode_item', 'no_batch'], 'string', 'max' => 50],
            [['no_nie'], 'string', 'max' => 20],
//            [['rand_char'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_qr' => 'Id Qr',
            'kode_item' => 'Kode Item',
            'no_nie' => 'No Nie',
            'no_batch' => 'No Batch',
            'expired_date' => 'Expired Date',
        ];
    }
    
    /*
     * Generate Kode
     */
    
    public function generateKode($id)
    {
        $_b = $id;
        $_left = $_b;
        $_first = '00001';
        $_len = strlen($_left);
        $no = $_left . $_first;
                
        $last_po = $this->find()
                ->select('kode_item')
                ->where('left(kode_item,'.$_len.')=:_left')
                ->params([':_left' => $_left])
                ->orderBy('kode_item DESC')
                ->one();
                
        if($last_po != null){
            $_no = substr($last_po->kode_item, $_len);
            $_no++;
            $_no = sprintf('%05s',$_no);
            $no = $_left . $_no;
        }
        return $no;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduk(){
        return $this->hasOne(Produk::className(), ['kd_produk' => 'kode_produk']);
    }
}
