<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "agregasi_header".
 *
 * @property int $id
 * @property string $kode_karton
 * @property string $no_nie
 * @property string $no_batch
 * @property string $expired_date
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property AgregasiLine[] $agregasiLines
 */
class Agregasiheader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agregasi_header';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_karton', 'no_nie', 'no_batch', 'expired_date', 'isi'], 'required'],
            [['kode_karton'], 'unique'],
            [['rand_char', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['kode_karton', 'isi'], 'string', 'max' => 100],
            [['no_nie'], 'string', 'max' => 50],
            [['rand_char'], 'string', 'max' => 50],
            [['no_batch', 'expired_date'], 'string', 'max' => 20],
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
            'no_nie' => 'No Nie',
            'no_batch' => 'No Batch',
            'expired_date' => 'Expired Date',
            'isi' => 'Isi',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'rand_char' => 'Random Character',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgregasiLines()
    {
        return $this->hasMany(AgregasiLine::className(), ['id_agregasi' => 'id']);
    }
    
    public function getProduk()
    {
        return $this->hasOne(Produk::className(), ['kd_produk' => 'kd_produk'])
                ->viaTable(Yii::$app->params['db_name_2'].'.'.Nie::tableName(), ['nomor_nie' => 'no_nie']);
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
                ->select('kode_karton')
                ->where('left(kode_karton,'.$_len.')=:_left')
                ->params([':_left' => $_left])
                ->orderBy('kode_karton DESC')
                ->one();
                
        if($last_po != null){
            $_no = substr($last_po->kode_karton, $_len);
            $_no++;
            $_no = sprintf('%07s',$_no);
            $no = $_left . $_no;
        }
        return $no;
    }
}
