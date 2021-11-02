<?php namespace LoftonTi\Quotations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiQuotationsQuotations2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_quotations_quotations', function($table)
        {
            $table->integer('user_id')->unsigned();
            $table->string('status', 191)->default('active')->change();
            $table->text('shipping_address')->default(null)->change();
            $table->dateTime('shipping_date')->default(null)->change();
            $table->text('shipping_contact')->default(null)->change();
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_quotations_quotations', function($table)
        {
            $table->dropColumn('user_id');
            $table->string('status', 191)->default('\'active\'')->change();
            $table->text('shipping_address')->default('NULL')->change();
            $table->dateTime('shipping_date')->default('NULL')->change();
            $table->text('shipping_contact')->default('NULL')->change();
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
        });
    }
}
