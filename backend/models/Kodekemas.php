<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "kode_kemas".
 *
 * @property int $id
 * @property string $kode
 * @property string $rand_char
 * @property string $no_nie
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Kodekemas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kode_kemas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'rand_char', 'no_nie'], 'required'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['kode'], 'string', 'max' => 100],
            [['rand_char'], 'string', 'max' => 10],
            [['no_nie'], 'string', 'max' => 50],
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
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    
    public function generateKode($id)
    {
        //$_d = date("ymd");
        $_i = $id;
        $_left = $_i;
        $_first = '025001';
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
            $_no = sprintf('%06s',$_no);
            $no = $_left . $_no;
        }
        return $no;
    }
}
