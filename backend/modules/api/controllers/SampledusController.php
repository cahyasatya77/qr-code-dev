<?php

namespace backend\modules\api\controllers;

use yii\web\Response;
use backend\modules\api\models\Sampledus;

class SampledusController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Create Model sampledus.
     * Insert data with JSON POST.
     * $Sample Model Sampledus.
     */
    
    public function actionCreateSample()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        
        $sample = new Sampledus;
        $sample->scenario = Sampledus::SCENARIO_CREATE;
        $sample->attributes = \Yii::$app->request->post();
        
        if ($sample->validate()) {
            $sample->save();
            $data = Sampledus::find()->where(['id' => $sample->id])->one();
            return array('status' => true, 'data' => $data);
        } else {
            return array('status' => false);
        }
    }
    
    /**
     * Update Model sampledus
     */
    public function actionUpdateSample()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
    }
}
