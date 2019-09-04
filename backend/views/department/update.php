<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */

$this->title = 'Update Department: ' . $model->kd_dept;
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kd_dept, 'url' => ['view', 'id' => $model->kd_dept]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-md-6">
<div class="box box-danger">
<div class="department-update">
    <div class="box-header">
        <h3 class="box-title"><?php echo $this->title ;?></h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
