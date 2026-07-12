<?php

use yii\db\Migration;

class m260712_113010_add_email_and_last_login_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'email', $this->string(255)->notNull()->unique()->after('username'));
        $this->addColumn('{{%user}}', 'last_login_at', $this->integer()->null()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'email');
        $this->dropColumn('{{%user`}}', 'last_login_at');
    }
}
