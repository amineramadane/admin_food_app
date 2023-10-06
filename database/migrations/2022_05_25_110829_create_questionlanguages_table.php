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
        Schema::create('questionlanguages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message');
            $table->text('error_message');
            $table->bigInteger('question_id');
            $table->bigInteger('language_id');
            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'questionlanguages_access', 'display_name' => 'Access', 'group_name' => 'questionlanguage_charge', 'group_slug' => 'questionlanguage_charge', 'guard_name' => 'web'],
            ['name' => 'questionlanguages_create', 'display_name' => 'Create', 'group_name' => 'questionlanguage_charge', 'group_slug' => 'questionlanguage_charge', 'guard_name' => 'web'],
            ['name' => 'questionlanguages_show', 'display_name' => 'Show', 'group_name' => 'questionlanguage_charge', 'group_slug' => 'questionlanguage_charge', 'guard_name' => 'web'],
            ['name' => 'questionlanguages_edit', 'display_name' => 'Edit', 'group_name' => 'questionlanguage_charge', 'group_slug' => 'questionlanguage_charge', 'guard_name' => 'web'],
            ['name' => 'questionlanguages_delete', 'display_name' => 'Delete', 'group_name' => 'questionlanguage_charge', 'group_slug' => 'questionlanguage_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('questionlanguages');
    }
};
