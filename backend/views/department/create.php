<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Department */

$this->title = 'Create Department';
$this->params['breadcrumbs'][] = ['label' => 'Departments','icon'=>'dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<!--<div class="col-md-6">-->
<div class="box box-primary">
<div class="department-create">
    <div class="box-header">
        <h3 class="box-title"><?php echo $this->title ;?></h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
<!--</div>-->
</div>