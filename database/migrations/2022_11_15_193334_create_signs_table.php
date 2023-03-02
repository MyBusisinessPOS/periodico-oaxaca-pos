<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sign_document_id')->constrained();
            $table->string('signature')->nullable();
            $table->enum('type', ['media', 'text'])->default('text');
            $table->string('media')->nullable();
            $table->uuid('media_uuid')->nullable();
            $table->string('media_name')->nullable();
            $table->string('media_type')->nullable();
            $table->string('media_size')->nullable();
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
        Schema::dropIfExists('signs');
    }
}
