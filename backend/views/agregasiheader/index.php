<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AgregasiheaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agregasi';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <?= Html::a('<i class="fa fa-plus"></i> Create Agregasi', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]);?>
            
            <div class="box-body">
                <?= $form->field($searchModel, 'kode_karton')->textInput(['maxlength' => true]);?>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']);?>
                </div>
            </div>
            
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="agregasiheader-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box-header">
        <h4>List Karton</h4>
    </div>
    <div class="box-body">
        <div class="table table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'kode_karton',
                        'value' => function ($data) {
                            return $data->kode_karton.$data->rand_char;
                        }
                    ],
                    'no_nie',
                    'no_batch',
                    'expired_date',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    ],
                    [
                        'header' => '',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('<button class="btn btn-warning btn-xs">update</button>',
                                    ['agregasiheader/create-detail', 'id' => $data->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
    
</div>
</div>
</div>
</div>
