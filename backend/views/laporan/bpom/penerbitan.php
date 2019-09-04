<?php

 use yii\bootstrap\Html;
 use kartik\grid\GridView;
 use yii\helpers\Url;
 use yii\bootstrap\Modal;
 use yii\widgets\Pjax;
 
 /* @var $this yii\web\View */
 /* @var $searchModel backend\models\KodekemasSearch */
 /* @var $dataProvider yii\data\ActiveDataProvider */
 
 $this->title = 'Penerbitan QR-Code';
 $this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?= $this->render('search_penerbitan', ['model' => $searchModel]);?>
    </div>
</div>

<?php
    $gridColumns = [
        [
            'header' => 'ID Kemasan',
            'value' => function ($model) {
                $sql = "SELECT kemasan, status FROM tbl_nie WHERE nomor_nie = '".$model->agregasi->no_nie."' AND status = 1";
                $data = Yii::$app->db_pm->createCommand($sql)->queryOne();
                return $data['kemasan'];
            }
        ],
        [
            'header' => 'Barcode',
            'value' => 'kode_kemas',
        ],
        [
            'header' => 'NIE',
            'value' => function ($model) {
                return $model->agregasi->no_nie;
            }
        ],
        [
            'header' => 'Lot No',
            'value' => function ($model) {
                return $model->agregasi->no_batch;
            }
        ],
        [
            'header' => 'Exp Date',
            'value' => function ($model) {
                $date = $model->agregasi->expired_date;
                $day = substr($date, 4,2);
                $month = substr($date, 2, 2);
                $year = substr($date, 0, 2);

                $newDate = $month.'/'.$day.'/20'.$year;
                return $newDate;
            },
        ],
        [
            'header' => 'Latitude',
            'value' => function($model) {
                return '0';
            },
        ],
        [
            'header' => 'Longitude',
            'value' => function($model) {
                return '0';
            },
        ],
        [
            'header' => 'Batch No',
            'value' => function($model) {
                return $model->agregasi->no_batch;
            },
        ],
        [
            'header' => 'Gtin',
            'value' => function($model) {
                return 'GTIN123';
            },
        ],
        [
            'header' => 'is Active',
            'value' => 'is_active',
        ],
        [
            'header' => 'is Sample',
            'value' => 'is_sample',
        ],
        [
            'header' => 'is Sold',
            'value' => 'is_sold',
        ],
        [
            'header' => 'Mfg Date',
            'value' => function ($model) {
                return '';
            }
        ],
        [
            'header' => 'Parent Sekunder',
            'value' => function ($model) {
                return $model->agregasi->kode_karton;
            }
        ],
        [
            'header' => 'Parent Tersier',
            'value' => function ($model) {
                return '';
            }
        ],
    ];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'export' => [
        'fontAwesome' => true,
    ],
    'exportConfig' => [
        GridView::EXCEL => [
            'label' => 'Excel',
            'filename' => 'Penerbitan Qr-code',
        ],
    ],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
    ],
]);?>
