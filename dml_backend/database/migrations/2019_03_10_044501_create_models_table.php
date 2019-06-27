<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ml_models', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->tinyInteger('status')->default(0);
      $table->integer('version')->default(0);
      $table->text('description')->nullable();
      $table->string('model_path')->nullable();
      $table->string('thumbnail_path')->nullable();
      $table->string('script_path')->nullable();
      $table->float('credits_per_training')->default(0);
      $table->integer('max_training_count')->default(0);
      $table->integer('update_threshold')->default(2);
      $table->integer('user_id');
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
    Schema::dropIfExists('ml_models');
  }
}
