<?php

use yii\db\Migration;

class m160908_072814_alter_transaction_table_add_package_fee extends Migration
{
    public function up()
    {
        $this->addColumn('{{%transaction}}', 'package_fee', $this->money());
    }

    public function down()
    {
        $this->dropColumn('{{%transaction}}', 'package_fee');
    }
}
