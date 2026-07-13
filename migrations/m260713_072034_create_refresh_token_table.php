<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%refresh_token}}`.
 */
class m260713_072034_create_refresh_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%refresh_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'selector' => $this->string(32)->notNull(),
            'token_hash' => $this->string()->notNull(),
            'expires_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'revoked_at' => $this->integer()->null(),
        ]);

        $this->addForeignKey('fk_refresh_token_user_id', '{{%refresh_token}}', 'user_id', '{{%user}}', 'id');
        $this->createIndex('idx_refresh_token_user_id', '{{%refresh_token}}', 'user_id');
        $this->createIndex('uidx_refresh_token_selector', '{{%refresh_token}}', 'selector', true);
        $this->createIndex('uidx_refresh_token_token_hash', '{{%refresh_token}}', 'token_hash', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%refresh_token}}');
        $this->dropForeignKey('fk_refresh_token_user_id', '{{%refresh_token}}');
        $this->dropIndex('idx_refresh_token_user_id', '{{%refresh_token}}');
        $this->dropIndex('uidx_refresh_token_token_hash', '{{%refresh_token}}');
    }
}
