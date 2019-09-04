<?php

namespace backend\modules\api\models;

use Yii;

/**
 * This is the model class for table "sample_dus".
 *
 * @property int $id
 * @property string $id_karton
 * @property string $id_kemas
 * @property string $kd_produk
 * @property string $nama_produk
 * @property string $no_batch
 * @property string $no_nie
 * @property string $kemasan
 * @property string $deskripsi
 * @property string $tanggal_ed
 * @property string $tanggal_produksi
 * @property string $is_active
 * @property string $is_sample
 * @property string $is_sold
 * @property string $is_reject
 * @property string $create_at
 * @property int $last_updated_by
 * @property string $last_updated_date
 */
class Sampledus extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sample_dus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_karton', 'id_kemas', 'kd_produk', 'nama_produk', 'no_batch', 'no_nie', 'kemasan', 'deskripsi', 'tanggal_ed', 'is_active', 'is_sample', 'is_sold', 'is_reject', 'create_at', 'last_updated_by', 'last_updated_date'], 'required'],
            [['deskripsi'], 'string'],
            [['tanggal_ed', 'tanggal_produksi', 'create_at', 'last_updated_date'], 'safe'],
            [['last_updated_by'], 'integer'],
            [['id_karton', 'id_kemas', 'no_nie', 'kemasan'], 'string', 'max' => 100],
            [['kd_produk', 'nama_produk', 'no_batch'], 'string', 'max' => 20],
            [['is_active', 'is_sample', 'is_sold', 'is_reject'], 'string', 'max' => 10],
            [['id_kemas'], 'unique'],
        ];
    }
    
    /**
     * Scenario create validation
     */
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['id_kemas'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_karton' => 'Id Karton',
            'id_kemas' => 'Id Kemas',
            'kd_produk' => 'Kd Produk',
            'nama_produk' => 'Nama Produk',
            'no_batch' => 'No Batch',
            'no_nie' => 'No Nie',
            'kemasan' => 'Kemasan',
            'deskripsi' => 'Deskripsi',
            'tanggal_ed' => 'Tanggal Ed',
            'tanggal_produksi' => 'Tanggal Produksi',
            'is_active' => 'Is Active',
            'is_sample' => 'Is Sample',
            'is_sold' => 'Is Sold',
            'is_reject' => 'Is Reject',
            'create_at' => 'Create At',
            'last_updated_by' => 'Last Updated By',
            'last_updated_date' => 'Last Updated Date',
        ];
    }
}
