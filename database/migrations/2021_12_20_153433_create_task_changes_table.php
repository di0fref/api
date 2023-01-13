<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_changes', function (Blueprint $table) {

            $table->uuid("id")->primary();
            $table->text('field')->nullable();
            $table->text('old')->nullable();
            $table->text('task_id')->nullable();
            $table->text('new')->nullable();
            $table->text('type')->nullable();
            $table->string("assigned_user_id")->nullable()->default(null);
            $table->string("user_id")->default(0);
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
        Schema::dropIfExists('task_changes');
    }
}
