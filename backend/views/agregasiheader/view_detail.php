<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Agregasiheader */
/* @var $model_detail backend\models\Agregasiline */

$this->title = $model->no_nie;
$this->params['breadcrumbs'][] = ['label' => 'Agregasi', 'url' => ['create-detail', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-default">
    <div class="box-header">
        <div class="col-md-6">
            <h4>Detail Karton</h4>
        </div>
        <div class="col-md-6 text-right">
            <?= Html::a('Kembali', ['create-detail', 'id' => $model->id], ['class' => 'btn btn-warning'])?>
        </div>
    </div>
    <div class="box-body">
        <div class="col-md-2">
            <img src="<?= Url::to(['agregasiheader/qrcode', 'id' => $model->id])?>">
        </div>
        <div class="col-md-10">
            <div class="table table-responsive">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'kode_karton',
                        [
                            'label' => 'Nama Produk',
                            'value' => $model->produk->nama_produk,
                        ], 
                        'no_nie',
                        'no_batch',
                        'expired_date',
                    ],
                ]);?>
            </div>
        </div>
    </div>
</div>

<div class="box box-info">
    <div class="box-header">
        <h4>List Qr code dus dalam karton</h4>
    </div>
    <div class="box-body">
        <div class="table table-responsive">
            <?= GridView::widget([
                'dataProvider' => $model_detail,
                'columns' => [
                    ['class' => 'yii\grid\serialColumn'],

                    'kode_kemas',

                    [
                        'header' => 'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{myButton}',
                        'buttons' => [
                            'myButton' => function($url) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url,[
                                    'title' => Yii::t('app', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete ?'),
                                    'data-method' => 'post', 'data-pjax' => '0',
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'myButton') {
                                $url = Url::to(['agregasiheader/deletedetail', 'id' => $model->id_agregasi, 'del' => $model->id]);
                                return $url;
                            }
                        }
                    ],
                ],
            ]);?>
        </div>
    </div>
</div>