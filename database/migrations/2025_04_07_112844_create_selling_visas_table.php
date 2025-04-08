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
        Schema::create('selling_visas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('destination_id');
            $table->unsignedBigInteger('visa_type_id');
            $table->unsignedBigInteger('employment_type_id');
            $table->string('provider_name');
            $table->string('contact_email');
            $table->string('required_qualifications');
            $table->text('message');
            $table->boolean('is_done');
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
        Schema::dropIfExists('selling_visas');
    }
};
