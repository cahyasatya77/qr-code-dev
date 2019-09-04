<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Kodekemas;
//use backend\models\Agregasi;
use backend\models\Agregasiheader;
use backend\models\Agregasiline;
use backend\models\ModelStatis;

/**
 * ValidationController implements the validation action for kode kemas dan karton
 */
class ValidationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return[
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * Cek Login User
     */
    public function cekLogin(){
        if(\Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
    }
    
    /**
     * Validation karton
     */
    public function actionKarton()
    {
        $valid = false;
        $model = new ModelStatis();
        
        if ($model->load(Yii::$app->request->post())) {
            $kode = $model->code_karton;
            $data = Agregasiheader::find()->where(['CONCAT(kode_karton, rand_char)' => $kode])->one();
            if ($data != null) {
                $valid = true;
                \Yii::$app->session->setFlash('success', 'QR-Code Karton tersedia');
                return $this->redirect('karton');
            } else {
                \Yii::$app->session->setFlash('error', 'QR-Code Karton tidak tersedia');
                return $this->redirect('karton');
            }
        }
        
        return $this->render('karton',[
            'model' => $model,
            'valid' => $valid,
        ]);
    }

    /**
     * Validation Dus
     */
    public function actionDus()
    {
        $valid = [];
        $model = new ModelStatis();
        
//        if ($model->load(Yii::$app->request->post())) {
//            $kode = $model->code_kemas;
//            $hasil = Kodekemas::find()->where(['CONCAT(kode, rand_char)' => $kode])->one();
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//            return [
//                'hasil' => $kode,
//                'code' => 100
//            ];
//        }
        
        if (Yii::$app->request->isAjax) {
            $kode = $_POST['kode'];
            $hasil = Kodekemas::find()->where(['CONCAT(kode, rand_char)' => $kode])->one();
            if ($hasil != null) {
                $valid = 'benar';
                \Yii::$app->db->createCommand()
                        ->update('kode_kemas', ['status' => 'valid'], ['CONCAT(kode, rand_char)' => $kode])
                        ->execute();
            } else {
                $valid = 'gagal';
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'valid' => $valid,
                'code' => 100,
            ];
        }
        
        return $this->render('dus',[
            'model' => $model,
            'valid' => $valid,
        ]);
    }
    
    public function actionValidationDus() 
    {
        $post = \Yii::$app->request->post();
        if (!empty($post)) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new ModelStatis();
            $model->load($post);
            
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}