<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\ModelStatis;
use backend\models\Kodecahya;


/**
 * OracleController implements the CRUD action for Oracle Darabase
 */

class OracleController extends Controller
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
     * Cek Login User
     */
    public function cekLogin()
    {
        if (\Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);
        }
    }
    
    /**
     * Displays a single Kodecahya model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Insert table Oracle from model ModelStatis
     * Create a new Kodecahya model.
     * If creation is successfull, the browser will be redirected to the 'view' page.
     * @return mixed.
     */
    public function actionCreate()
    {
        $model = new Kodecahya();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
            return $this->redirect(['create']);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing Kodecahya model.
     * if Update is successful, the browser will redirected to the 'View' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundException if model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->CAHYA_ID]);
        }
        
        return $this->render('update', [
            'model' => $model
        ]);
    }
    
    /**
     * Finds the Kodecahya model based on its primary key value.
     * If the model is not found, as 404 HTTP exception will be thrown.
     * @param sting $id
     * @return Kodecahya the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kodecahya::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}