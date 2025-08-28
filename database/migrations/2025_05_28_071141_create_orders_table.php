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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('price');
            $table->bigInteger('total_price'); // price * qty
            $table->bigInteger('final_price'); // (price - discount) * qty
            $table->integer('qty');
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('content_id');
            $table->string('type')->nullable();
            $table->json('info')->nullable();
            $table->string('status')->nullable()->index();
            $table->foreign('cart_id')
                ->references('id')
                ->on('carts');
            $table->foreign('content_id')
                ->references('id')
                ->on('contents');
            $table->timestamps();
            $table->softDeletes();
            $table->index("created_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
