<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Leads */

$this->title = 'Изменение лида: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Лиды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="leads-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
