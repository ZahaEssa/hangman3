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
        Schema::create('verify', function (Blueprint $table) {
            $table->id(); // Adds an "id" column as the primary key
            $table->integer('gamer_id'); // Adds the "gamer_id" column
            $table->string('fullname', 200);
            $table->string('gamer_username', 100)->nullable();
            $table->string('email', 200)->unique();
            $table->string('token', 200);
            $table->datetime('expiry_time');
            $table->string('password', 200)->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verify');
    }
};

