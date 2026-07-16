<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_permission}}`.
 */
class m260716_100530_create_user_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_permission}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'permission' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_permission-user',
            '{{%user_permission}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_permission-unique',
            '{{%user_permission}}',
            [
                'user_id',
                'permission'
            ],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_permission}}');
    }
}
