<?php

namespace app\commands;

use app\models\User;
use Faker\Factory;
use yii\console\Controller;

class SeedController extends Controller
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * SeedController constructor.
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->faker = Factory::create();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        \Yii::$app->mongodb->getCollection('user')->remove();

        foreach (range(0, 100) as $key) {
            $user = new User();
            $user->email = $this->faker->email;
            $user->password_hash = \Yii::$app->security->generatePasswordHash('test');
            $user->auth_token = $this->faker->sha1;
            $user->title = $this->faker->jobTitle;
            $user->bio = $this->faker->text(10);
            $user->avatar_url = $this->faker->imageUrl();
            $user->save();
        }
    }
}