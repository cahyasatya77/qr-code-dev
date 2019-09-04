<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "kode_karton".
 *
 * @property int $id
 * @property string $kode
 * @property string $rand_char
 * @property string $no_nie
 * @property string $created_at
 * @property int $created_by
 */
class Kodekarton extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kode_karton';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'rand_char', 'no_nie', 'no_batch', 'expired_date', 'isi', 'jumlah'], 'required'],
            [['created_at', 'created_by', 'id_parent'], 'safe'],
            [['created_by', 'jumlah', 'id_parent'], 'integer'],
            [['kode'], 'string', 'max' => 100],
            [['rand_char'], 'string', 'max' => 10],
            [['expired_date', 'no_batch'], 'string', 'max' => 20],
            [['no_nie', 'isi'], 'string', 'max' => 50],
            [['kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'rand_char' => 'Rand Char',
            'no_nie' => 'No Nie',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
    
    /**
     * Generate kode karton
     */
    public function generateKode($kode)
    {
        $_i = $kode;
        $_left = $_i;
        $_first = '0000001';
        $_len = strlen($_left);
        $no = $_left . $_first;
                
        $last_po = $this->find()
                ->select('kode')
                ->where('left(kode,'.$_len.')=:_left')
                ->params([':_left' => $_left])
                ->orderBy('kode DESC')
                ->one();
                
        if($last_po != null){
            $_no = substr($last_po->kode, $_len);
            $_no++;
            $_no = sprintf('%07s',$_no);
            $no = $_left . $_no;
        }
        return $no;
    }
}
