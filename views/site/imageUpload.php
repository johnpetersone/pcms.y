<?php
use yii\widgets\ActiveForm;

/* Switch layout to pcms*/
$this->context->layout = 'main.pcms.y.php';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <button>Feltölt</button>

<?php ActiveForm::end() ?>



<!-- show gallery -->
<STYLE> .tmb {object-fit: cover; width: 200px; height: 200px; } </STYLE>
<DIV style="padding:20px 0">
<?
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != 'off'))  $imageURLBase = 'https://'; 
else $imageURLBase = 'http://';
$imageURLBase.= $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']).'/../uploads/';

$dir = '../uploads';
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if (substr($file,0,1) !='.') {
				?><IMG class="tmb" src="<?=$imageURLBase.$file?>"><?
			}
		}
	closedir($dh);
	}
}
?>
</DIV>