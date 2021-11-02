<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoCars extends Migration
{
    public function up()
    {
        Schema::rename('loftonti_erso_models', 'loftonti_erso_cars');
        Schema::table('loftonti_erso_cars', function($table)
        {
            $table->string('car_name', 191);
            $table->string('car_slug', 191);
            $table->dropColumn('model_name');
            $table->dropColumn('model_slug');
            $table->dropColumn('deleted_at');
        });
    }
    
    public function down()
    {
        Schema::rename('loftonti_erso_cars', 'loftonti_erso_models');
        Schema::table('loftonti_erso_models', function($table)
        {
            $table->dropColumn('car_name');
            $table->dropColumn('car_slug');
            $table->string('model_name', 191);
            $table->string('model_slug', 191);
            $table->timestamp('deleted_at')->nullable()->default('NULL');
        });
    }
}
