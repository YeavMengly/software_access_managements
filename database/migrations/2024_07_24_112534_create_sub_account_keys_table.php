<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('sub_account_keys')) {
            Schema::create('sub_account_keys', function (Blueprint $table) {
                $table->increments('id', true);

                $table->unsignedBigInteger('account_key')->change();
                $table->foreignId('account_key')->references('id')->on('account_keys')->onDelete('cascade');

                $table->string('sub_account_key')->nullable();
                $table->string('name_sub_account_key')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_account_keys');
    }
};
