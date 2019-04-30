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
	function pMenuItem($caption, $page, $route) {
		//['label' => 'Főoldal', 'url' => Url::to(['site/index', 'page' => 'index']), 'active' => isset($_GET['page'])&&($_GET['page']=='index')]
		
		if (isset($_GET['page2'])) 
			$active = ($_GET['page'].'/'.$_GET['page2']==$page);
		else if (isset($_GET['page'])) 
			$active = ($_GET['page']==$page);
		else
			$active = false;
			
		
		$item = [
			'label'  => $caption,
			'url'    => str_replace('%2F', '/', Url::to([$route, 'page' => $page])), 
			'active' => $active,
		];
		return $item;
	}

	// get page title from database
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
	$this->params['breadcrumbs'][] = pMenuItem( $this->title, 'index', 'site/index');
	if (isset($_GET['page'])) 	
		$this->params['breadcrumbs'][] = pMenuItem( pageTitle($_GET['page']), $_GET['page'], 'site/index');
	if (isset($_GET['page2'])) 	
		$this->params['breadcrumbs'][] = pMenuItem( pageTitle($_GET['page'].'/'.$_GET['page2']), $_GET['page'].'/'.$_GET['page2'], 'site/index');
		
	// Nav widget and generate menus
	$pages = Yii::$app->db->createCommand('SELECT title, page FROM pages WHERE page NOT LIKE "%/%" ORDER BY CASE WHEN page = "index" THEN 0 ELSE 1 END, title')
		->queryAll(\PDO::FETCH_OBJ);		
	//Build top level menu
	foreach ($pages as $page) {
		$subPages = Yii::$app->db->createCommand('SELECT title, page FROM pages WHERE page LIKE :pagepattern')
			->bindValue(':pagepattern', $page->page.'/%')
			->queryAll(\PDO::FETCH_OBJ);
			
		$menuitem = pMenuItem($page->title,$page->page, 'site/index');
		
		//Build second level menu
		if ($subPages)  
			foreach ($subPages as $subitem) 
				$menuitem['items'][] = pMenuItem($subitem->title,$subitem->page, 'site/index');
		
		$menuitems[] = $menuitem;
	}
	
	// if logged in
	if ( ! Yii::$app->user->isGuest) {
		// admin menu
		$menuitem = ['label'=>'Admin menü', 'linkOptions'=>['style'=>'margin-left:5px;']];
		
		// edit button
		$menuitem['items'][] = pMenuItem('szerkeszt', isset($_GET['page2']) ? ($_GET['page'].'/'.$_GET['page2']) : ($_GET['page']), 'site/edit');
		
		// delete button
		$menuitem['items'][] = pMenuItem('töröl', isset($_GET['page2']) ? ($_GET['page'].'/'.$_GET['page2']) : ($_GET['page']), 'site/delete');

		// new top menu button
		$menuitem['items'][] = pMenuItem('új oldal', isset($_GET['page2']) ? ($_GET['page'].'/'.time()) : (time()), 'site/edit');
		
		// logout button
		$menuitem['items'][] = ['label'=>'kijelentkezés ('.Yii::$app->user->identity->username.')', 'url'=>['/site/logout'], 'linkOptions'=>['data-method'=>'post'] ];
		
		$menuitems[] = $menuitem;

	} else {
		$menuitems[] = ['label' => 'Bejelentkezés', 'url' => ['/site/login']];
	}
	
	
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav nav-pills'],
        'items' => $menuitems ,
    ]);
    NavBar::end();
	
   ?>
	
    <div class="container">
        <?= Breadcrumbs::widget([
			'homeLink' => false, 
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?//= Alert::widget() ?>
		
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; PCMS.Y Bootstrap 4 <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
