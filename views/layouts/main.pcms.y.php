<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Alert;
use yii\helpers\Html;
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
		
		
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Főoldal', 'url' => ['/site/index']],
            ['label' => 'Rólunk', 'url' => ['/site/about']],
            ['label' => 'Kapcsolat', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Bejelentkezés', 'url' => ['/site/login']]
            ) : (
                ''
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton('Kijelentkezés (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']  )
                . Html::endForm()
                
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?//= Alert::widget() ?>
		
		<PRE><? //=$homeLink?></PRE>
		
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
