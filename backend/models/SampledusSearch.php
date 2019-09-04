<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SampleDus;

/**
 * SampledusSearch represents the model behind the search form of `backend\models\SampleDus`.
 */
class SampledusSearch extends SampleDus
{
    public $date_range;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'last_updated_by'], 'integer'],
            [['id_karton', 'id_kemas', 'kd_produk', 'nama_produk', 'no_batch', 'no_nie', 'kemasan', 'deskripsi', 'tanggal_ed',
              'tanggal_produksi', 'create_at', 'last_updated_date', 'date_range'], 'safe'],
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
        $query = SampleDus::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_ed' => $this->tanggal_ed,
            'tanggal_produksi' => $this->tanggal_produksi,
            'create_at' => $this->create_at,
            'last_updated_by' => $this->last_updated_by,
            'last_updated_date' => $this->last_updated_date,
        ]);

        $query->andFilterWhere(['like', 'id_karton', $this->id_karton])
            ->andFilterWhere(['like', 'id_kemas', $this->id_kemas])
            ->andFilterWhere(['like', 'kd_produk', $this->kd_produk])
            ->andFilterWhere(['like', 'nama_produk', $this->nama_produk])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'kemasan', $this->kemasan])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi]);

        if (!is_null($this->date_range) && strpos($this->date_range, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->date_range);
            $query->andFilterWhere(['between', 'create_at', $start_date, $end_date]);
            $this->date_range = null;
        }
        
        return $dataProvider;
    }
    
    /**
     * Creates data provider instancw with search query applied
     * 
     * @param array $params
     * 
     * @return ActiveDataProvider
     */
    public function searchLaporan($params)
    {
        $query = SampleDus::find();
        
        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if ($this->date_range ==  null) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'no_nie' => $this->no_nie,
            'no_batch' => $this->no_batch,
        ]);
        
        $query->andFilterWhere(['like', 'no_nie', $this->no_nie])
              ->andFilterWhere(['like', 'no_batch', $this->no_batch]);
        
        if (!is_null($this->date_range) && strpos($this->date_range, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->date_range);
            $query->andFilterWhere(['between', 'create_at', $start_date, $end_date]);
            $this->date_range = null;
        }
    }
}
