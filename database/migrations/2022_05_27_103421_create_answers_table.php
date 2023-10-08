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
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('answer', 255)->nullable();
            $table->integer('status'); // 1 => sent, 2 => received, 3 => Expired 
            $table->integer('number_of_reminders');
            $table->biginteger('question_id');
            $table->string('phone', 60);
            $table->biginteger('customer_id');
            $table->dateTime('answered_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'answers_access', 'display_name' => 'Access', 'group_name' => 'answer_charge', 'group_slug' => 'answer_charge', 'guard_name' => 'web'],
            ['name' => 'answers_create', 'display_name' => 'Create', 'group_name' => 'answer_charge', 'group_slug' => 'answer_charge', 'guard_name' => 'web'],
            ['name' => 'answers_show', 'display_name' => 'Show', 'group_name' => 'answer_charge', 'group_slug' => 'answer_charge', 'guard_name' => 'web'],
            ['name' => 'answers_edit', 'display_name' => 'Edit', 'group_name' => 'answer_charge', 'group_slug' => 'answer_charge', 'guard_name' => 'web'],
            ['name' => 'answers_delete', 'display_name' => 'Delete', 'group_name' => 'answer_charge', 'group_slug' => 'answer_charge', 'guard_name' => 'web'],
            ['name' => 'answers_export', 'display_name' => 'Export', 'group_name' => 'answer_charge', 'group_slug' => 'answer_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('answers');
    }
};
