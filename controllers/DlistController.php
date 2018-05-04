<?php

namespace app\controllers;

use Yii;
use app\models\Dlist;
use app\models\DlistSearch;
use app\models\DlistSeznam;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Nabidky;
use app\models\Zakazniky;
use app\models\Countries;
use kartik\mpdf\Pdf;
use app\models\Log;

/**
 * DlistController implements the CRUD actions for Dlist model.
 */
class DlistController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Dlist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DlistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->query->where(['smazat'=>'0']);
		$dataProvider->sort = ['defaultOrder' => ['id' => 'DESC']];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dlist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dlist();
		
		// Nabidky
		$nab = array();
		$nab['id'] = Yii::$app->request->get('idn');
		
		if($nab['id'] > 0)
		{
			$nabidky = Nabidky::findOne($nab['id']);
			$nab['popis'] = $nabidky->popis;
			$nab['vystaveno'] = $nabidky->vystaveno;
			$nab['platnost'] = $nabidky->platnost;
			$nab['zpusoby_platby_id'] = $nabidky->zpusoby_platby_id;
			$nab['zakazniky_id'] = $nabidky->zakazniky_id;
		}
		
        if ($model->load(Yii::$app->request->post())) 
		{
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			$model->platnost = date('Y-m-d', strtotime($model->platnost));
			
			if (!$model->nabidky_id)
			{
				$model->nabidky_id = 0;
			}
			
			$model->save();
			
			// cislo
			$cislo = "DLV-" . $model->id;
			$nb = Dlist::findOne($model->id);
			$nb->cislo = $cislo;
			$nb->update();
			
			$dlist_id = $model->id;
			$count_polozka = Yii::$app->request->post('count_polozka');	

			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);

				$pocet = Yii::$app->request->post('pocet' . $i); 
				$cena = Yii::$app->request->post('cena' . $i); 
				$typ_ceny = Yii::$app->request->post('typ_ceny' . $i);;
				$sazba_dph = Yii::$app->request->post('sazba_dph' . $i);
				$sleva = Yii::$app->request->post('sleva' . $i);
				$celkem = Yii::$app->request->post('celkem' . $i);
				$celkem_dph = Yii::$app->request->post('celkem_dph' . $i);
				$vcetne_dph = Yii::$app->request->post('vcetne_dph' . $i);
				
				if ($seznam_id > 0 && $dlist_id > 0)
				{
					$dlistSeznam = DlistSeznam::addDlistSeznam($dlist_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
				
				/*
				// Rezervace
				$sz = Seznam::find()->where(['id' => $seznam_id])->one();
				$objednano_old = $sz['objednano']; 
				$objednano_new = intval($objednano_old + $pocet);

				$seznam = Seznam::findOne($seznam_id);
				$seznam->objednano = $objednano_new;
				$seznam->update();
				 * 
				 */
			}
			
			// Log
			$addLog = Log::addLog("Přidal dodací list", $model->id);
			Yii::$app->session->setFlash('success', "Dodací list přidan úspěšně");

            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } 
		else
		{
            return $this->render('create', [
                'model' => $model,
				'nab' => $nab,
            ]);
        }
    }

    /**
     * Updates an existing Dlist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post()))
		{
			$model->vystaveno = date('Y-m-d', strtotime($model->vystaveno));
			$model->platnost = date('Y-m-d', strtotime($model->platnost));
			
			$model->save();
			
			$dlist_id = $id;
			
			$all_celkem_old = 0;
			
			$nab = Dlist::find()->where(['id' => $id])->one();
			$nabidky_id = $nab['nabidky_id'];

			$nbs = DlistSeznam::find()->where(['dlist_id' => $dlist_id])->all();
			foreach($nbs as $nb)
			{
				$all_celkem_old = $all_celkem_old + $nb['celkem'];
				
				$seznam_id = $nb['seznam_id'];
				$pocet = $nb['pocet'];
				
				/*
				// Rezervace delete
				if ($seznam_id > 0)
				{
					if($nabidky_id > 0)
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$rezerva_old = $sz['rezerva'];

						$objednano_new = intval($objednano_old - $pocet);
						$rezerva_new = intval($rezerva_old - $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->rezerva = $rezerva_new;
						$seznam->update();
					}
					else
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$objednano_new = intval($objednano_old - $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->update();
					}
				}
				 * 
				 */
			}
			
			$deleteOS = DlistSeznam::deleteDlistSeznam($dlist_id);
			
			//print_r(Yii::$app->request->post());
			//exit();
			
			$all_celkem_new = 0;
			
			$count_polozka = Yii::$app->request->post('count_polozka');	
			
			for($i=1; $i <= $count_polozka; $i++)
			{
				$seznam_id = Yii::$app->request->post('idpolozka' . $i);
				$pocet = Yii::$app->request->post('pocet' . $i);
				$cena = Yii::$app->request->post('cena' . $i); 
				$typ_ceny = Yii::$app->request->post('typ_ceny' . $i);;
				$sazba_dph = Yii::$app->request->post('sazba_dph' . $i);
				$sleva = Yii::$app->request->post('sleva' . $i);
				$celkem = Yii::$app->request->post('celkem' . $i);
				$celkem_dph = Yii::$app->request->post('celkem_dph' . $i);
				$vcetne_dph = Yii::$app->request->post('vcetne_dph' . $i);
				
				$all_celkem_new = $all_celkem_new + $celkem;
				
				if ($seznam_id > 0 && $dlist_id > 0)
				{
					$dlistSeznam = DlistSeznam::addDlistSeznam($dlist_id, $seznam_id, $pocet, $cena, $typ_ceny, $sazba_dph, $sleva, $celkem, $celkem_dph, $vcetne_dph);
				}
				
				if ($dlistSeznam_id > 0)
				{
					$sz = Seznam::findOne($seznam_id);
					$stav_old = $sz['stav'];
					$rezerva_old = $sz['rezerva']; 

					$stav_new = intval($stav_old - $pocet);
					$rezerva_new = intval($rezerva_old - $pocet);

					$sz->stav = $stav_new;
					$sz->rezerva = $rezerva_new;
					$sz->update();
				}	

				/*
				// Rezervace add
				if ($seznam_id > 0)
				{
					if($nabidky_id > 0)
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$rezerva_old = $sz['rezerva'];

						$objednano_new = intval($objednano_old + $pocet);
						$rezerva_new = intval($rezerva_old + $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->rezerva = $rezerva_new;
						$seznam->update();
					}
					else
					{
						$sz = Seznam::find()->where(['id' => $seznam_id])->one();
						$objednano_old = $sz['objednano']; 
						$objednano_new = intval($objednano_old + $pocet);

						$seznam = Seznam::findOne($seznam_id);
						$seznam->objednano = $objednano_new;
						$seznam->update();
					}
				}
				 * 
				 */
			}
			
			if($nab['id'] > 0)
			{
				// nabidky
				$nabidky = Nabidky::findOne($id);
				$nabidky->faktura_vydana = 1;
				$nabidky->status_id = 4;
				$nabidky->update();
			}
			
			// Log
			$addLog = Log::addLog("Opravil dodací list. Stará suma = {$all_celkem_old} Kč, nová suma = {$all_celkem_new} Kč", $id);
			Yii::$app->session->setFlash('success', "Dodací list opraven úspěšně");
			
            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } 
		else
		{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dlist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
		// Delete
		$nb = Dlist::findOne($id);
		$nb->smazat = 1;
		$nb->update();
		
		// Log
		$addLog = Log::addLog("Smazal dodací list", $id);
		
		//$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dlist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionPrint($id)
	{
		$nabidky = Nabidky::findOne($id);
		$zakazniky = Zakazniky::findOne($nabidky->zakazniky_id);
		$countries_f = Countries::findOne($zakazniky->f_countries_id);
		$countries_d = Countries::findOne($zakazniky->d_countries_id);
		$dlist_seznam = DlistSeznam::find()->where(['dlist_id' => $id])->all();
		
		$content = $this->renderPartial('template-pdf', [
												'id' => $nabidky->id, 
												'cislo' => $nabidky->cislo,
												'vystaveno' => date('d.m.Y', strtotime($nabidky->vystaveno)),
												'platnost' => date('d.m.Y', strtotime($nabidky->platnost)),
												'zname' => $zakazniky->name,
												'zico' => $zakazniky->ico,
												'zdic' => $zakazniky->dic,
												'zfulice' => $zakazniky->f_ulice,
												'zfpsc' => $zakazniky->f_psc,
												'zfmesto' => $zakazniky->f_mesto,
												'zfzeme' => $countries_f->name,
												'zdulice' => $zakazniky->d_ulice,
												'zdpsc' => $zakazniky->d_psc,
												'zdmesto' => $zakazniky->d_mesto,
												'zdzeme' => $countries_d->name,
												'zphone' => $zakazniky->phone,
												'zmobil' => $zakazniky->mobil,
												'zemail' => $zakazniky->email,
												'dlist_seznam' => $dlist_seznam,
			
										]);
		$pdf = new Pdf([
			'mode' => Pdf::MODE_UTF8, 
			'format' => Pdf::FORMAT_A4, 
			'orientation' => Pdf::ORIENT_PORTRAIT, 
			'destination' => Pdf::DEST_DOWNLOAD, 
			'marginHeader' => 5,
			'marginFooter' => 3,
			'marginTop' => 22,
			'marginRight' => 12,
			'marginLeft' => 12,
			'marginBottom' => 10,
			'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			'cssInline' => '.title_pdf{font-size:7px}', 
			'options' => ['title' => 'ERKADO'],
			'methods' => [ 
				'SetHeader'=>['

<table class="title_pdf">
  <tr>
    <th>ERKADO CZ s.r.o.</th>
    <th>IČ: 27909590</th>
    <th>DIČ: CZ27909590</th>
	<th colspan="2" style="font-weight: normal; font-size: 10px;">Sídlo společností: Krausova 604, Letňany, Praha 22, 19900</th>
  </tr>
  <tr>
	  <td><img src="https://dvere-erkado.cz/img/logo.png" width="135"/></td>
    <td valign="top">
		<b>CENTRÁLA-SKLAD</b><br> 
		Průběžná 1548/90, Strašnice<br> 
		Praha 10, 10000<br>
		tel.: 244 460 824, 722 265 123<br> 
		e-mail: info@erkado.cz
	</td>
    <td valign="top">
		<b>POBOČKA PRAHA 6</b><br> 
		Bělohorská 161/279, Břevnov<br>
		Praha 6, 16900<br>
		tel.: 283 980 500<br>
		e-mail: praha6@erkado.cz
	</td>
	<td valign="top">
		<b>POBOČKA BRNO</b><br>
		Cejl 109, Zábrdovice<br>
		Brno, 60200<br>
		tel.: 545 222 111<br>
		e-mail: brno@erkado.cz
	</td>
	<td valign="top">
		<b>E-SHOP:</b><br>
		www.erkado.cz<br>
		www.dvere-erkado.cz
	</td>
  </tr>
</table>

					'], 
				'SetFooter' => ['<div style="font-size: 9px; font-weight: normal; margin-top: 7px; font-style: normal; "><div style="float: left; width: 50%;  text-align: left;">Společnost je vedená u rejstříkového soudu v Praze - oddíl C, vložka 125808</div><div style="float: left; width: 5%; text-align: right;">{PAGENO} / {nb}</div><div style="float: left; width: 45%; text-align: right;">Zpracováno systémem ERKADO. Vytiskl(a): ' . Yii::$app->user->identity->name . '</div></div>'],
			],
			'filename' => "Dodaci-list-{$id}.pdf",
			'content' => $content,  	
		]);

		return $pdf->render();
	}
}
