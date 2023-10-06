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
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('question_type'); // 1 => NPS , 2 => Simple
            $table->integer('answer_type'); // 1 => number , 2 => string
            $table->string('condition');
            $table->text('choices')->nullable();
            $table->string('status_choices')->nullable();
            $table->integer('position'); // question position 
            $table->integer('status'); // 1 => disabled , 2 => enabled
            $table->bigInteger('bot_id');
            $table->timestamps();
            $table->softDeletes();
        });

        $permissions = array(
            ['name' => 'questions_access', 'display_name' => 'Access', 'group_name' => 'question_charge', 'group_slug' => 'question_charge', 'guard_name' => 'web'],
            ['name' => 'questions_create', 'display_name' => 'Create', 'group_name' => 'question_charge', 'group_slug' => 'question_charge', 'guard_name' => 'web'],
            ['name' => 'questions_show', 'display_name' => 'Show', 'group_name' => 'question_charge', 'group_slug' => 'question_charge', 'guard_name' => 'web'],
            ['name' => 'questions_edit', 'display_name' => 'Edit', 'group_name' => 'question_charge', 'group_slug' => 'question_charge', 'guard_name' => 'web'],
            ['name' => 'questions_delete', 'display_name' => 'Delete', 'group_name' => 'question_charge', 'group_slug' => 'question_charge', 'guard_name' => 'web'],
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
        Schema::dropIfExists('questions');
    }
};
