<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelUpdatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('model_updates', function (Blueprint $table) {
      $table->increments('id');
      $table->string('weights_path');
      $table->float('credits_earned')->default(0);
      $table->integer('user_id');
      $table->tinyInteger('status')->default(0);
      $table->integer('model_id');
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
    Schema::dropIfExists('model_updates');
  }
}
