<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixedWrongTypeLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email',50)->change();
            $table->string('name',50)->change();
            $table->string('surname',50)->change();
            $table->string('phone',15)->change();
        });

        Schema::table('repatriations', function (Blueprint $table) {
            $table->decimal('amount',20, 2)->change();
            $table->string('title',50)->change();
            $table->string('type',50)->change();
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('title',50)->change();
            $table->string('type',50)->change();
        });

        Schema::table('workplaces', function (Blueprint $table) {
            $table->string('field',50)->change();
            $table->string('company',50)->change();
            $table->string('position',50)->change();
        });

        Schema::table('studies', function (Blueprint $table) {
            $table->string('name',50)->change();
            $table->string('faculty',50)->change();
            $table->string('program',50)->change();
            $table->string('degree',50)->change();
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->string('title',50)->change();
            $table->string('abbreviation',10)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
