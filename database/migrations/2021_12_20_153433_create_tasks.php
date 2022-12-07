<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {

            $table->uuid("id")->primary();
            $table->text('name')->nullable();
            $table->text('text')->nullable();
            $table->string("type")->nullable()->default("task");
            $table->date("due")->nullable()->default(null);
            $table->boolean('deleted')->default(0);
            $table->boolean("completed")->default(false);
            $table->string("user_id")->default(0);
            $table->integer("order")->default(0)->nullable();
            $table->enum("prio", ["low", "normal", "high"])->default("normal");
            $table->text('project_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
