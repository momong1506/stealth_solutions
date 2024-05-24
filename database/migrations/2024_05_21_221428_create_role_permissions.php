<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_roles_id');
            $table->unsignedBigInteger('permissions_id');
            $table->timestamps();

            $table->foreign('user_roles_id')->references('id')->on('user_roles')->onDelete('cascade')->onUpdate('cascade');
            $table->index(['user_roles_id']);

            $table->foreign('permissions_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
            $table->index(['permissions_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permissions');
    }
}
