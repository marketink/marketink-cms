<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('total_price')->default(0); //products price
            $table->bigInteger("shipping_cost")->default(0); //shipping cost
            $table->bigInteger('final_price')->default(0); //shipping cost + products price
            $table->unsignedBigInteger('user_id');
            $table->string('currency')->nullable();
            $table->string('tracking_code')->nullable();
            $table->string('description')->nullable();
            $table->date('delivery_date')->nullable(); // date
            $table->string('delivery_time')->nullable(); // time: what hours?
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->json('info')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->unsignedBigInteger('address_id')->nullable(); //Address
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');

            $table->timestamps();
            $table->softDeletes();

            $table->index("status");
            $table->index("created_at");
            $table->index("tracking_code");
            $table->index("currency");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
