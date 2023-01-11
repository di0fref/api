<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_users', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->boolean('deleted')->default(false);
            $table->string("user_id")->default(null)->nullable(true);
            $table->string("project_id")->default(null);
            $table->string("email")->default(null)->nullable(true);
            $table->boolean("edit")->default(false)->nullable(true);
            $table->enum("status",["pending", "accepted", "deleted", "owner"])->default(null);
            $table->string("shared_user_id")->default(null);
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
        Schema::dropIfExists('projects_users');
    }
}
