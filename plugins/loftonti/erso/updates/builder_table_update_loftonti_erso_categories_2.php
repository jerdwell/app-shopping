<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoCategories2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_categories', function($table)
        {
            $table->integer('order')->unsigned();
            $table->string('category_cover', 191)->default(null)->change();
            $table->dropColumn('deleted_at');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_categories', function($table)
        {
            $table->dropColumn('order');
            $table->string('category_cover', 191)->default('NULL')->change();
            $table->timestamp('deleted_at')->nullable()->default('NULL');
        });
    }
}
