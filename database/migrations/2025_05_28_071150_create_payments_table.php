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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->unsignedBigInteger("cart_id");
            $table->foreign("cart_id")
                ->references("id")
                ->on("carts");
            $table->string('status')->nullable()->index(); // Payment status
            $table->string('type')->nullable()->index();
            $table->string('transaction_id')->nullable()->index(); // Transaction ID for payment gateway
            $table->string('reference_id')->nullable()->index(); // Transaction ID for payment gateway
            $table->decimal('amount', 20, 2); // Payment amount
            $table->string('currency')->nullable()->default("Rl")->index(); // Currency (default: Iranian Rial)
            $table->json('info')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
