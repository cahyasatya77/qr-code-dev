<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Agregasi;
use backend\models\Agregasidetail;

/**
 * AgregasiSearch represents the model behind the search form of `backend\models\Agregasi`.
 */
class AgregasiSearch extends Agregasi
{
    public $nama_produk;
    public $kode_kemas;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['kode_karton', 'no_nie', 'no_batch', 'created_at', 'updated_at', 'nama_produk', 'kode_kemas'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Agregasi::find();
        $query->joinWith('produk');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['nama_produk'] = [
            'asc' => ['tbl_produk.nama_produk' => SORT_ASC],
            'desc' => ['tbl_produk.nama_produk' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'kode_karton', $this->kode_karton])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'nama_produk', $this->nama_produk]);

        return $dataProvider;
    }
    
    public function searchSold($params)
    {
        $query = Agregasi::find();
        $query->joinWith('produk');
        $query->joinWith('agregasiDetails');
        $query->where(['is_sold' => 'TRUE']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['nama_produk'] = [
            'asc' => ['tbl_produk.nama_produk' => SORT_ASC],
            'desc' => ['tbl_produk.nama_produk' => SORT_DESC],
        ];

        $this->load($params);

        if (empty($this->nama_produk) and empty($this->kode_karton)) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'kode_karton', $this->kode_karton])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'nama_produk', $this->nama_produk]);

        return $dataProvider;
    }
    
    public function searchSample($params)
    {
        $query = Agregasidetail::find();
        $query->joinWith('agregasi');
        $query->joinWith('agregasi.produk');
        $query->where(['is_sample' => 'TRUE']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (empty($this->nama_produk) and empty($this->kode_karton) and empty($this->kode_kemas)) {
            $query->where('0=1');
            return $dataProvider;
        }
        // if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // return $dataProvider;
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'agregasi.kode_karton', $this->kode_karton])
            ->andFilterWhere(['like', 'kode_kemas', $this->kode_kemas])
            ->andFilterWhere(['like', 'tbl_produk.nama_produk', $this->nama_produk]);

        return $dataProvider;
    }
}
