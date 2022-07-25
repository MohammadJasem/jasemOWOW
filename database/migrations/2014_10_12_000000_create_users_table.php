<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('role', ['boss', 'developer', 'designer', 'intern'])->default('developer');
            $table->enum('working', ['0', '1'])->default('1');
            $table->string('photo')->default('https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png');
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('fired_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
