<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('player_id');
            $table->integer('score');
            $table->string('level', 200);
            $table->string('category', 300);
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
?>