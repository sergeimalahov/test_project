<?php

namespace app\modules\api\v1\resources;

class User extends \app\modules\api\v1\models\User
{
    /**
     * @return array
     */
    public function fields()
    {
        return ['_id', 'email', 'title', 'bio', 'avatar_url'];
    }
}