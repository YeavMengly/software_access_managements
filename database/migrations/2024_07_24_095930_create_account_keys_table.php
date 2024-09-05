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
        if (!Schema::hasTable('account_keys')) {
            Schema::create('account_keys', function (Blueprint $table) {
                $table->increments('id', true);
                
                // Remove the ->change() method call as it's not needed for new columns
                $table->unsignedBigInteger('code')->change();
                $table->foreignId('code')->references('id')->on('keys')->onDelete('cascade');
                
                $table->string('account_key');
                $table->string('name_account_key');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_keys');
    }
};
