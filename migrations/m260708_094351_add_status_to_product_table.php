<?php

use yii\db\Migration;

class m260708_094351_add_status_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'status', $this->tinyInteger()->notNull()->defaultValue(1)->after('price'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'status');
    }
}
