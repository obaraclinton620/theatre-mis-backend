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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('production_id')->constrained()->onDelete('cascade');
            $table->string('booking_reference')->unique();
            $table->text('venue')->nullable();
            $table->date('date');
            $table->time('time')->nullable();
            $table->integer('audience_count')->nullable();
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->string('status')->default('pending_payment');
            $table->string('payment_proof_url')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
