<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role_permission}}`.
 */
class m260716_100250_create_role_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%role_permission}}', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer()->notNull(),
            'permission' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-role_permission-role',
            '{{%role_permission}}',
            'role_id',
            '{{%role}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-role_permission-unique',
            '{{%role_permission}}',
            [
                'role_id',
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
        $this->dropTable('{{%role_permission}}');
    }
}
