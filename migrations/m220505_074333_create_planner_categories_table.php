<?php

use yii\db\Migration;
use yii\db\mysql\Schema;
use yii\db\Schema as SchemaAlias;

/**
 * Handles the creation of table `{{%planner_categories}}`.
 */
class m220505_074333_create_planner_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%planner_category}}', [
            'id' => $this->primaryKey(),
            'title' => SchemaAlias::TYPE_STRING . ' NOT NULL',
            'percent' => SchemaAlias::TYPE_SMALLINT . ' DEFAULT NULL',
            'amount' => SchemaAlias::TYPE_FLOAT . ' DEFAULT NULL',
            'used_amount' => SchemaAlias::TYPE_FLOAT . ' DEFAULT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%planner_category}}');
    }
}
