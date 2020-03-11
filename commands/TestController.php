<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        User::find()->where(['_id' => '5e68ba45a0547a41841012a4'])->one();
    }
}
