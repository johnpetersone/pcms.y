<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'PCMS.Y';
/* Switch layout to pcms*/
$this->context->layout = 'main.pcms.y.php';

?>
<div class="site-index">		
    <div>
        <h1>szerkesztő</h1>
    </div>
    <?php $form = ActiveForm::begin(); ?>
		
		<?= $form->field($model, 'page')->textInput() ?>
		<?= $form->field($model, 'title')->textInput() ?>
		<?= $form->field($model, 'html')->textArea() ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    <?php ActiveForm::end(); ?>
</div>
