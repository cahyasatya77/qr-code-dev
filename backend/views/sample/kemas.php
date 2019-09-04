<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\KemasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sample Dus';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event){
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title')
        var href = button.attr('href')
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spiner fa-spin\"</i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
        });
    })
");
?>

<div class="box box-primary table-responsive">
<div class="kemas-sample">
    <div class="box-header">
        <p><?php echo $this->render('_search', ['model' => $searchModel]);?></p>
    </div>
    
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                [
                    'attribute' => 'id_karton',
                    'value' => 'karton.id_karton',
                ],
                [
                    'attribute' => 'id_kemas',
                ],
                [
                    'attribute' => 'nama_produk',
                    'value' => 'karton.nama_produk',
                ],
                
                [
                    'header' => 'Status',
                    'format' => 'raw',
                    'value' => function ($data) {
                            return Html::a('<button class="btn btn-danger btn-xs" id="statusKemas">status</button>',
                                    [
                                        'status',
                                        'id' => $data->id
                                    ],
                                    [
                                        'data-toggle' => "modal",
                                        'data-target' => "#myModal",
                                        'data-title' => "Status Kemasan",
                                    ]
                                    );
                    }
                ]
            ],
        ]);?>
    </div>
</div>
</div>

<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">...</h4>',
    'size'=>'modal-sm'
]);
echo '...';
Modal::end();
?>