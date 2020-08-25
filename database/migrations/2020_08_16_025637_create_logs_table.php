<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('join_code')->nullable();
            $table->boolean('notify_daily_count')->nullable();
            $table->boolean('notify_max_temp')->nullable();
            $table->time('daily_count_at')->default('17:00');
            $table->unsignedInteger('daily_count')->nullable();
            $table->unsignedInteger('max_temp')->nullable();
            $table->enum('scale', ['F', 'C'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
