<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m260707_090150_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'description' => $this->text()->null(),
            'price' => $this->decimal(10,2)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
