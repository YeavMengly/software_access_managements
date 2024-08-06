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
        Schema::create('sub_account_keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_key_id')->change();
            $table->foreignId('account_key_id')->constrained('account_keys')->onDelete('cascade');
            $table->string('sub_account_key')->nullable();
            $table->string('name_sub_account_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_account_keys');
    }
};
