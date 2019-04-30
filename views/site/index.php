<?php

/* @var $this yii\web\View */

$this->title = 'PCMS.Y';
/* Switch layout to pcms*/
$this->context->layout = 'main.pcms.y.php';

?>
<div class="site-index">
		
    <div>
        <h1><?=$pagedata->title ?></h1>
    </div>

    <div class="body-content"><?=$pagedata->html?></div>

	<!-- <DIV>GET:<? print_r($_GET); ?></DIV> -->

</div>
