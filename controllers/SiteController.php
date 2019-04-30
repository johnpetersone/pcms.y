<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\editForm;
use yii\db\Connection;

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
	
    public function actionIndex()
    {
		
		// render page
		$page=$_GET['page'];
		if (isset($_GET['page2'])) $page.='/'.$_GET['page2'];
		
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
