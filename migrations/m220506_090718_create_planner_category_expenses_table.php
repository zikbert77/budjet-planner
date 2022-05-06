<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%planner_category_expenses}}`.
 */
class m220506_090718_create_planner_category_expenses_table extends Migration
{
    const TABLE = '{{%planner_category_expenses}}';
    const FK = 'fk_planner_category_expenses_category_id';
    const INDEX = 'idx-planner_category_expenses-category_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'category_id' => 'INT(11) NOT NULL',
            'amount' => $this->integer()->defaultValue(0),
            'description' => $this->text()->null(),
            'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->addForeignKey(
            self::FK,
            self::TABLE,
            'category_id',
            '{{%planner_category}}',
            'id'
        );

        $this->createIndex(
            self::INDEX,
            self::TABLE,
            'category_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::FK, self::TABLE);
        $this->dropIndex(self::INDEX, self::TABLE);
        $this->dropTable(self::TABLE);
    }
}
