<?php

use yii\db\Migration;

/**
 * Class m220505_140809_update_user_planner_table
 */
class m220505_140809_update_user_planner_table extends Migration
{
    const TABLE = '{{%user_planner}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'currency', 'INT(11) NOT NULL DEFAULT 1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'currency');
    }
}
