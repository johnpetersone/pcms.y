<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

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
		<?= $form->field($model, 'html')->widget(CKEditor::className(), [ 'options' => ['rows' => 2, 'preset' => 'full', 'extraPlugins'=>'imageuploader' ]]);	?>
		
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Létrehoz' : 'Ment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    <?php ActiveForm::end(); ?>
	<img alt="" src="https://driftwood.btk.pte.hu/pcms.y/uploads/IMG_20180503_125651.jpg" style="height:168px; width:300px">
</div>

