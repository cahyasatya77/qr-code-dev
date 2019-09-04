<?php

namespace backend\controllers;

use Yii;
use backend\models\Agregasiheader;
use backend\models\AgregasiheaderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\SqlDataProvider;
use backend\models\Agregasiline;
use yii\data\ActiveDataProvider;
use dosamigos\qrcode\QrCode;
use dosamigos\qrcode\lib\Enum;
use kartik\mpdf\Pdf;
use yii\db\Expression;

/**
 * AgregasiheaderController implements the CRUD actions for Agregasiheader model.
 */
class AgregasiheaderController extends Controller
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
     * Lists all Agregasiheader models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgregasiheaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Kodekarton model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionQrcode($id)
    {
        $model = Agregasiheader::findOne($id);
        $kode = $model->kode_karton.$model->rand_char;
        return QrCode::png($kode, false, Enum::QR_ECLEVEL_L, 2, 2, true);
    }
    
    public function actionQrcode2($id)
    {
        $model = Agregasiheader::findOne($id);
        $kode = $model->kode_karton.$model->rand_char;
        return QrCode::png($kode, false, Enum::QR_ECLEVEL_L, 4, 2, true);
    }

    /**
     * Displays a single Agregasiheader model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model_detail = new ActiveDataProvider([
            'query' => Agregasiline::find()->where(['id_agregasi' => $id]),
            'pagination' => false, 'sort' => false
        ]);
        
        return $this->render('view', [
            'model' => $model,
            'model_detail' => $model_detail,
        ]);
    }
    
    public function actionViewdetail($id)
    {
        $model = $this->findModel($id);
        $model_detail = new ActiveDataProvider([
            'query' => Agregasiline::find()->where(['id_agregasi' => $id]),
            'pagination' => false, 'sort' => false,
        ]);
        
        return $this->render('view_detail', [
            'model' => $model,
            'model_detail' => $model_detail,
        ]);
    }
    
    /**
     * Get nomor NIE from kode karton.
     * @return mixed
     */
    public function actionGetNie($kode)
    {
        $nie = substr($kode, 4, 15);
        $batch = substr($kode, 23, 5);
        $ed = substr($kode, 32, 6);
        $data = [
            'nie' => $nie,
            'batch' => $batch,
            'ed' => $ed,
        ];
        
        return Json::encode($data);
    }
    
    /**
     * Get nomor batch product
     */
    public function actionBatch()
    {
        $kode = $_REQUEST['nie'];
        $nie = Yii::$app->db_pm->createCommand("SELECT kd_produk FROM tbl_nie WHERE nomor_nie = '".$kode."' GROUP BY kd_produk")->queryOne();
        $sql = "select DECODE(GBH.BATCH_STATUS,1,'Pending','WIP') BATCH_STATUS
                    ,substr(msib.SEGMENT1,3) SEGMENT1
                    ,MLN.LOT_NUMBER
                    ,TO_CHAR(MLN.EXPIRATION_DATE,'DD-MON-RRRR') EXPIRATION_DATE
                FROM gme_material_details gmd
                    ,gme_batch_header gbh
                    ,mtl_system_items_b msib
                    ,mtl_system_items_b msi
                    ,mtl_lot_numbers mln
               WHERE line_type = 1
                 and gbh.batch_id = gmd.BATCH_ID
                 and gmd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                 and gmd.ORGANIZATION_ID = msib.ORGANIZATION_ID
                 and msib.ORGANIZATION_ID = msi.ORGANIZATION_ID
                 and substr(msib.SEGMENT1,3) = substr(msi.SEGMENT1,3)
                 and substr(msi.SEGMENT1,1,2) in ('FG','BP')
                 AND GBH.BATCH_STATUS IN (1,2)
                 AND MSI.INVENTORY_ITEM_ID = MLN.INVENTORY_ITEM_ID
                 AND GMD.ORGANIZATION_ID = MLN.ORGANIZATION_ID
                 AND GBH.ATTRIBUTE1 = MLN.LOT_NUMBER
                 AND (SELECT MIN(GBH1.BATCH_NO)
                        FROM gme_material_details gmd1
                            ,gme_batch_header gbh1
                            ,mtl_system_items_b msib1
                       WHERE GMD1.LINE_TYPE = 1
                         and gbh1.batch_id = gmd1.BATCH_ID
                         and gmd1.INVENTORY_ITEM_ID = msib1.INVENTORY_ITEM_ID
                         and gmd1.ORGANIZATION_ID = msib1.ORGANIZATION_ID
                         AND GBH1.BATCH_STATUS IN (1,2)
                         AND SUBSTR(MSIB1.SEGMENT1,3) = SUBSTR(MSIB.SEGMENT1,3)
                         AND GBH1.ATTRIBUTE1 = GBH.ATTRIBUTE1) = GBH.BATCH_NO
                 AND LENGTH(GBH.ATTRIBUTE1) = 5
                 AND substr(msib.SEGMENT1,3) =:SEGMENT1
               ORDER BY substr(msib.SEGMENT1,3)
                    ,MLN.EXPIRATION_DATE";
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
        $sql = "select DECODE(GBH.BATCH_STATUS,1,'Pending','WIP') BATCH_STATUS
                    ,substr(msib.SEGMENT1,3) SEGMENT1
                    ,MLN.LOT_NUMBER
                    ,TO_CHAR(MLN.EXPIRATION_DATE,'YYMMDD') EXPIRATION_DATE
                FROM gme_material_details gmd
                    ,gme_batch_header gbh
                    ,mtl_system_items_b msib
                    ,mtl_system_items_b msi
                    ,mtl_lot_numbers mln
               WHERE line_type = 1
                 and gbh.batch_id = gmd.BATCH_ID
                 and gmd.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                 and gmd.ORGANIZATION_ID = msib.ORGANIZATION_ID
                 and msib.ORGANIZATION_ID = msi.ORGANIZATION_ID
                 and substr(msib.SEGMENT1,3) = substr(msi.SEGMENT1,3)
                 and substr(msi.SEGMENT1,1,2) in ('FG','BP')
                 AND GBH.BATCH_STATUS IN (1,2)
                 AND MSI.INVENTORY_ITEM_ID = MLN.INVENTORY_ITEM_ID
                 AND GMD.ORGANIZATION_ID = MLN.ORGANIZATION_ID
                 AND GBH.ATTRIBUTE1 = MLN.LOT_NUMBER
                 AND (SELECT MIN(GBH1.BATCH_NO)
                        FROM gme_material_details gmd1
                            ,gme_batch_header gbh1
                            ,mtl_system_items_b msib1
                       WHERE GMD1.LINE_TYPE = 1
                         and gbh1.batch_id = gmd1.BATCH_ID
                         and gmd1.INVENTORY_ITEM_ID = msib1.INVENTORY_ITEM_ID
                         and gmd1.ORGANIZATION_ID = msib1.ORGANIZATION_ID
                         AND GBH1.BATCH_STATUS IN (1,2)
                         AND SUBSTR(MSIB1.SEGMENT1,3) = SUBSTR(MSIB.SEGMENT1,3)
                         AND GBH1.ATTRIBUTE1 = GBH.ATTRIBUTE1) = GBH.BATCH_NO
                 AND LENGTH(GBH.ATTRIBUTE1) = 5 -- 20190406
                 AND substr(msib.SEGMENT1,3) =:SEGMENT1
                 AND MLN.LOT_NUMBER =:NO_BATCH
               ORDER BY substr(msib.SEGMENT1,3)
                    ,MLN.EXPIRATION_DATE";
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
     * Get total isi karton
     */
    public function actionGetIsi($nie) 
    {
        $produk = Yii::$app->db_pm->createCommand("SELECT kd_produk FROM tbl_nie WHERE nomor_nie = '".$nie."' GROUP BY kd_produk")->queryOne();
        $sql = "SELECT MSIB.SEGMENT1, SUBSTR(MSIB.SEGMENT1,3) KODE, MUC.CONVERSION_RATE
                ,MSIB.PRIMARY_UNIT_OF_MEASURE
                ,CASE WHEN UPPER(MSIB.DESCRIPTION) LIKE '%AMPLOP%'
                      THEN TRIM(SUBSTR(MSIB.DESCRIPTION,INSTR(UPPER(MSIB.DESCRIPTION),'AMPLOP')-3,9))
                      WHEN UPPER(MSIB.DESCRIPTION) LIKE '%BLISTER%' AND MSIB.SEGMENT1 != 'FGTAPRE233'
                      THEN TRIM(SUBSTR(MSIB.DESCRIPTION,INSTR(UPPER(MSIB.DESCRIPTION),'BLISTER')-3,10))
                      WHEN UPPER(MSIB.DESCRIPTION) LIKE '%STRIP%' AND MSIB.SEGMENT1 != 'FGTFFLO325'
                      THEN TRIM(SUBSTR(MSIB.DESCRIPTION,INSTR(UPPER(MSIB.DESCRIPTION),'STRIP')-3,8))
                      WHEN UPPER(MSIB.DESCRIPTION) LIKE '%TUBE%' OR UPPER(MSIB.DESCRIPTION) LIKE '%BOTOL%'
                      THEN TRIM(SUBSTR(MSIB.DESCRIPTION,INSTR(MSIB.DESCRIPTION,'@')+1))
                      WHEN MSIB.SEGMENT1 = 'FGTFFLO325' THEN '10 strip'
                      WHEN MSIB.SEGMENT1 = 'FGTAPRE233' THEN '10 blister'
                      ELSE NULL
                  END KEMASAN
                 FROM MTL_SYSTEM_ITEMS_B MSIB, MTL_UOM_CONVERSIONS MUC
                WHERE 1=1
                AND MUC.INVENTORY_ITEM_ID = MSIB.INVENTORY_ITEM_ID
                AND MSIB.ORGANIZATION_ID = 83
                AND SUBSTR(MSIB.SEGMENT1,1,2) in ('FG','BP')
                AND MUC.UOM_CODE = 'CRT'
                AND SUBSTR(MSIB.SEGMENT1,3) =:SEGMENT1";
        $isiKarton = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_o',
            'pagination' => false,
            'params' => [
                ':SEGMENT1' => $produk['kd_produk']
            ],
        ]);
        $model_karton = $isiKarton->getModels();
        
        return Json::encode($model_karton);
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
     * Get expired date
     */
    public function actionEd($id)
    {
        $day = substr($id, 4, 2);
        $month = substr($id, 2, 2);
        $year = substr($id, 0, 2);
        
        $date = $day.'-'.$month.'-20'.$year;
        
        return $date;
    }

    /**
     * Creates a new Agregasiheader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agregasiheader();

        if ($model->load(Yii::$app->request->post())) {
            $kode = '(90)'.$model->no_nie.'(10)'.$model->no_batch.'(17)'.$model->expired_date.'(21)KT';
            $kode_kemas = $model->kode_karton;
            $data_line = Agregasiline::find()->where(['kode_kemas' => $kode_kemas])->one();
            
            if (!isset($data_line)) {
                $model->kode_karton = $model->generateKode($kode);
                $model->rand_char = $this->randomHuruf();
                $model->created_at = new Expression('NOW()');
                $model->created_by = Yii::$app->user->id;
                $model->updated_at = new Expression('NOW()');
                $model->updated_by = Yii::$app->user->id;
                if($model->save()) {
                    Yii::$app->db->createCommand()
                            ->insert('agregasi_line', [
                                'id_agregasi' => $model->id,
                                'kode_kemas' => $kode_kemas,
                                'is_active' => 'TRUE',
                                'is_sample' => 'FALSE',
                                'is_sold' => 'FALSE',
                            ])
                            ->execute();
                    return $this->redirect(['create-detail', 'id' => $model->id]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'QR kode kemasan dus sudah terinput');
                return $this->redirect(['create']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionTotalinput($id)
    {
        $model_agregasi = Agregasiheader::findOne($id);
        $input = new ActiveDataProvider([
            'query' => Agregasiline::find()
                        ->where(['id_agregasi' => $id])
                        ->andWhere(['is_sample' => 'FALSE']),
            'sort' => false, 'pagination' => false,
        ]);
        $total_input = $input->getCount();
        
        return $this->render('detail', [
            'id' => $id,
        ]);
    }
    
    public function actionValidationDetail()
    {
        $post = Yii::$app->request->post();
        if (!empty($post)) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new Agregasiline();
            //$model->scenario = Agregasiline::SCENARION_CREATE;
            $model->load($post);
            
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionCreateDetail($id)
    {
        $model = new Agregasiline();
        $model_agregasi = Agregasiheader::findOne($id);
        $dataLine = new ActiveDataProvider([
            'query' => Agregasiline::find()->where(['id_agregasi' => $id])->andWhere(['is_sample' => 'FALSE']),
            'sort' => FALSE, 'pagination' => false,
        ]);
        $total_input = $dataLine->getCount();
        
        $produk = Yii::$app->db_pm->createCommand("SELECT kd_produk FROM tbl_nie WHERE nomor_nie = '".$model_agregasi->no_nie."' GROUP BY kd_produk")->queryOne();     
        $sql = "select substr(msib.SEGMENT1,3) ITEM_CODE, muc.CONVERSION_RATE CONVERSION
                from mtl_system_items_b msib
                ,mtl_uom_conversions muc
                where 1=1
                and muc.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                and substr(msib.SEGMENT1,1,2) in ('FG','BP')
                and msib.ORGANIZATION_ID = 83
                and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and upper(msib.DESCRIPTION) not like '%SALAH%'
                and muc.UNIT_OF_MEASURE = 'Karton'
                and substr(msib.SEGMENT1,3) = :SEGMENT1";
        $isiKarton = new SqlDataProvider([
            'sql' => $sql,
            'db' => 'db_o',
            'pagination' => false,
            'params' => [
                ':SEGMENT1' => $produk['kd_produk'],
            ],
        ]);
        $max_karton = $isiKarton->getModels();
        $max = $max_karton[0]['CONVERSION'];
        $flash = null;
        $karton_max = null;
        
        $total = ($total_input/$max) * 100;
        
        if ($model->load(Yii::$app->request->post())) {
            if ($dataLine->count < $max) {
                $data = Agregasiline::findOne(['kode_kemas' => $model->kode_kemas]);
                if ($data == null) {
                    $model->id_agregasi = $model_agregasi->id;
                    //$model->kode_kemas = Yii::$app->request->post('kode_kemas');
                    $model->save();
                } 
                // notifikasi flash jika data 2 kali tersimpan belum ada flash
                else { 
                    Yii::$app->session->setFlash('error', 'Maaf data yang dimasukan sudah ada, Silahkan cek kembali.');
                    //$flash = 'gagal';
                }
            } else {
                Yii::$app->session->setFlash('warning', 'Kapasitas karton pada produk telah melibihi batas.');
                //$karton_max = 'overcapasity';
            }
        }
        
        return $this->render('detail',[
            'id' => $id,
            'model' => $model,
            'model_agregasi' => $model_agregasi,
            // 'dataLine' => $dataLine,
            // 'flash' => $flash,
            // 'karton_max' => $max_karton,
            'total' => $total,
            'max' => $max,
            'total_input' => $total_input,
        ]);
    }

    /**
     * Updates an existing Agregasiheader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Remove an existing Agregasiheader model.
     * If remove is Successful, the browser will be redirected to the 'remove' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found.
     */
    public function actionRemove()
    {
        $searchModel = new AgregasiheaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('remove',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Print Label Karton.
     * If print successful, the browser will be redirected to 'pdf' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCetakLabel($id)
    {
        $model = Agregasiheader::findOne($id);
        $contents = $this->renderPartial('label',[
            'model' => $model,
        ]);
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => [20, 20],
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $contents,
            'marginLeft' => 1, 
            'marginTop' => 0, 
            'marginRight' => 1, 
            'marginBottom' => 1,
            'defaultFont' => 'Calibri',
        ]);
        $pdf->getApi()->SetJS('this.print(); this.close();');
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $header = Yii::$app->response->headers;
        $header->add('Conten-Type', 'aplication/pdf');
        return $pdf->render();
    }
    
    /**
     * Cetak label karton
     */
    public function actionCetakKarton($id)
    {
        $karton = Agregasiheader::findOne(['id' => $id]);
        $sql = "SELECT p.kd_produk, p.nama_produk, n.kemasan 
                FROM tbl_produk p
                JOIN tbl_nie n ON n.kd_produk = p.kd_produk
                WHERE n.nomor_nie='".$karton->no_nie."'
                GROUP BY p.kd_produk";
        $produk = Yii::$app->db_pm->createCommand($sql)->queryOne();
        
        $sql_suhu = "select MSIB.SEGMENT1, MSIB.DESCRIPTION
                ,MSIB.ATTRIBUTE7 DERAJAT
                ,MSIB.ATTRIBUTE8 ANGKA_RELEASE
                from mtl_system_items_b msib
                where 1=1
                and msib.ORGANIZATION_ID = 83
                and substr(msib.SEGMENT1,1,2) in ('FG','BP')
                AND MSIB.INVENTORY_ITEM_STATUS_CODE = 'Active'
                and upper(msib.DESCRIPTION) not like '%SALAH%'
                AND substr(msib.SEGMENT1,3) = '".$produk['kd_produk']."'";
        $suhu = Yii::$app->db_o->createCommand($sql_suhu)->queryOne();
        
        $dus = Agregasiline::find()->where(['id_agregasi' => $id])->all();
        $data_dus = count($dus);
        
        $contents = $this->renderPartial('_report',[
            'karton' => $karton,
            'produk' => $produk,
            'suhu' => $suhu,
            'data_dus' => $data_dus,
        ]);
        
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $contents,
            'marginLeft' => 5, 
            'marginTop' => 5, 
            'marginRight' => 5, 
            'marginBottom' => 5,
        ]);
        $pdf->getApi()->SetJS('this.print();');
        $pdf->cssInline = '.fontHeader {
                                font-size: 55vh;
                                white-space: nowrap;
                                height: 100px;
                            }';
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $header = Yii::$app->response->headers;
        $header->add('Conten-Type', 'aplication/pdf');
        return $pdf->render();
    }
    
    /**
     * Deletes an existing Agregasiheader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Data Karton berhasil dihapus.');
        return $this->redirect(['remove']);
    }
    
    public function actionDeletedetail($id, $del) 
    {
        $agregasi = $this->findModel($id);
        $model = Agregasiline::findOne($del);
        $model->delete();
        
        Yii::$app->session->setFlash('warning', 'Data QR Dus berhasil dihapus');
        return $this->redirect(['viewdetail', 'id' => $agregasi->id]);
    }

    /**
     * Finds the Agregasiheader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agregasiheader the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agregasiheader::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
