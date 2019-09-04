<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\KodekemasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kodekemas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
<div class="kodekemas-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box-header">
        <p>
            <?= Html::a('<i class="glyphicon glyphicon-modal-window"></i> Generate', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'summary' => false,
            'export' => [
                'fontAwesome' => true,
            ],
            'exportConfig' => [
                GridView::TEXT => [
                    'label' => 'Text',
                    'filename' => 'data',
                ],
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'Kode Kemasan',
                'mime' => 'text/plain',
                'config' => [
                    'colDelimiter' => null,
                    'rowDelimiter' => "\r\n",
//                    'enclosure' => '',
                ]
            ],
            'columns' => [

                [
                    'attribute' => 'kode',
                    'value' =>  function ($data) {
                        return $data->kode.$data->rand_char;
                    },
                ],
            ],
        ]); ?>
    </div>
</div>
</div>
