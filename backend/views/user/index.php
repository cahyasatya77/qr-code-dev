<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table table-responsive">
<div class="box box-primary">
<div class="user-index">
    <div class="box-header">
        <div class="text-left">
            <?= Html::button('Create User', ['value' => Url::to('signup'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
        </div>
    </div>
    <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'name',
            [
                'attribute' => 'kd_dept',
                'value' => 'department.nm_dept',
//                function ($data){
//                    return $data->department->nm_dept;
//                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}'
            ],
        ],
    ]); ?>
    </div>
</div>
</div>
</div>

<?php
 Modal::begin([
     'header' => '<h3>SignUp</h3>',
     'id' => 'modal',
     'size' => 'modal-md',
 ]);
 echo "<div id='modalContent'></div>";
 Modal::end();
?>
