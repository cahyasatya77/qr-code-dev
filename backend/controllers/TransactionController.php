<?php

namespace backend\controllers;

use Yii;
use backend\models\Karton;
use backend\models\Kemas;
use backend\models\ModelStatis;
use backend\models\KartonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
// scenario 1
use backend\models\Agregasi;
use backend\models\AgregasiSearch;
use yii\data\ActiveDataProvider;
use backend\models\Agregasidetail;
// scenario 2
use backend\models\Agregasiheader;
use backend\models\Agregasiline;
use backend\models\AgregasiheaderSearch;
// sample
use backend\models\SampleDus;
use backend\models\SampledusSearch;

/**
 * KartonController implements the CRUD actions for Karton model.
 */
class TransactionController extends Controller
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

    /**
     * Lists all Karton models.
     * @return mixed
     */

    /**
     * Displays a single Karton model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionIndex()
    {
        $model = new ModelStatis();
        $karton = Karton::find()->joinWith('kemas')->where(['is_sold' => 'FALSE'])->all();
        $searchModel = new KartonSearch();
        $dataProvider = $searchModel->searchSold(Yii::$app->request->queryParams);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $id = $model->code_karton;
            $model_kemas = Kemas::find()->where(['id_karton' => $id])->all();
            foreach ($model_kemas as $kemas){
                $kemas->is_sold = 'TRUE';
                $kemas->save();
            }
        };
        
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'karton' => $karton,
        ]);
    }
    
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
     * @param type $id jika request dengan array (php)
     */
    
    public function actionSell()
    {
        $model = new ModelStatis();
        
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $searchname = explode(":", $data['testCode']);
            $searchname = $searchname[0];
            $search = $searchname;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax('sell',[
                'model' => $model,
                'search' => $search,
                'code' => 100, 
            ]);
        }
    }
    // ====================================== Scenario 1 ==============================================
    public function actionJualkarton()
    {
        $model = new ModelStatis();
        $karton = Agregasi::find()->joinWith('agregasiDetails')->where(['is_sold' => 'FALSE'])->all();
        $searchKarton = new AgregasiSearch();
        $soldKarton = $searchKarton->searchSold(Yii::$app->request->queryParams);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id = $model->code_karton;
            $agregasi_detail = Agregasidetail::find()->where(['id_agregasi' => $id])->all();
            foreach ($agregasi_detail as $detail) {
                $detail->is_sold = 'TRUE';
                $detail->save();
            }
            
            return $this->redirect('jualkarton');
        };
        
        return $this->render('jual_karton',[
            'model' => $model,
            'karton' => $karton,
            'soldKarton' => $soldKarton,
            'searchKarton' => $searchKarton,
        ]);
    }
    
    public function actionSample()
    {
        $model = new ModelStatis();
        $kemasan = Agregasidetail::find()->where(['is_sample' => 'FALSE'])->all();
        $searchDus = new AgregasiSearch();
        $sampleDus = $searchDus->searchSample(Yii::$app->request->queryParams);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id = $model->code_kemas;
            $agregasi_detail = Agregasidetail::find()->where(['id' => $id])->one();
            $agregasi_detail->is_sample = 'TRUE';
            if ($agregasi_detail->save()) {
                return $this->redirect('sample');
            }
        };
        
        return $this->render('sample',[
            'model' => $model,
            'kemasan' => $kemasan,
            'searchDus' => $searchDus,
            'sampleDus' => $sampleDus,
        ]);
    }
    
    public function actionReturnsample($id)
    {
        $model = Agregasidetail::findOne($id);
        $model->is_sample = "FALSE";
        $model->save();
        
        return $this->redirect(['sample']);
    }

    // ====================================== End Scenario 1 ==============================================
    // ======================================== Scenario 2 ================================================
    public function actionSellkarton()
    {
        $model = new ModelStatis();
        $sql = "SELECT h.kode_karton
                FROM agregasi_header h
                JOIN agregasi_line l ON h.id = l.id_agregasi
                WHERE l.is_sold = 'TRUE'
                AND DATE(h.updated_at) = CURDATE()
                GROUP BY h.kode_karton";
        $data_sold = Yii::$app->db->createCommand($sql)->queryAll();
        $count_sold = count($data_sold);
        
        if ($model->load(Yii::$app->request->post())) {
            $id = $model->code_karton;
            $data = Agregasiheader::find()->where(['CONCAT(kode_karton, rand_char)' => $id])->one();
            if ($data !== null) {
                $command = Yii::$app->db->createCommand()->update('agregasi_header', [
                    'updated_at' => new Expression('NOW()'),
                    'updated_by' => Yii::$app->user->id,
                ], 'id = '.$data->id);
                $success = $command->execute();
                
                if ($success) {
                    $command_line = Yii::$app->db->createCommand()->update('agregasi_line', [
                        'is_sold' => 'TRUE'
                    ], 'id_agregasi = '.$data->id);
                    $success = $command_line->execute();
                    if ($success) {
                        return $this->redirect('sellkarton');
                    }
                }
            } else {
                Yii::$app->session->setFlash('warning', 'Kode karton yang di input tidak diketahui. Silahkan cek kembali.');
            }
        }
        
        return $this->render('sellkarton',[
            'model' => $model,
            'count_sold' => $count_sold,
        ]);
    }
    
    /**
     *  Create new Reject in Sample Model 18 Juli 2019.
     *  if Created successful, the browser redirected to the 'reject' page.
     *  @var string Model.
     */
    public function actionReject()
    {
        $model = new SampleDus();
        $reject = SampleDus::find()
                ->where(['is_reject' => 'TRUE'])
                ->andWhere(['create_at' => date('Y-m-d')]);
        $count_reject = $reject->count();
        
        if ($model->load(Yii::$app->request->post())) {
            $kode = $model->id_kemas;
            $nie = substr($kode, 4, 15); // mengambil data NIE dari kode qr
            $batch = substr($kode, 23, 5); // mengambil data Batch dari kode qr
            $ed = substr($kode, 32, 4); // mengambil data ED format YYMMDD dari kode qr
            
            // memecah ED menjadi Date
            $day = substr($ed, 4, 2);
            $month = substr($ed, 2, 2);
            $year = substr($ed, 0, 2);
            $date_ed = '20'.$year.'-'.$month.'-'.$day;
            
            // mendapatkan detail produk
            $sql = "SELECT p.kd_produk, p.nama_produk, n.kemasan, p.deskripsi
                    FROM tbl_produk p
                    JOIN tbl_nie n ON p.kd_produk = n.kd_produk
                    WHERE n.nomor_nie = '".$nie."'
                    GROUP BY p.kd_produk";
            $produk = Yii::$app->db_pm->createCommand($sql)->queryOne();
            
            // memasukan item ke database
            $model->id_karton = 'REJECT';
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
            $model->is_sample = 'FALSE';
            $model->is_sold = 'FALSE';
            $model->is_reject = 'TRUE';
            $model->create_at = new Expression('NOW()');
            $model->last_updated_by = Yii::$app->user->id;
            $model->last_updated_date = new Expression('NOW()');
            $success = $model->save();
            if ($success) {
                return $this->redirect('reject');
            }
        }
        
        return $this->render('reject',[
            'model' => $model,
            'count_reject' => $count_reject,
        ]);
    }
    
    // ====================================== End Scenario 2 ==============================================
    /**
     * Return an existing Kemas model through id_karton.
     * If update is successful, the browser will be stay page and add id_karton in GridView.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionReturn()
    {
        $model = new ModelStatis();
        $karton = Karton::find()->joinWith('kemas')->where(['is_sold' => 'TRUE'])->all();
        
        $searchModel = new KartonSearch();
        $dataProvider = $searchModel->searchReturn(Yii::$app->request->queryParams);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $id = $model->code_karton;
            $model_kemas = Kemas::find()->where(['id_karton' => $id])->all();
            foreach ($model_kemas as $kemas){
                $kemas->is_sold = 'FALSE';
                $kemas->save();
            }
        }
        
        return $this->render('return',[
            'model' => $model,
            'karton' => $karton,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
    
    protected function findAgregasi($id)
    {
        if(($model = Agregasiheader::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
