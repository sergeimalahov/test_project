<?php

namespace app\modules\api\v1\controllers;

use app\modules\api\v1\resources\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

class UserController extends AbstractController
{
    /**
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
    }

    /**
     * @return User
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        $user = new User(['scenario' => 'insert']);
        $user->load(\Yii::$app->request->post(), '');

        if ($user->save()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);

            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $user->_id], true));
        } elseif (!$user->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $user;
    }

    /**
     * @param $id
     * @return User|null
     * @throws ServerErrorHttpException
     */
    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        $user->load(\Yii::$app->request->post(), '');

        if ($user->save() === false && !$user->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $user;
    }

    /**
     * @return array|null|\yii\mongodb\ActiveRecord
     * @throws UnprocessableEntityHttpException
     */
    public function actionLogin()
    {
        $request = \Yii::$app->request;

        //todo: add validation form
        $user = User::findByEmail($request->post('email'));

        if (!$user || !$user->validatePassword($request->post('password'))) {
            throw new UnprocessableEntityHttpException('Incorrect email or password.');
        }

        return $user->getAttributes(array_merge($user->fields(), ['auth_token']));
    }
}