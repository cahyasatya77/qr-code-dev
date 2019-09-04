<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Agregasiheader */

$this->title = $model->no_nie;
$this->params['breadcrumbs'][] = ['label' => 'Agregasiheaders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default">
<div class="agregasiheader-view">
    <div class="box-header">
        <div class="col-md-6">
            <h4>Detail Karton</h4>
        </div>
        <div class="col-md-6 text-right">
            <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-warning'])?>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-2">
            <img src="<?= Url::to(['agregasiheader/qrcode', 'id' => $model->id])?>">
        </div>
        <div class="col-md-10">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'kode_karton',
                    [
                        'label' => 'Nama Produk',
                        'value' => $model->produk->nama_produk
                    ],
                    'no_nie',
                    'no_batch',
                    'expired_date',
                ],
            ]) ?>
        </div>
    </div>
</div>
</div>

<div class="box box-info">
    <div class="box-header">
        <h4>List Dus dalam Karton</h4>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $model_detail,
            'columns' => [
                ['class' => 'yii\grid\serialColumn'],
                
                'kode_kemas'
            ],
        ])?>
    </div>
    <div class="box-footer text-right">
        <?= Html::a('<button class="btn btn-danger">Kembali</button>',['index'])?>
    </div>
</div>