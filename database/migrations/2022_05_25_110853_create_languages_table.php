<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'languages_access', 'display_name' => 'Access', 'group_name' => 'language_charge', 'group_slug' => 'language_charge', 'guard_name' => 'web'],
            ['name' => 'languages_create', 'display_name' => 'Create', 'group_name' => 'language_charge', 'group_slug' => 'language_charge', 'guard_name' => 'web'],
            ['name' => 'languages_show', 'display_name' => 'Show', 'group_name' => 'language_charge', 'group_slug' => 'language_charge', 'guard_name' => 'web'],
            ['name' => 'languages_edit', 'display_name' => 'Edit', 'group_name' => 'language_charge', 'group_slug' => 'language_charge', 'guard_name' => 'web'],
            ['name' => 'languages_delete', 'display_name' => 'Delete', 'group_name' => 'language_charge', 'group_slug' => 'language_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('languages');
    }
};
