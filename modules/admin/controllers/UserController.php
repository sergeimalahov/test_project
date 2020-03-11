<?php

namespace app\modules\admin\controllers;

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $users = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        $users->pagination->pageSize = 10;

        return $this->render('index', [
            'users' => $users,
        ]);
    }
}
