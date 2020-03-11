<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model \app\modules\api\v1\models\User */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="mb30">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'auth_token')->textInput(['maxlength' => true])->label('Auth Token') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Title') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'bio')->textInput(['maxlength' => true])->label('Bio') ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'avatar_url')->textInput(['maxlength' => true])->label('Avatar Url') ?>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
