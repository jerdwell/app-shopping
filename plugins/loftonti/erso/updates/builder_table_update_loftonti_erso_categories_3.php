<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoCategories3 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_categories', function($table)
        {
            $table->timestamp('deleted_at')->nullable();
            $table->string('category_cover', 191)->default('null')->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_categories', function($table)
        {
            $table->dropColumn('deleted_at');
            $table->string('category_cover', 191)->default('NULL')->change();
        });
    }
}
