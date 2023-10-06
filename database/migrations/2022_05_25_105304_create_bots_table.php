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
        Schema::create('bots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('status'); // 1 => disabled , 2 => enabled
            $table->bigInteger('reminder_time'); // reminder time if the contact does not answer
            $table->integer('number_reminders'); // number of reminders
            $table->timestamps();
            $table->softDeletes();
        });
        $permissions = array(
            ['name' => 'bots_access', 'display_name' => 'Access', 'group_name' => 'bot_charge', 'group_slug' => 'bot_charge', 'guard_name' => 'web'],
            ['name' => 'bots_create', 'display_name' => 'Create', 'group_name' => 'bot_charge', 'group_slug' => 'bot_charge', 'guard_name' => 'web'],
            ['name' => 'bots_show', 'display_name' => 'Show', 'group_name' => 'bot_charge', 'group_slug' => 'bot_charge', 'guard_name' => 'web'],
            ['name' => 'bots_edit', 'display_name' => 'Edit', 'group_name' => 'bot_charge', 'group_slug' => 'bot_charge', 'guard_name' => 'web'],
            ['name' => 'bots_delete', 'display_name' => 'Delete', 'group_name' => 'bot_charge', 'group_slug' => 'bot_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('bots');
    }
};
