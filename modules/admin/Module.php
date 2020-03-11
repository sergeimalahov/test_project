<?php

namespace app\modules\admin;

class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    public $layout = '@app/views/layouts/main.php';

    public $defaultRoute = 'user';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
