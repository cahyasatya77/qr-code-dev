<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\KodeQr */

$this->title = 'List Data';
$this->params['breadcrumbs'][] = $this->title;

$nie = ArrayHelper::map($model_nie, 'nie', 'description');

?>

<div class="box box-primary">
    <div class="laporan-form">
        <div class="box-header">
            <?php // echo Html::a('<i class="glyphicon glyphicon-modal-window"></i> Generate', ['create'], ['class' => 'btn btn-primary']) ;?>
            
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Generate New', ['createnew'], ['class' => 'btn btn-success'])?>
        </div>
        <?php $form = ActiveForm::begin();?>
        <div class="box-body">
            <div class="col-md-6">
                <?= $form->field($model, 'nomor_nie')->widget(Select2::className(),[
                    'data' => $nie,
                    'options' => [
                        'placeholder' => '- Pilih NIE -',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'date')->widget(DatePicker::className(), [
                    'options' => [
                        'placeholder' => 'Enter Date Created',
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ])?>
            </div>
        </div>
        <div class="box-footer text-right">
            <?= Html::submitButton('Submit',['class' => 'btn btn-success', 'name' => 'generate-button'])?>
        </div>
        <?php ActiveForm::end();?>
    </div>
</div>

<?php if ($model->nomor_nie !== null) :?>
<div class="box box-success">
    <div class="box-header">
        <div class="btn-group">
            <?= Html::a('Export', ['report-laporan', 'nie' => $model->nomor_nie, 'date' => $model->date], ['class' => 'btn btn-success'])?>
            <?= Html::a('<i class="fa fa-refresh"></i> Refresh', ['laporan'], ['class' => 'btn btn-default'])?>
        </div>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $kode,
            'columns' => [
                [
                    'header' => 'Kode Kemasan',
                    'value' => function ($model) {
                        return $model->kode.$model->rand_char;
                    }
                ],
            ],
        ])?>
    </div>
</div>
<?php endif; ?>

