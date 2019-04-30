<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php				
		
	Navbar::begin([
      'brandLabel' => Yii::$app->name,
      'brandUrl' => Yii::$app->homeUrl,
			'options' => ['class' => ['navbar-dark', 'bg-dark', 'navbar-expand-md']]		
	]); 
	// generate links to pages
	function pMenuItem($caption, $page) {
		//['label' => 'Főoldal', 'url' => Url::to(['site/index', 'page' => 'index']), 'active' => isset($_GET['page'])&&($_GET['page']=='index')]
		
		if (isset($_GET['page2'])) 
			$active = ($_GET['page'].'/'.$_GET['page2']==$page);
		else if (isset($_GET['page'])) 
			$active = ($_GET['page']==$page);
		else
			$active = false;
			
		
		$item = [
			'label'  => $caption,
			'url'    => str_replace('%2F', '/', Url::to(['site/index', 'page' => $page])), 
			'active' => $active,
		];
		return $item;
	}
	
	function pageTitle($page) {
		$query = Yii::$app->db->createCommand('SELECT title FROM pages WHERE page=:page')
			->bindValue(':page', $page)
			->queryOne(\PDO::FETCH_OBJ);
		if ($query)
			return $query->title;
		else 
			return $page;
	}
	
	// Setting Breadcrumbs
	$this->params['breadcrumbs'][] = pMenuItem( $this->title, 'index');
	if (isset($_GET['page'])) 	$this->params['breadcrumbs'][] = pMenuItem( pageTitle($_GET['page']), $_GET['page']);
	if (isset($_GET['page2'])) 	$this->params['breadcrumbs'][] = pMenuItem( pageTitle($_GET['page'].'/'.$_GET['page2']), $_GET['page'].'/'.$_GET['page2']);
		
	// Nav vidget and genetare menus
	$pages = Yii::$app->db->createCommand('SELECT title, page FROM pages WHERE page NOT LIKE "%/%"')
		->queryAll(\PDO::FETCH_OBJ);		
	//Build top level menu
	foreach ($pages as $page) {
		$subPages = Yii::$app->db->createCommand('SELECT title, page FROM pages WHERE page LIKE :pagepattern')
			->bindValue(':pagepattern', $page->page.'/%')
			->queryAll(\PDO::FETCH_OBJ);
			
		$menuitem = pMenuItem($page->title,$page->page);
		
		//Build second level menu
		if ($subPages)  
			foreach ($subPages as $subitem) 
				$menuitem['items'][] = pMenuItem($subitem->title,$subitem->page);
		
		$menuitems[] = $menuitem;
	}
	$menuitems[] = ['label' => 'Rólunk', 'url' => ['site/about']];
	$menuitems[] = ['label' => 'Kapcsolat', 'url' => ['site/contact']];
	$menuitems[] =
		Yii::$app->user->isGuest ? (
			['label' => 'Bejelentkezés', 'url' => ['/site/login']]
		) : (
			''
			. Html::beginForm(['/site/logout'], 'post')
			. Html::submitButton('Kijelentkezés (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']  )
			. Html::endForm()
			
		);	
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav nav-pills'],
        'items' => $menuitems ,
    ]);
    NavBar::end();
	
   ?>
	
    <div class="container">
        <?= Breadcrumbs::widget([
			'homeLink' => False, 
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?//= Alert::widget() ?>
		
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; PCMS.Y <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
