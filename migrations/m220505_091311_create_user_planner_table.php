<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_planner}}`.
 */
class m220505_091311_create_user_planner_table extends Migration
{
    const FK = 'fk_user_planner_user_id';
    const INDEX = 'idx-user_planner-user_id';
    const TABLE = '{{%user_planner}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string(30)->notNull(),
            'user_id' => 'INT(11) NOT NULL',
            'amount' => $this->float()->defaultValue(0),
            'used_amount' => $this->float()->defaultValue(0),
            'created_at' => 'date DEFAULT NOW()',
        ]);

        $this->addForeignKey(
            self::FK,
            self::TABLE,
            'user_id',
            '{{%user}}',
            'id'
        );
        $this->createIndex(
            self::INDEX,
            self::TABLE,
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::FK, self::TABLE);
        $this->dropIndex(self::INDEX, self::TABLE);
        $this->dropTable('{{%user_planner}}');
    }
}
