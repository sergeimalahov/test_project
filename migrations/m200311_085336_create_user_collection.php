<?php

class m200311_085336_create_user_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('user');
        $this->createIndex('user', 'email');
    }

    public function down()
    {
        $this->dropIndex('user', 'user_id');
        $this->dropCollection('user');
    }
}
