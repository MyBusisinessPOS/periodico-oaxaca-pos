<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('publication_type_id')->constrained();
            $table->foreignId('publication_category_id')->constrained();
            $table->foreignId('document_type_id')->constrained();
            $table->string('author');
            $table->string('summary');
            $table->string('description');            
            $table->string('media');
            $table->string('media_name');
            $table->string('media_type');
            $table->string('media_size');
            $table->softDeletes();
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
        Schema::dropIfExists('publications');
    }
}
