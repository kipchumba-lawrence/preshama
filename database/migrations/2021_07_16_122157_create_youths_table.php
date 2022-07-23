<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('names');
            $table->string('identification');
            $table->string('dob');
            $table->string('gender');
            $table->longText('dissability')->nullable();
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('admin');
            $table->string('physical_address');
            $table->longText('health_condition')->nullable();
            $table->longText('drug_abuse')->nullable();
            $table->string('next_of_kin_names');
            $table->string('next_of_kin_relationship');
            $table->string('next_of_kin_contacts');
            $table->string('resume');
            $table->boolean('status')->default('0');
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
        Schema::dropIfExists('youths');
    }
}
