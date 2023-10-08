<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'categories_access', 'display_name' => 'Access', 'group_name' => 'category_charge', 'group_slug' => 'category_charge', 'guard_name' => 'web'],
            ['name' => 'categories_create', 'display_name' => 'Create', 'group_name' => 'category_charge', 'group_slug' => 'category_charge', 'guard_name' => 'web'],
            ['name' => 'categories_show', 'display_name' => 'Show', 'group_name' => 'category_charge', 'group_slug' => 'category_charge', 'guard_name' => 'web'],
            ['name' => 'categories_edit', 'display_name' => 'Edit', 'group_name' => 'category_charge', 'group_slug' => 'category_charge', 'guard_name' => 'web'],
            ['name' => 'categories_delete', 'display_name' => 'Delete', 'group_name' => 'category_charge', 'group_slug' => 'category_charge', 'guard_name' => 'web'],
            ['name' => 'categories_export', 'display_name' => 'Export', 'group_name' => 'category_charge', 'group_slug' => 'category_charge', 'guard_name' => 'web'],
            ['name' => 'categories_import', 'display_name' => 'Import', 'group_name' => 'category_charge', 'group_slug' => 'category_charge', 'guard_name' => 'web'],
        );

        Permission::insert($permissions);

        collect($permissions)->map(function($item) {
            Role::find(1)->givePermissionTo($item['name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
