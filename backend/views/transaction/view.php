<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Karton */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Solds', 'url' => ['transaction/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default">
<div class="karton-view">
    <div class="box-header text-right">
    <p>
        <?php //Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php // Html::a('Delete', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
    </p>
    </div>
    <div class="box-body">
        
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_karton',
            'nama_produk',
            'deskripsi',
            'no_nie',
            'no_batch',
            'tanggal_produksi',
            'tanggal_ed',
            'last_updated_by',
            'created_at',
            'last_updated_date',
        ],
    ]) ?>
    <br/>
    <div class="table table-striped">
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getKemas(),
            'pagination' => false,
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'id_kemas',
        ]
    ])?>
    </div>
    </div>

</div>
</div>

