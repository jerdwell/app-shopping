<?php namespace AppProducts\Branches\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsBranchesBranches4 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->string('address1', 191);
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('zip_code');
            $table->string('state');
            $table->string('country');
            $table->text('contact_data');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('branch_address');
            $table->dropColumn('branch_zip_code');
            $table->dropColumn('branch_city');
            $table->dropColumn('branch_country');
            $table->dropColumn('branch_contact');
            $table->dropColumn('branch_state');
            $table->dropColumn('branch_suburb');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_branches_branches', function($table)
        {
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('city');
            $table->dropColumn('zip_code');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('contact_data');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('branch_address', 191);
            $table->string('branch_zip_code', 191);
            $table->string('branch_city', 191);
            $table->string('branch_country', 191);
            $table->text('branch_contact');
            $table->text('branch_state');
            $table->text('branch_suburb');
        });
    }
}
