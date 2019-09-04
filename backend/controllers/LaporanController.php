<?php

namespace backend\controllers;

use Yii;
use backend\models\Agregasiheader;
use backend\models\Agregasiline;
use backend\models\AgregasiheaderSearch;
use backend\models\SampleDus;
use backend\models\SampledusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LaporanController implements the CRUD action for All Model.
 */
class LaporanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * Get Produk
     */
    public function actionProduk($nie)
    {
        $sql = "SELECT kemasan, status FROM tbl_nie WHERE nomor_nie = '".$nie."'";
        $data = Yii::$app->db_pm->createCommand($sql)->queryOne();
        return $data;
    }
    
    /**
     * Cek Login User
     */
    public function cekLogin()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
    }
    
    /**
     * Set Format Date
     */
    public function actionDate($date)
    {
        $day = substr($date, 0,2);
        $month = substr($date, 2, 2);
        $year = substr($date, 4, 2);
        
        $newDate = $month.'/'.$day.'/20'.$year;
        return $newDate;
    }
    

    /**
     * Report BPOM penerbitan
     */
    public function actionPenerbitan()
    {
        $searchModel = new AgregasiheaderSearch();
        $dataProvider = $searchModel->searchLine(Yii::$app->request->queryParams);
        
        return $this->render('bpom/penerbitan',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Report BPOM penerbitan bagian sample dan reject
     */
    public function actionPenerbitansample()
    {
        $searchModel = new SampledusSearch();
        $dataProvder = $searchModel->searchLaporan(Yii::$app->request->queryParams);
        
        return $this->render('bpom/penerbitan_sample',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvder,
        ]);
    }
}

