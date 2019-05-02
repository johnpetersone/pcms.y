<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\editForm;
use app\models\imageUploadModel;
use yii\db\Connection;
use app\models\UploadForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
    public function actionImage()
    {
        $model = new imageUploadModel();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['site/image']);
            }
        }

        return $this->render('imageUpload', ['model' => $model]);
    }
	
    public function actionIndex()
    {
		if (isset($_GET['page'])) $page=$_GET['page'];
		else return $this->render('error', ['name'=>'404', 'message'=>'Az oldal nem található!']);
		if (isset($_GET['page2'])) $page.='/'.$_GET['page2'];
	
		# Set META
		$query = Yii::$app->db->createCommand('SELECT keywords, description FROM pages WHERE page=:page')
			->bindValue(':page', $page)
			->queryOne(\PDO::FETCH_OBJ);
		if ($query) {
			Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $query->description]);
			Yii::$app->view->registerMetaTag(['name' => 'keywords',    'content' => $query->keywords]);		
		}
		
		# render page		
		$pagedata = Yii::$app->db->createCommand('SELECT * FROM pages WHERE page=:page')
			->bindValue(':page', $page)
			->queryOne(\PDO::FETCH_OBJ);
		if ($pagedata) 
			return $this->render('index', ['pagedata' => $pagedata]);
		else
			return $this->render('error', ['name'=>'404', 'message'=>'Az oldal nem található az adatbázisban!']);
    }

    public function actionEdit()
    {
		if (isset($_GET['page'])) $page=$_GET['page'];
		else return $this->render('error', ['name'=>'404', 'message'=>'Az oldal nem található!']);

		$page=$_GET['page'];
		if (isset($_GET['page2'])) $page.='/'.$_GET['page2'];
		
        $model = editForm::find()->where(['page'=>$page])->one();
		$model = $model ? $model : new editForm();
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goBack();
        } else {
            return $this->render('edit', ['model' => $model]);
        }		
		
    }
	
    public function actionDelete()  {
		if (isset($_GET['page'])) $page=$_GET['page'];
		else return $this->render('error', ['name'=>'404', 'message'=>'Az oldal nem található!']);

		$page=$_GET['page'];
		if (isset($_GET['page2'])) $page.='/'.$_GET['page2'];
		
		if ($page != 'index')
			Yii::$app->db->createCommand()->delete('pages', 'page=:page')->bindValue(':page', $page)->execute();
		$this->goHome();
    }
	
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
