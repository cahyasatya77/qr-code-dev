<?php
use yii\helpers\Html;
use yii\grid\GridView;
//use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\Highstock;
use miloschuman\highcharts\SeriesDataHelper;
use yii\web\JsExpression;


$data = [
    ['date' => '2006-05-14 20:00:00', 'open' => 67.37, 'high' => 68.38, 'low' => 67.12, 'close' => 67.79, 'volume' => 18921051],
    ['date' => '2006-05-15 20:00:00', 'open' => 68.1, 'high' => 68.25, 'low' => 64.75, 'close' => 64.98, 'volume' => 33470860],
    ['date' => '2006-05-16 20:00:00', 'open' => 64.7, 'high' => 65.7, 'low' => 64.07, 'close' => 65.26, 'volume' => 26941146],
    ['date' => '2006-05-17 20:00:00', 'open' => 65.68, 'high' => 66.26, 'low' => 63.12, 'close' => 63.18, 'volume' => 23524811],
    ['date' => '2006-05-18 20:00:00', 'open' => 63.26, 'high' => 64.88, 'low' => 62.82, 'close' => 64.51, 'volume' => 35221586],
    ['date' => '2006-05-21 20:00:00', 'open' => 63.87, 'high' => 63.99, 'low' => 62.77, 'close' => 63.38, 'volume' => 25680800],
    ['date' => '2006-05-22 20:00:00', 'open' => 64.86, 'high' => 65.19, 'low' => 63, 'close' => 63.15, 'volume' => 24814061],
    ['date' => '2006-05-23 20:00:00', 'open' => 62.99, 'high' => 63.65, 'low' => 61.56, 'close' => 63.34, 'volume' => 32722949],
    ['date' => '2006-05-24 20:00:00', 'open' => 64.26, 'high' => 64.45, 'low' => 63.29, 'close' => 64.33, 'volume' => 16563319],
    ['date' => '2006-05-25 20:00:00', 'open' => 64.31, 'high' => 64.56, 'low' => 63.14, 'close' => 63.55, 'volume' => 15464811],
];

$dataPvd = new \yii\data\ArrayDataProvider(['allModels'=>$data])
?>
<div class="row">
    <div class="box box-danger">
        <?=Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    'options' => [
        'title' => [
            'text' => 'Combination chart',
        ],
        'xAxis' => [
            'categories' => ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'],
        ],
        'labels' => [
            'items' => [
                [
                    'html' => 'Total fruit consumption',
                    'style' => [
                        'left' => '50px',
                        'top' => '18px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        'series' => [
            [
                'type' => 'column',
                'name' => 'Jane',
                'data' => [3, 2, 1, 3, 4],
            ],
            [
                'type' => 'column',
                'name' => 'John',
                'data' => [2, 3, 5, 7, 6],
            ],
            [
                'type' => 'column',
                'name' => 'Joe',
                'data' => [4, 3, 3, 9, 0],
            ],
            [
                'type' => 'spline',
                'name' => 'Average',
                'data' => [5, 5, 5, 5, 5],
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white',
                ],
            ],
//            [
//                'type' => 'pie',
//                'name' => 'Total consumption',
//                'data' => [
//                    [
//                        'name' => 'Jane',
//                        'y' => 13,
//                        'color' => new JsExpression('Highcharts.getOptions().colors[0]'), // Jane's color
//                    ],
//                    [
//                        'name' => 'John',
//                        'y' => 23,
//                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'), // John's color
//                    ],
//                    [
//                        'name' => 'Joe',
//                        'y' => 19,
//                        'color' => new JsExpression('Highcharts.getOptions().colors[2]'), // Joe's color
//                    ],
//                ],
//                'center' => [100, 80],
//                'size' => 100,
//                'showInLegend' => false,
//                'dataLabels' => [
//                    'enabled' => false,
//                ],
//            ],
        ],
    ]
]);?>
    </div>
</div>

<div class="box box-success">
    <?=Highcharts::widget([
        'options' => [
            'title' => ['text' => 'Sample title - pie chart'],
            'plotOptions' => [
                'pie' => [
                    'cursor' => 'pointer',
                ],
            ],
            'series' => [
                [ // new opening bracket
                    'type' => 'pie',
                    'name' => 'Elements',
                    'data' => [
                        ['Firefox', 45.0],
                        ['IE', 26.8],
                        ['Safari', 8.5],
                        ['Opera', 6.2],
                        ['Others', 0.7]
                    ],
                ] // new closing bracket
            ],
        ],
    ]);?>
</div>

<div class="user-index">
    <div class="box box-primary">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>
