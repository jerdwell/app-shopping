<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProducts17 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->decimal('public_price', 10, 2)->nullable(false)->default(null)->change();
            $table->string('product_cover', 191)->nullable(false)->default(null)->change();
            $table->integer('brand_id')->nullable(false)->default(null)->change();
            $table->integer('category_id')->nullable(false)->default(null)->change();
            $table->integer('enterprise_id')->nullable(false)->default(null)->change();
            $table->decimal('customer_price', 10, 2)->nullable(false)->default(null)->change();
            $table->renameColumn('product_year', 'erso_code');
            $table->dropColumn('product_description');
            $table->dropColumn('product_note');
            $table->dropColumn('erso_code_id');
            $table->dropColumn('shipowner_id');
            $table->dropColumn('model_id');
            $table->dropColumn('deleted_at');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->decimal('public_price', 10, 2)->nullable()->default(NULL)->change();
            $table->string('product_cover', 191)->nullable()->default('NULL')->change();
            $table->integer('brand_id')->nullable()->default(NULL)->change();
            $table->integer('category_id')->nullable()->default(NULL)->change();
            $table->integer('enterprise_id')->nullable()->default(NULL)->change();
            $table->decimal('customer_price', 10, 2)->nullable()->default(NULL)->change();
            $table->renameColumn('erso_code', 'product_year');
            $table->string('product_description', 191)->nullable()->default('NULL');
            $table->string('product_note', 191)->nullable()->default('NULL');
            $table->integer('erso_code_id')->nullable()->default(NULL);
            $table->integer('shipowner_id')->nullable()->default(NULL);
            $table->integer('model_id')->nullable()->default(NULL);
            $table->timestamp('deleted_at')->nullable()->default('NULL');
        });
    }
}
