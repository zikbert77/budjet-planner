<?php

use yii\db\Migration;

/**
 * Class m220505_125346_update_planner_category_table
 */
class m220505_125346_update_planner_category_table extends Migration
{
    const TABLE = '{{%planner_category}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::TABLE, 'percent', $this->float(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn(self::TABLE, 'percent');
    }
}
