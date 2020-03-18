<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQontoTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qonto_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->bigInteger('qonto_account_id')->unsigned();
            $table->foreign('qonto_account_id')->references('id')->on('qonto_accounts');
            $table->string('transaction_id');
            $table->decimal('amount', 11, 2);
            $table->integer('amount_cents');
            $table->decimal('local_amount', 11, 2);
            $table->integer('local_amount_cents');
            $table->string('side');
            $table->string('operation_type');
            $table->string('currency');
            $table->string('local_currency');
            $table->string('label');
            $table->timestamp('settled_at')->nullable();
            $table->timestamp('emitted_at')->nullable();
            $table->string('status');
            $table->mediumText('note')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('vat_amount', 11, 2)->nullable();
            $table->integer('vat_amount_cents')->nullable();
            $table->string('vat_rate')->nullable();
            $table->uuid('initiator_id')->nullable();
            $table->boolean('attachment_lost');
            $table->boolean('attachment_required');
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
        Schema::dropIfExists('qonto_transactions');
    }
}
