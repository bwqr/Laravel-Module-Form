<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormSectionFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_section_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('section_id');
            $table->string('title')->default('');
            $table->string('name');
            $table->string('placeholder')->default('');
            $table->string('type');
            $table->text('options')->nullable()->default('[]');
            $table->boolean('disabled')->default(false);
            $table->unsignedInteger('weight')->default(0);
            $table->timestamps();
            $table->foreign('section_id')->on('form_sections')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_section_fields');
    }
}
