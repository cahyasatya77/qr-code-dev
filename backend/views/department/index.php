<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="box box-primary">
        <div class="box-header">
        <div class="text-right">
            <p><?= Html::button('Create', ['value' => Url::to('create'),'class' => 'btn btn-success', 'id' => 'modalButton']) ?></p>
        </div>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'emptyCell' => ' ',
                'summary' => "Data {begin} - {end} sampai {totalCount}.",
                'layout' => "{pager}\n{summary}\n{items}",
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'kd_dept',
                    'nm_dept',

                    [
                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{view} {update}',
//                        'buttons' => [
//                            'view' => function ($url, $model) {
//                                 return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', FALSE , ['value' => Url::to(['view','id'=>$model->kd_dept]) ,'class' => 'view', 'id' => 'modalView']);
//                            },
//                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php
 Modal::begin([
     'header' => '<h3>Create Department</h3>',
     'id' => 'modal',
     'size' => 'modal-md',
 ]);
 echo "<div id='modalContent'></div>";
 Modal::end();
?>

<?php
Modal::begin([
    'header' => 'tes',
    'id' => 'modalview',
    'size' => 'modal-md',
]);
echo "<div id='modalDetail'></div>";
Modal::end();
?>

<?php
$script = <<< JS
    $(function(){
	$('#modalView').click(function (){
		$('#modalview').modal('show')
			.find('#modalDetail')
			.load($(this).attr('value'));
	});
    });
JS;
$this->registerJs($script);
?>