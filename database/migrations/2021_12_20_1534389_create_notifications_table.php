<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->enum('action', ['assigned','unassigned','joined','left'])->default(null);

            $table->string('user_id')->nullable(true)->default(null);
            $table->string('module_id')->nullable(false)->default(null);
            $table->string('module')->nullable(false)->default(null);
            $table->string("by_user_id")->nullable(true)->default(null);


//            $table->string('notify_user_name')->nullable(true)->default(null);
//            $table->string('module_id')->nullable(false)->default(null);
//            $table->string('module_name')->nullable(false)->default(null);
//            $table->string('module')->nullable(false)->default(null);
//            $table->string('action_user_id')->nullable(true)->default(null);
//            $table->string('action_user_name')->nullable(true)->default(null);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
