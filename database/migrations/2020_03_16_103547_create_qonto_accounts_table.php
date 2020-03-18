<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQontoAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qonto_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('slug')->unique();
            $table->string('iban')->unique();
            $table->string('bic');
            $table->string('currency');
            $table->decimal('balance', 11, 2);
            $table->integer('balance_cents');
            $table->decimal('authorized_balance', 11, 2);
            $table->integer('authorized_balance_cents');
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
        Schema::dropIfExists('qonto_accounts');
    }
}
