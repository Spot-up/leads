<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model app\models\Leads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leads-form">
	<div id="success-alert" class="alert alert-success alert-dismissible" role="alert" style="display: none">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span id="success-alert-span"></span>
	</div>
	<div id="warning-alert" class="alert alert-warning alert-dismissible" role="alert" style="display: none">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span id="warning-alert-span"></span>
	</div>	

    <?php $form = ActiveForm::begin([
        'id' => 'lead-create-form',
        'enableClientValidation' => false, 
    ]); ?>

    <?= $form->errorSummary($model) ?>    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'phone')->widget(MaskedInput::className(),['mask'=>'+7 (999) 999-99-99'])->textInput(['placeholder'=>'+7 (999) 999-99-99']);?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-10">{input}</div></div>',
    ]) ?>    

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js =
<<<JS
$('#lead-create-form').on('beforeSubmit', function() {
    $("#warning-alert").hide();
    $("#success-alert").hide();
    var form = $(this);
    var data = form.serialize();
    $.ajax({
        url: '/lead/create',
        type: 'POST',
        data: data
    })
    .done(function(data) {
        if (data.success) {
            // данные прошли валидацию, сообщение было отправлено
            $('#success-alert-span').text(data.message);
            $("#success-alert").show();
            form[0].reset();
        }
        else {
        	var errors = data.message;

        	var errorsList = '<ul>';
        	for (var key in errors) {
            	errorsList += '<li>' + errors[key]+'</li>';
        	}
        	errorsList += '</ul>'

            $('#warning-alert-span').html(errorsList);
            $("#warning-alert").show();
        }
    })
    .fail(function () {
        alert('Произошла ошибка при отправке данных!');
    })
    return false; // отменяем отправку данных формы
});
JS;

$this->registerJs($js, $this::POS_READY);
?>