<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;

?>
<div>
    <div class="jumbotron">
        <h2><?= $model->_id ?></h2>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('Edit', ['update?id=' . $model->email], ['class' => 'btn btn-default',]); ?>
    </div>

    <div class="row mb10">
        <div class="col-md-12">
            <p>
                <strong><?= Html::encode($model->getAttributeLabel('_id')); ?>: </strong>
                <?= Html::encode($model->_id); ?>
            </p>
            <p>
                <strong><?= Html::encode($model->getAttributeLabel('email')); ?>: </strong>
                <?= Html::encode($model->email); ?>
            </p>
            <p>
                <strong><?= Html::encode($model->getAttributeLabel('password_hash')); ?>: </strong>
                <?= Html::encode($model->password_hash); ?>
            </p>
            <p>
                <strong><?= Html::encode($model->getAttributeLabel('auth_token')); ?>: </strong>
                <?= Html::encode($model->auth_token); ?>
            </p>
            <p>
                <strong><?= Html::encode($model->getAttributeLabel('title')); ?>: </strong>
                <?= Html::encode($model->title); ?>
            </p>
            <p>
                <strong><?= Html::encode($model->getAttributeLabel('bio')); ?>: </strong>
                <?= Html::encode($model->bio); ?>
            </p>
            <p>
                <strong><?= Html::encode($model->getAttributeLabel('avatar_url')); ?>: </strong>
                <?= Html::encode($model->avatar_url); ?>
            </p>
        </div>
    </div>

    <br>

</div>
