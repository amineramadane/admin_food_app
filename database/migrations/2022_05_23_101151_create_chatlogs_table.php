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
        Schema::create('chatlogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone', 60)->nullable();
            $table->text('message')->nullable();
            $table->integer('type')->nullable(); // 1 => send , 2 => receive
            $table->integer('status')->nullable(); // 1 => error , 2 => success
            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'chatlogs_access', 'display_name' => 'Access', 'group_name' => 'chatlog_charge', 'group_slug' => 'chatlog_charge', 'guard_name' => 'web'],
            ['name' => 'chatlogs_create', 'display_name' => 'Create', 'group_name' => 'chatlog_charge', 'group_slug' => 'chatlog_charge', 'guard_name' => 'web'],
            ['name' => 'chatlogs_show', 'display_name' => 'Show', 'group_name' => 'chatlog_charge', 'group_slug' => 'chatlog_charge', 'guard_name' => 'web'],
            ['name' => 'chatlogs_edit', 'display_name' => 'Edit', 'group_name' => 'chatlog_charge', 'group_slug' => 'chatlog_charge', 'guard_name' => 'web'],
            ['name' => 'chatlogs_delete', 'display_name' => 'Delete', 'group_name' => 'chatlog_charge', 'group_slug' => 'chatlog_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('chatlogs');
    }
};
