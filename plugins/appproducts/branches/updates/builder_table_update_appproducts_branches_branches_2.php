<?php namespace AppProducts\Branches\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsBranchesBranches2 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->time('branch_suburb');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->dropColumn('branch_suburb');
        });
    }
}
