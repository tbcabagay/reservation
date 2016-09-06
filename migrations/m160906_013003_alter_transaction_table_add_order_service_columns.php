<?php

use yii\db\Migration;

class m160906_013003_alter_transaction_table_add_order_service_columns extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%transaction}}', 'total_amount');
        $this->addColumn('{{%transaction}}', 'order_total', $this->money());
        $this->addColumn('{{%transaction}}', 'service_total', $this->money());
    }

    public function down()
    {
        $this->dropColumn('{{%transaction}}', 'total_amount', $this->money());
        $this->dropColumn('{{%transaction}}', 'order_total');
        $this->dropColumn('{{%transaction}}', 'service_total');
    }
}
