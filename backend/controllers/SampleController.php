<?php

namespace backend\controllers;

use Yii;
use backend\models\Karton;
use backend\models\Kemas;
use backend\models\Sample;
use backend\models\SampleDus;
use backend\models\Model;
use backend\models\ModelStatis;
use backend\models\KartonSearch;
use backend\models\KemasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\db\Expression;
// news
use backend\models\Agregasiheader;
use backend\models\Agregasiline;
use backend\models\AgregasiheaderSearch;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SampleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionGetCityProvince($zipId){
        $sql = "SELECT p.kd_produk, p.nama_produk, p.deskripsi, n.kemasan, n.nomor_nie FROM tbl_produk p JOIN tbl_nie n
                ON p.kd_produk = n.kd_produk
                WHERE p.kd_produk ='".$zipId."'
                ORDER BY n.last_updated_date DESC";
        $produk = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_pm',
        ]);
        $produk->pagination = FALSE;
        $model_produk = $produk->getModels();
        echo Json::encode($model_produk);
    }
    
    public function actionBatch()
    {
        $id = $_REQUEST['zipId'];
        $sql = "SELECT  GBH.ATTRIBUTE1
                FROM GME.GME_BATCH_HEADER GBH,GME.GME_MATERIAL_DETAILS GMD,
                    INV.MTL_SYSTEM_ITEMS_B MSIB
                WHERE GBH.BATCH_ID = GMD.BATCH_ID
                AND GMD.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND GMD.ORGANIZATION_ID = MSIB.ORGANIZATION_ID 
                AND MSIB.SEGMENT1 = CONCAT('PP', :PARAM)
                AND GBH.BATCH_TYPE = 0
                AND GBH.BATCH_STATUS in (1,2) 
                AND GMD.LINE_TYPE = -1
                AND GBH.ATTRIBUTE1 IS NOT NULL";
        $batch = new SqlDataProvider([
            'sql' => $sql,
            'params' => [
                ':PARAM' => $id
            ],
            'db' => 'db_o'
        ]);
        $batch->pagination = FALSE;
        $model_batch = $batch->getModels();
        $count = count($model_batch);
        
        if($count > 0){
            foreach ($model_batch as $batchs){
                echo "<option value = '".$batchs['ATTRIBUTE1']."'>".$batchs['ATTRIBUTE1']."</option>";
            }
        }else{
            echo "<option>-</option>";
        }
    }
    
    public function actionExpired($noBatch, $kdProduk)
    {
        $sql = "SELECT MSIB.SEGMENT1, MSIB.DESCRIPTION, MLN.LOT_NUMBER
                        , TO_CHAR(MLN.EXPIRATION_DATE,'YYYY-MM-DD') EXPIRATION_DATE
                FROM INV.MTL_SYSTEM_ITEMS_B MSIB
                    ,INV.MTL_LOT_NUMBERS MLN
                WHERE MSIB.INVENTORY_ITEM_ID = MLN.INVENTORY_ITEM_ID
                AND MSIB.ORGANIZATION_ID = MLN.ORGANIZATION_ID
                AND MSIB.ORGANIZATION_ID IN (82,86)
                AND SUBSTR(MSIB.SEGMENT1,1,2) IN ('MX','FL')
                AND SUBSTR(MSIB.SEGMENT1,3) = :KODE_PRODUK
                AND MLN.LOT_NUMBER = :LOT_NUMBER";
        $ed = new SqlDataProvider([
            'sql' => $sql,
            'params' => [
                ':LOT_NUMBER' => $noBatch,
                ':KODE_PRODUK' => $kdProduk,
            ],
            'db' => 'db_o',
        ]);
        $model_ed = $ed->getModels();
        
        echo Json::encode($model_ed);
    }

    /**
     * Displays a single Kemas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionKemas()
    {
        $searchModel = new KemasSearch();
        $dataProvider = $searchModel->searchDus(Yii::$app->request->queryParams);
        
        return $this->render('kemas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * add sample dus untuk QC
     */
    public function actionSampleqc()
    {
        $model_statis = new Sample;
        $model = [new SampleDus];
        
        $sql = "SELECT * FROM tbl_produk";
        $produk = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_pm',
        ]);
        $produk->pagination = FALSE;
        $model_produk = $produk->getModels();
        
        if ($model_statis->load(Yii::$app->request->post()))
        {
            $model = Model::createMultiple(SampleDus::className());
            Model::loadMultiple($model, Yii::$app->request->post());
            
            $valid = $model_statis->validate();
            $valid = Model::validateMultiple($model) && $valid;
//            var_dump($valid);
//            die();
            
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $valid){
                        foreach ($model as $dus) {
                            $dus->id_karton = 'SAMPLE';
                            $dus->kd_produk = $model_statis->kd_produk;
                            $dus->nama_produk = $model_statis->nama_produk;
                            $dus->no_batch = $model_statis->no_batch;
                            $dus->no_nie = $model_statis->no_nie;
                            $dus->kemasan = $model_statis->kemasan;
                            $dus->deskripsi = $model_statis->deskripsi;
                            $dus->tanggal_ed = $model_statis->tanggal_ed;
                            $dus->tanggal_produksi = $model_statis->tanggal_produksi;
                            $dus->create_at = new Expression('now()');
                            $dus->last_updated_date = new Expression('now()');
                            $dus->last_updated_by = Yii::$app->user->id;
                            if (! $dus->save()){
//                                throw new \Exception ( implode ( "<br />" , \yii\helpers\ArrayHelper::getColumn ( $dus->errors , 0 , false ) ) );
//                                $transaction->rollBack();
//                                break;
                                 Yii::$app->session->setFlash('error', "Silakan periksa apakah input data Anda benar.");
                                return $this->redirect('sampleqc');
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                    }
//                    Yii::$app->session->setFlash('succes', "Sample berhasil disimpan");
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('error', "Silakan periksa apakah input data Anda benar.");
                    $transaction->rollBack();
                }
            } else {
                Yii::$app->session->setFlash('error', "Gagal menyimpan data");
            }
        }
        
        return $this->render('sample_qc',[
            'model_statis' => $model_statis,
            'model' => $model,
            'model_produk' => $model_produk,
        ]);
    }

    /**
     * Updates Status kemasan
     * If update is seccessful, the browser will be redirected to 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionStatus($id)
    {
        $model = $this->findKemas($id);
        
        if ($model->load(Yii::$app->request->post())){
            $model->is_sample = ($model->is_sample == 1) ? 'TRUE' : 'FALSE';
            if ($model->save()){
                Yii::$app->session->setFlash('success','Status Dus dengan ID <code>'.$model->id_kemas.'</code> produk berhasil dirubah');
                return $this->redirect(['kemas']);
            }
        }
        
        return $this->renderAjax('_status',[
            'model' => $model,
        ]);
    }
    // ================================================= NEW 16 Juli 2019 ==================================================
    /**
     * Create new Sample in Sample Model.
     * if Created successful, the browser redirected to the 'view' page.
     * @var string Model.
     */
    public function actionCreatesample_old()
    {
        $model_statis = new Sample;
        $model = [new SampleDus];
        
        $sql = "SELECT * FROM tbl_produk";
        $produk = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_pm',
        ]);
        $produk->pagination = false;
        $model_produk = $produk->getModels();
        
        if ($model_statis->load(Yii::$app->request->post()))
        {
            $model = Model::createMultiple(SampleDus::className());
            Model::loadMultiple($model, Yii::$app->request->post());
            
            $valid = $model_statis->validate();
            $valid = Model::validateMultiple($model) && $valid;
            
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $valid) {
                        foreach ($model as $dus) {
                            $dus->id_karton = 'SAMPLE';
                            $dus->kd_produk = $model_statis->kd_produk;
                            $dus->nama_produk = $model_statis->nama_produk;
                            $dus->no_batch = $model_statis->no_batch;
                            $dus->no_nie = $model_statis->no_nie;
                            $dus->kemasan = $model_statis->kemasan;
                            $dus->deskripsi = $model_statis->deskripsi;
                            $dus->tanggal_ed = $model_statis->tanggal_ed;
                            $dus->tanggal_produksi = $model_statis->tanggal_produksi;
                            $dus->create_at = new Expression('NOW()');
                            $dus->last_updated_by = Yii::$app->user->id;
                            $dus->last_updated_date = new Expression('NOW()');
                            if (! $dus->save()) {
                                Yii::$app->session->setFlash('error', 'Silahkan Cek Kempabali data input anda.');
                                return $this->redirect('createsample');
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                    }
                } catch (Exception $ex) {
                    Yii::$app->session->setFlash('error', 'Silahkan periksa apakah input data Anda benar');
                    $transaction->rollBack();
                }
            } else {
                Yii::$app->session->setFlash('error', "Gagal menyimpan data");
            }
        }
        
        return $this->render('create_sample_old',[
            'model_statis' => $model_statis,
            'model' => $model,
            'model_produk' => $model_produk,
        ]);
    }
    
    /**
     * Create new Sample in Sample Model 17 juli 2019.
     * if Created successful, the browser redirected to the 'view' page.
     * @var string Model.
     */
    public function actionCreatesample()
    {
        $model = new SampleDus();
        $sample = SampleDus::find()
                ->where(['create_at' => date('Y-m-d')])
                ->andWhere(['is_sample' => 'TRUE']);
        $count_sample = $sample->count();
        
        if ($model->load(Yii::$app->request->post())) {
            $kode = $model->id_kemas;
            $nie = substr($kode, 4, 15); // mengambil data NIE dari kode qr
            $batch = substr($kode, 23, 5); // mengambil data Batch dari kode qr
            $ed = substr($kode, 32, 6); // mengambil data ED format YYMMDD dari kode qr
            
            // memacah ED menjadi Date
            $day = substr($ed, 4,2);
            $month = substr($ed, 2,2);
            $year = substr($ed, 0,2);
            $date_ed = '20'.$year.'-'.$month.'-'.$day;
            
            // mendapatkan detail produk
            $sql = "SELECT p.kd_produk, p.nama_produk, n.kemasan, p.deskripsi
                    FROM tbl_produk p
                    JOIN tbl_nie n ON n.kd_produk = p.kd_produk
                    WHERE n.nomor_nie = '".$nie."'
                    GROUP BY p.kd_produk";
            $produk = Yii::$app->db_pm->createCommand($sql)->queryOne();
            
            // memasukan data ke database
            $model->id_karton = 'SAMPLE';
            $model->id_kemas = $kode;
            $model->kd_produk = $produk['kd_produk'];
            $model->nama_produk = $produk['nama_produk'];
            $model->no_batch = $batch;
            $model->no_nie = $nie;
            $model->kemasan = $produk['kemasan'];
            $model->deskripsi = $produk['deskripsi'];
            $model->tanggal_ed = $date_ed;
            $model->tanggal_produksi = null;
            $model->is_active = 'FALSE';
            $model->is_sample = 'TRUE';
            $model->is_sold = 'FALSE';
            $model->is_reject = 'FALSE';
            $model->create_at = new Expression('NOW()');
            $model->last_updated_by = Yii::$app->user->id;
            $model->last_updated_date = new Expression('NOW()');
            $success = $model->save();
            if ($success) {
                return $this->redirect('createsamplenew');
            }
        }
        
        return $this->render('create_sample',[
            'model' => $model,
            'count_sample' => $count_sample,
        ]);
    }
    
    /**
     * Deletes an existing Agregasiline Model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * $param integer $id
     * $return mixed
     * @throws NotFounfHttpException if the model cannoe be found
     */
    public function actionRemoveDus()
    {
        $searchModel = new AgregasiheaderSearch();
        $dataProvider = $searchModel->searchRemove(Yii::$app->request->queryParams);
        
        return $this->render('remove_dus',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDeleteline($id)
    {
        $this->findLine($id)->delete();
        
        Yii::$app->session->setFlash('warning', 'Data dus pada karton berhasil dihapus');
        return $this->redirect(['remove-dus']);
    }

    // ==================================================== END NEW ========================================================
    
    /**
     * Displays a single Karton model.
     * @param integer $id
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
     * Return an existing Kemas model through id_karton.
     * If update is successful, the browser will be stay page and add id_karton in GridView.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionReturn()
    {
        
    }

    /**
     * Deletes an existing Karton model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    /**
     * Finds the Karton model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Karton the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Karton::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findKemas($id)
    {
        if (($model = Kemas::findOne($id)) !== null){
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findLine($id)
    {
        if (($model = Agregasiline::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requsted page does no exist.');
    }
}