<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;

/**
 * @var $this yii\web\View
 * @var $searchModel backend\models\SsampledusSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Penerbitan Sample dan Reject QR-Code';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <?php $form = ActiveForm::begin([
                'action' => ['penerbitansample'],
                'method' => 'get',
            ]);?>
            
            <div class="box-body">
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'no_nie');?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($searchModel, 'no_batch')?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($searchModel, 'date_range', [
                        'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                        'options' => ['class' => 'drp-container form-group'],
                    ])->widget(DateRangePicker::className(),[
                        'useWithAddon' => true,
                    ])->label('Date Range Sample/Reject');?>
                </div>
            </div>
            
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<?php
    $gridColumns = [
        [
            'header' => 'ID kemasan',
            'value' => function ($model) {
                $data = Yii::$app->runAction('laporan/produk', ['nie' => $model->no_nie]);
                return $data['kemasan'];
            }
        ],
        [
            'header' => 'Barcode',
            'value' => 'id_kemas',
        ],
        [
            'header' => 'NIE',
            'value' => 'no_nie',
        ],
        [
            'header' => 'Lot No',
            'value' => 'no_batch',
        ],
        [
            'header' => 'Exp date',
            'value' => function ($model){
                $date = $model->tanggal_ed;
                $date_now = date('m/d/Y', strtotime($date));
                return $date_now;
            }
        ],
        [
            'header' => 'Latitude',
            'value' => function($model) {
                return '0';
            }
        ],
        [
            'header' => 'Longtitude',
            'value' => function($model) {
                return '0';
            }
        ],
        [
            'header' => 'Batch No',
            'value' => 'no_batch'
        ],
        [
            'header' => 'Gtin',
            'value' => function ($model) {
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
            'header' => 'is Reject',
            'value' => 'is_reject',
        ],
        [
            'header' => 'is Sold',
            'value' => 'is_sold'
        ],
        [
            'header' => 'Mfg Date',
            'value' => function($model) {
                return '';
            }
        ],
        [
            'header' => 'Parent Sekunder',
            'value' => function($model) {
                return '';
            }
        ],
        [
            'header' => 'Parent Tersier',
            'value' => function ($model) {
                return '';
            },
        ],
    ];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'responsiveWrap' => false,
    'columns' => $gridColumns,
    'export' => [
        'fontAwesome' => true,
    ],
    'exportConfig' => [
        GridView::EXCEL => [
            'label' => 'Excel',
            'filename' => 'Penerbitan QR sampel/reject', 
        ],
        GridView::CSV => [
            'label' => 'CSV',
            'filename' => 'Penerbitan-QR-sample/reject',
            'config' => [
                'colDelimiter' => '',
                ''
            ],
        ],
    ],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
    ],
]);?>
