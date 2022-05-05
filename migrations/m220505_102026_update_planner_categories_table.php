<?php

use yii\db\Migration;

/**
 * Class m220505_102026_update_planner_categories_table
 */
class m220505_102026_update_planner_categories_table extends Migration
{
    const FK = 'fk_planner_category_planner_id';
    const TABLE = '{{%planner_category}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'planner_id', 'INT(11) NOT NULL');
        $this->addForeignKey(
            self::FK,
            self::TABLE,
            'planner_id',
            '{{%user_planner}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::FK, self::TABLE);
        $this->dropColumn(self::TABLE, 'planner_id');
    }
}
