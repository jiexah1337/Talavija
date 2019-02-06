<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RepatriationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repatriations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->integer('year');
            $table->integer('month');
            $table->decimal('amount',20,5);
            $table->string('title');
            $table->integer('discount');
            $table->string('type');
            $table->string('unique_code');
            $table->date('issue_date');
            $table->date('paid_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repatriations');
    }
}
