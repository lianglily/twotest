<?php

use yii\db\Migration;

/**
 * Class m200813_082415_test_user
 */
class m200813_082415_test_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200813_082415_test_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200813_082415_test_user cannot be reverted.\n";

        return false;
    }
    */
}
