<?php

use yii\db\Migration;

class m160818_140808_alter_package_table extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%package}}', 'header');
        $this->dropColumn('{{%package}}', 'footer');
        $this->addColumn('{{%package}}', 'agreement', $this->text()->notNull());
    }

    public function down()
    {
        $this->addColumn('{{%package}}', 'header', $this->text());
        $this->addColumn('{{%package}}', 'footer', $this->text());
        $this->dropColumn('{{%package}}', 'agreement');
    }
}
