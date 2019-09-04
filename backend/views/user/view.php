<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = 'View User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="table-responsive">
<div class="box box-success">
<div class="user-view">
    <div class="box-header">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Cancel', ['/user/index'], ['class' => 'btn btn-default'])?>
    </p>
    </div>
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'name',
            [
                'attribute' => 'kd_dept',
                'value' => function($data){
                    return $data->department->nm_dept;
                }
            ],
            'auth_key',
            'password_hash',
            'email:email',
            'level_access',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 10 ? 'Aktif' : 'Non Aktif';
                }
            ],
            [
                'label' => 'Create At',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d M, Y');
                }
                ],
            'updated_at:datetime',
        ],
    ]) ?>
    </div>
</div>
</div>
</div>