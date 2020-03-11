<?php

use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

echo Modal::widget([
    'id' => 'mymodal-lang',
    'toggleButton' => false,
]);

?>

<div class="frontend-outher">

    <div class="jumbotron">
        <h2><?= Yii::t('app', 'Users') ?></h2>
    </div>

    <div>
        <div class="body-content">
            <?= GridView::widget([
                'dataProvider' => $users,
                'columns' => [
                    '_id',
                    'email',
                    'title',
                    'bio',
                    'avatar_url',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ['width' => '30'],
                        'template' => '{view} {update} {delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>

