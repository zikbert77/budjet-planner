<?php

use yii\db\Migration;

/**
 * Class m220507_103247_update_expense_amount_field
 */
class m220507_103247_update_expense_amount_field extends Migration
{
    const TABLE = '{{%planner_category_expenses}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::TABLE, 'amount', $this->float(2)->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220507_103247_update_expense_amount_field cannot be reverted.\n";
    }
}
