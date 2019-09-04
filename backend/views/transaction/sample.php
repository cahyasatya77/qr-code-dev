<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\helpers\Url;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dataKemasan = ArrayHelper::map($kemasan, 'id', 'kode_kemas');

$this->title = 'Sample Kemasan';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
        <div class="col-md-6">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Tab 1</a></li>
              <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">

                <?= $this->render('_form_sample_1', [
                    'model' => $model,
                    'kemasan' => $kemasan,
                ])?>
                  
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                  
<!--                <? = $this->render('_form_sample_2', [
                    'model' => $model,
                    'kemasan' => $kemasan,
                ])?>-->
                  
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->

        
        <!-- /.col -->
      </div>

<!--<div class="row">

</div>-->

<div class="row">
<div class="col-md-12">
<div class="box box-success">
    <div class="box-header">
        <h4>List Sample Dus</h4>
    </div>
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $sampleDus,
            'filterModel' => $searchDus,
            'summary' => false,
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                
                [
                    'attribute' => 'nama_produk',
                    'value' => 'agregasi.produk.nama_produk'
                ],
                [
                    'attribute' => 'kode_karton',
                    'value' => 'agregasi.kode_karton'
                ],
                'kode_kemas',
                
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{myButton}',
                    'buttons' => [
                        'myButton' => function ($url) {
                            return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', $url, [
                                'title' => Yii::t('app', 'Return'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want return sample ?'),
                                'data-method' => 'post'
                            ]);
                        }
                    ],
                    'urlCreator' => function($action, $model) {
                        if ($action === 'myButton') {
                            $url = Url::to(['transaction/returnsample', 'id' => $model->id]);
                            return $url;
                        }
                    }
                ],
            ],
        ])?>
    </div>
</div>
</div>
</div>