<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_users', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("email")->default("");
            $table->string("project_id")->default("");
            $table->string("shared_user_id")->default(null)->nullable(true);
            $table->string("shared_user_id")->default(null)->nullable(true);
            $table->string("user_id")->default("");
            $table->enum("status", ["pending", "cancelled", "accepted"])->default("pending");
            $table->timestamps();
            $table->boolean('edit')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_users');
    }
};
