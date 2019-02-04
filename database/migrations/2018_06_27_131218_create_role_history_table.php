<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('role_id');
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->text('report')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_history');
    }
}
