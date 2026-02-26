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

            $table->decimal('amount', 10, 2);
            $table->timestamp('date')->useCurrent();

            $table->boolean('is_confirmed')->default(false);
            $table->foreignId('sender_id')->constrained('memberships')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('memberships')->onDelete('cascade');

            $table->timestamps();
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
