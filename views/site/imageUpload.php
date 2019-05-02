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
<DIV style="padding:20px 0"><? include('gallery.php') ?></DIV>