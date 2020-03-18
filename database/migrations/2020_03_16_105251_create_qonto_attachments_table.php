<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQontoAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qonto_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('attachment_id');
            $table->bigInteger('qonto_transaction_id')->unsigned();
            $table->foreign('qonto_transaction_id')->references('id')->on('qonto_transactions');
            $table->string('file_name')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('file_content_type')->nullable();
            $table->text('url')->nullable();
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
        Schema::dropIfExists('qonto_attachments');
    }
}
