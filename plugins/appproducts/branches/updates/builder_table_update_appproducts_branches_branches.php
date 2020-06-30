<?php namespace AppProducts\Branches\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsBranchesBranches extends Migration
{
    public function up()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->text('branch_state');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->dropColumn('branch_state');
        });
    }
}
