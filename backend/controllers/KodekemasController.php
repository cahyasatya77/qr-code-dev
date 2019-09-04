<?php

namespace backend\controllers;

use Yii;
use backend\models\Kodekemas;
use backend\models\KodekemasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\GenerateCode;
use yii\db\Expression;
use yii\data\SqlDataProvider;
use yii2tech\csvgrid\CsvGrid;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

/**
 * KodekemasController implements the CRUD actions for Kodekemas model.
 */
class KodekemasController extends Controller
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
     * Generate Random Char
     */
    function randomHuruf()
    {
        $karakter = array_merge(range('A', 'Z'));
        $string = '';
        
        $max = count($karakter) -1;
        for ($i=0; $i<3; $i++) 
        {
            $pos = mt_rand(0, $max);
            $string .= $karakter[$pos];
        }
        
        return $string;
    }
    
    /**
     * Get nomor Batch
     */
    public function actionBatch()
    {
        $kode = $_REQUEST['nie'];
        $nie = Yii::$app->db_pm->createCommand("SELECT kd_produk FROM tbl_nie WHERE nomor_nie = '".$kode."' GROUP BY kd_produk")->queryOne();
        $sql = "SELECT substr(msib.SEGMENT1,3) SEGMENT1
                    ,mln.LOT_NUMBER
                    ,to_char(mln.EXPIRATION_DATE,'RRMMDD') EXPIRATION_DATE
                from gme_batch_header gbh
                    ,gme_material_details gmd
                    ,mtl_system_items_b msib
                    ,mtl_lot_numbers mln
                    ,mtl_system_items_b msib0
               where 1=1
                 AND GBH.BATCH_TYPE != 10
                 AND LENGTH(GBH.ATTRIBUTE1) = 5
                 and gbh.BATCH_ID = gmd.BATCH_ID
                 and gmd.LINE_TYPE = 1
                 and gmd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                 and gmd.ORGANIZATION_ID = msib.ORGANIZATION_ID
                 and substr(msib.SEGMENT1,1,2) = 'PP'
                 and gbh.BATCH_STATUS not in (-1,3,4)
                 and msib0.INVENTORY_ITEM_ID = (select min(msi.INVENTORY_ITEM_ID)
                                                  from mtl_system_items_b msi
                                                      ,MTL_LOT_NUMBERS lot
                                                 where msi.ORGANIZATION_ID = msib.ORGANIZATION_ID
                                                   and substr(msi.SEGMENT1,3) = substr(msib.SEGMENT1,3)
                                                   AND substr(msi.SEGMENT1,1,2) NOT IN ('PP','FG','BP')
                                                   and msi.INVENTORY_ITEM_ID = lot.INVENTORY_ITEM_ID
                                                   and msi.ORGANIZATION_ID = lot.ORGANIZATION_ID
                                                   AND substr(msib.SEGMENT1,3) = :SEGMENT1
                                                   and lot.LOT_NUMBER = gbh.ATTRIBUTE1) 
                 and mln.INVENTORY_ITEM_ID = msib0.INVENTORY_ITEM_ID
                 and mln.ORGANIZATION_ID = msib0.ORGANIZATION_ID
                 and mln.LOT_NUMBER = gbh.ATTRIBUTE1
                 and substr(msib0.SEGMENT1,3) = substr(msib.SEGMENT1,3) 
               order by msib.SEGMENT1
                    ,substr(mln.LOT_NUMBER,1,1)||substr(mln.LOT_NUMBER,4,2)||substr(mln.LOT_NUMBER,2,2)";
        $batch = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_o',
            'pagination' => false,
            'params' => [
                ':SEGMENT1' => $nie['kd_produk']
            ],
        ]);
        $model_batch = $batch->getModels();
        $count = count($model_batch);
        
        if ($count > 0) {
            foreach ($model_batch as $batchs) {
                echo "<option value = '".$batchs['LOT_NUMBER']."'>".$batchs['LOT_NUMBER']."</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }
    
    /**
     * Get nomor Expired Date product
     */
    public function actionGetExpiredDate($nie, $batch) 
    {
        $nie = Yii::$app->db_pm->createCommand("SELECT kd_produk FROM tbl_nie WHERE nomor_nie = '".$nie."' GROUP BY kd_produk")->queryOne();
        $sql = "SELECT substr(msib.SEGMENT1,3) SEGMENT1
                    ,mln.LOT_NUMBER
                    ,to_char(mln.EXPIRATION_DATE,'RRMMDD') EXPIRATION_DATE
                from gme_batch_header gbh
                    ,gme_material_details gmd
                    ,mtl_system_items_b msib
                    ,mtl_lot_numbers mln
                    ,mtl_system_items_b msib0
               where 1=1
                 AND GBH.BATCH_TYPE != 10
                 AND LENGTH(GBH.ATTRIBUTE1) = 5
                 and gbh.BATCH_ID = gmd.BATCH_ID
                 and gmd.LINE_TYPE = 1
                 and gmd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                 and gmd.ORGANIZATION_ID = msib.ORGANIZATION_ID
                 and substr(msib.SEGMENT1,1,2) = 'PP'
                 and gbh.BATCH_STATUS not in (-1,3,4)
                 and msib0.INVENTORY_ITEM_ID = (select min(msi.INVENTORY_ITEM_ID)
                                                  from mtl_system_items_b msi
                                                      ,MTL_LOT_NUMBERS lot
                                                 where msi.ORGANIZATION_ID = msib.ORGANIZATION_ID
                                                   and substr(msi.SEGMENT1,3) = substr(msib.SEGMENT1,3)
                                                   AND substr(msi.SEGMENT1,1,2) NOT IN ('PP','FG','BP')
                                                   and msi.INVENTORY_ITEM_ID = lot.INVENTORY_ITEM_ID
                                                   and msi.ORGANIZATION_ID = lot.ORGANIZATION_ID
                                                   AND substr(msib.SEGMENT1,3) = :SEGMENT1
                                                   AND MLN.LOT_NUMBER = :NO_BATCH
                                                   and lot.LOT_NUMBER = gbh.ATTRIBUTE1) 
                 and mln.INVENTORY_ITEM_ID = msib0.INVENTORY_ITEM_ID
                 and mln.ORGANIZATION_ID = msib0.ORGANIZATION_ID
                 and mln.LOT_NUMBER = gbh.ATTRIBUTE1
                 and substr(msib0.SEGMENT1,3) = substr(msib.SEGMENT1,3) 
               order by msib.SEGMENT1
                    ,substr(mln.LOT_NUMBER,1,1)||substr(mln.LOT_NUMBER,4,2)||substr(mln.LOT_NUMBER,2,2)";
        $batch = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_o',
            'pagination' => false,
            'params' => [
                ':SEGMENT1' => $nie['kd_produk'],
                ':NO_BATCH' => $batch,
            ],
        ]);
        $model_batch = $batch->getModels();
        
        return Json::encode($model_batch);
    }

    /**
     * Lists all Kodekemas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KodekemasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Kodekemas models.
     * @return mixed
     */
    public function actionLaporan()
    {
        $model = new GenerateCode();
        $kode = [];
        
        $sql = "SELECT concat(p.kd_produk,' - ', p.nama_produk,' - ', n.nomor_nie) description, n.nomor_nie nie, p.batch_size batch_size FROM tbl_produk p JOIN tbl_nie n
                ON p.kd_produk = n.kd_produk
                GROUP BY p.kd_produk";
        $nie = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_pm'
        ]);
        $nie->pagination = false;
        $model_nie = $nie->getModels();
        
        $model->scenario = GenerateCode::SCENARIO_UPDATE;
        
        if ($model->load(Yii::$app->request->post()))
        {
            $kode = new ActiveDataProvider([
                'query' => Kodekemas::find()
                            ->where(['no_nie' => $model->nomor_nie])
                            ->andWhere(['like', 'created_at', $model->date]),
                'pagination' => false,
            ]);
        }
        
        return $this->render('laporan',[
            'model' => $model,
            'kode' => $kode,
            'model_nie' => $model_nie,
        ]);
    }

    /**
     * Displays a single Kodekemas model.
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
     * Creates a new Kodekemas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GenerateCode();

        $sql = "SELECT concat(p.kd_produk,' - ', p.nama_produk,' - ', n.nomor_nie) description, n.nomor_nie nie, p.batch_size batch_size FROM tbl_produk p JOIN tbl_nie n
                ON p.kd_produk = n.kd_produk
                GROUP BY p.kd_produk";
        $nie = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_pm'
        ]);
        $nie->pagination = false;
        $model_nie = $nie->getModels();
        
        //$model->scenario = GenerateCode::SCENARIO_CREATE;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id = '90'.$model->nomor_nie.'2174';
            $transaction = Yii::$app->db->beginTransaction();
            $date = date("Y-m-d H:i:s");
            try {
                for ($i=0; $i<$model->jumlah; $i++) :
                    $modelkode = new Kodekemas();
                    $modelkode->kode = $modelkode->generateKode($id);
                    $modelkode->rand_char = $this->randomHuruf();
                    $modelkode->no_nie = $model->nomor_nie;
                    $modelkode->created_by = Yii::$app->user->id;
                    $modelkode->created_at = $date;
                    $modelkode->updated_by = Yii::$app->user->id;
                    $modelkode->updated_at = new Expression('NOW()');
                    $modelkode->isNewRecord = TRUE;
                    $modelkode->save();
                endfor;
                
                $transaction->commit();
                return $this->redirect(['report', 'nie' => $model->nomor_nie, 'date' => $date]);
            } catch (Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'model_nie' => $model_nie,
        ]);
    }
    
    public function actionCreatenew()
    {
        $model = new GenerateCode();
        
        $sql = "SELECT concat(p.kd_produk,' - ', p.nama_produk,' - ', n.nomor_nie) description, n.nomor_nie nie, p.batch_size batch_size 
                FROM tbl_produk p 
                JOIN tbl_nie n ON p.kd_produk = n.kd_produk
                GROUP BY p.kd_produk";
        $nie = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_pm',
        ]);
        $nie->pagination = false;
        $model_nie = $nie->getModels();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $id = '(90)'.$model->nomor_nie.'(10)'.$model->nomor_batch.'(17)'.$model->expired_date.'(21)';
            $transaction = Yii::$app->db->beginTransaction();
            $date = date("Y-m-d H:i:s");
            try {
                for ($i=0; $i<$model->jumlah; $i++) :
                    $modelkode = new Kodekemas();
                    $modelkode->kode = $modelkode->generateKode($id);
                    $modelkode->rand_char = $this->randomHuruf();
                    $modelkode->no_nie = $model->nomor_nie;
                    $modelkode->created_by = \Yii::$app->user->id;
                    $modelkode->created_at = $date;
                    $modelkode->updated_by = Yii::$app->user->id;
                    $modelkode->updated_at = new Expression('NOW()');
                    $modelkode->isNewRecord = true;
                    $modelkode->save();
                endfor;
                
                $transaction->commit();
                return $this->redirect(['report-new','nie' => $model->nomor_nie, 'date' => $modelkode->created_at]);
            } catch (Exception $ex) {
                $transaction->rollBack();
                throw $ex;
            }
        }
        
        return $this->render('createnew',[
            'model' => $model,
            'model_nie' => $model_nie,
        ]);
    }

    /**
     * Updates an existing Kodekemas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/
    
    /**
     * Report data
     */
    public function actionReport($nie, $date)
    {
        $sql = "SELECT CONCAT(kode, rand_char) kode FROM kode_kemas
                WHERE no_nie = :nie AND created_at = :date";
        $export = new CsvGrid([
            'dataProvider' => new SqlDataProvider([
                'sql' => $sql,
                'pagination' => false,
                'sort' => false,
                'params' => [
                    ':nie' => $nie,
                    ':date' => $date,
                ],
            ]),
            'columns' => [
                [
                    'attribute' => 'kode',
                    'label' => '',
                ],
            ],
            'csvFileConfig' => [
                'enclosure' => '',
            ],
        ]);
       // Yii::$app->session->setFlash('success','Data Berhasil diexport');
        return $export->export()->send('data.txt');
    }
    
    public function actionReportNew($nie, $date)
    {
        $sql = "SELECT CONCAT(kode, rand_char) kode FROM kode_kemas
                WHERE no_nie = :nie AND created_at = :date";
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [
                ':nie' => $nie,
                ':date' => $date,
            ],
            'pagination' => false,
            'sort' => false,
        ]);
        
        $model = $dataProvider->getModels();
        $filename = 'data.txt';
        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=".$filename);
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_RAW;
        return $this->renderPartial('report/generate',[
            'model' => $model,
        ]);
    }
    
    public function actionReportLaporan($nie, $date)
    {
        $sql = "SELECT CONCAT(kode, rand_char) kode FROM kode_kemas
                WHERE no_nie = :nie AND created_at LIKE :date";
        $export = new CsvGrid([
            'dataProvider' => new SqlDataProvider([
                'sql' => $sql,
                'pagination' => false,
                'sort' => false,
                'params' => [
                    ':nie' => $nie,
                    ':date' => "%".$date."%",
                ],
            ]),
            'columns' => [
                [
                    'attribute' => 'kode',
                    'label' => '',
                ],
            ],
            'csvFileConfig' => [
                'enclosure' => '',
            ],
        ]);
        return $export->export()->send('data.txt');
    }
    /**
     * Deletes an existing Kodekemas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kodekemas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kodekemas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kodekemas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
