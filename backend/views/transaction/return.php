<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$data_karton = ArrayHelper::map($karton, 'id', 'id_karton');

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
<div class="col-md-6">
<div class="box box-danger transaction-return">
    <div class="box-header">
        <h3>Return Karton</h3>
    </div>
    <?php $form = ActiveForm::begin();?>
    <div class="box-body">
        
        <?= $form->field($model, 'code_karton')->widget(Select2::className(),[
            'data' => $data_karton,
            'options' => [
                'placeholder' => 'Select a stase ...'
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);?>
        
    </div>
    <div class="box-footer form-group">
        <?= Html::submitButton('Return', ['class' => 'btn btn-danger']);?>
    </div>
    <?php ActiveForm::end();?>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="box box-default table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'id_karton',
            'nama_produk',
            'no_batch',
            [
                'attribute' => 'tanggal_ed',
                'filter' => \backend\models\KartonSearch::getYearsList(),
            ],
            
            [
                'header' => 'Details',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]);?>
</div>
</div>
</div>