<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wallet}}`.
 */
class m220515_173800_create_wallet_table extends Migration
{
    const TABLE = '{{%wallet}}';
    const FK = 'fk_wallet_user_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'user_id' => 'INT(11) NOT NULL',
            'title' => $this->string(20),
            'amount' => $this->float(2)->defaultValue(null)
        ]);

        $this->addForeignKey(
            self::FK,
            self::TABLE,
            'user_id',
            '{{%user}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
