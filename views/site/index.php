<?php

/* @var $this yii\web\View */

$this->title = 'PCMS.Y';
/* Switch layout to pcms*/
$this->context->layout = 'main.pcms.y.php';

?>
<div class="site-index">
		
    <div class="jumbotron">
        <h1><?=$pagedata->title ?></h1>
        <p class="lead">PCMS.Y Bootstrap 4</p>
    </div>

    <div class="body-content"><?=$pagedata->html?></div>

	<!-- <DIV>GET:<? print_r($_GET); ?></DIV> -->

</div>
