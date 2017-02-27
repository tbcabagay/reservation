<?php

use yii\db\Migration;

class m160905_081350_alter_transaction_table_add_penalty extends Migration
{
    public function up()
    {
        $this->addColumn('{{%transaction}}', 'penalty_from_excess_hour', $this->money());
    }

    public function down()
    {
        $this->dropColumn('{{%transaction}}', 'penalty_from_excess_hour');
    }
}
