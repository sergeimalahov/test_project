<?php

namespace app\modules\api\v1;

use yii\web\Response;

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        \Yii::$app->user->enableSession = false;

        \Yii::$app->setComponents([
            'response' => [
                'class' => Response::class,
                'format' => Response::FORMAT_JSON,
                'charset' => 'UTF-8',
            ]
        ]);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\CompositeAuth::class,
            'authMethods' => [
                \yii\filters\auth\HttpBearerAuth::class,
                \yii\filters\auth\QueryParamAuth::class,
                \yii\filters\auth\HttpHeaderAuth::class,
            ],
            'except' => ['user/login']
        ];

        return $behaviors;
    }
}
