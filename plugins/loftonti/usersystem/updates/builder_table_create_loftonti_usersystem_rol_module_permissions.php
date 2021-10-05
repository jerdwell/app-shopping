<?php namespace LoftonTi\Usersystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiUsersystemRolModulePermissions extends Migration
{
    public function up()
    {
        Schema::create('loftonti_usersystem_rol_module_permissions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('rol_id');
            $table->integer('module_id');
            $table->boolean('create')->default(true);
            $table->boolean('read')->default(true);
            $table->boolean('update')->default(true);
            $table->boolean('delete')->default(true);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_usersystem_rol_module_permissions');
    }
}
