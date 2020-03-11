<?php

use yii\helpers\Html;

$this->title = 'Update - ' . $model->email;

?>
<div class="product-update">
    <div class="jumbotron">
        <h2><?= $this->title ?></h2>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']); ?>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
