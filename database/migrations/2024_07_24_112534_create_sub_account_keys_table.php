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
                $table->increments('id');
                
                $table->unsignedInteger('account_key')->unique();
                $table->foreign('account_key')->references('account_key')->on('account_keys')->onDelete('cascade');

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
