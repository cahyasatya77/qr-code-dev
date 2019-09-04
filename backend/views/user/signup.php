<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use backend\models\Department;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="col-md-6">-->
<div class="box box-primary">
<div class="site-signup">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="box-body">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                
                <?= $form->field($model, 'password')->passwordInput() ?>
                
                <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

                <?= $form->field($model, 'email') ?>
            
                <?php 
                $department = Department::find()->all();
                $listdata=  ArrayHelper::map($department, 'kd_dept', 'nm_dept');
                echo $form->field($model, 'kd_dept')->dropDownList($listdata,['prompt'=>'Select....']);?>
                
                <?php 
                $data_access=  ['user' => 'User', 'key_user' => 'Key User', 'administrator' => 'Administrator'];
                echo $form->field($model, 'level_access')->dropDownList($data_access,['prompt'=>'Select....']);?>
                
            </div>
                <div class="box-footer text-right">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
</div>
</div>
<!--</div>-->
