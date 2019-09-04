<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Agregasiheader;
use backend\models\Agregasiline;

/**
 * AgregasiheaderSearch represents the model behind the search form of `backend\models\Agregasiheader`.
 */
class AgregasiheaderSearch extends Agregasiheader
{
    public $discharge_date;
    public $kode_kemas;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['kode_karton', 'no_nie', 'no_batch', 'expired_date',
              'created_at', 'updated_at', 'discharge_date', 'kode_kemas'], 'safe'],
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
        $query = Agregasiheader::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if ($this->kode_karton == null) {
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

        $query->andFilterWhere(['like', 'CONCAT(kode_karton,rand_char)', $this->kode_karton])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'expired_date', $this->expired_date]);

        return $dataProvider;
    }
    
    public function searchSold($params)
    {
        $query = Agregasiheader::find();
        $query->joinWith('agregasiLines')->where(['agregasi_line.is_sold' => 'TRUE']);
        $query->limit(20);
        $query->orderBy(['updated_at' => SORT_DESC]);
        
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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'kode_karton', $this->kode_karton])
            ->andFilterWhere(['like', 'no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'expired_date', $this->expired_date]);

        return $dataProvider;
    }
    
    public function searchLine($params)
    {
        $query = Agregasiline::find();
        $query->joinWith('agregasi');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if ($this->discharge_date == null) {
//        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'agregasi_header.kode_karton', $this->kode_karton])
            ->andFilterWhere(['like', 'agregasi_header.no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'agregasi_header.no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'agregasi_header.expired_date', $this->expired_date]);

        if (!is_null($this->discharge_date) && strpos($this->discharge_date, ' - ') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->discharge_date);
            $query->andFilterWhere(['between', 'created_at', $start_date, $end_date]);
            $this->discharge_date = null;
        }
        
        return $dataProvider;
    }
    
    public function searchRemove($params)
    {
        $query = Agregasiline::find();
        $query->joinWith('agregasi');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        //if ($this->no_nie == null && $this->no_batch == null) {
        if ($this->kode_kemas == null) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'agregasi_header.kode_karton', $this->kode_karton])
            ->andFilterWhere(['like', 'agregasi_header.no_nie', $this->no_nie])
            ->andFilterWhere(['like', 'agregasi_header.no_batch', $this->no_batch])
            ->andFilterWhere(['like', 'kode_kemas', $this->kode_kemas]);

        
        return $dataProvider;
    }
}
