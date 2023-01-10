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
        Schema::create('members_months', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members','id');
            $table->foreignId('month_id')->constrained('months','id');
            $table->integer('rent_this_month')->default(0);
            $table->integer('due')->default(0);
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
        Schema::dropIfExists('member_months');
    }
};
