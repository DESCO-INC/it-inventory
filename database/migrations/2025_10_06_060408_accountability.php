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
        Schema::create('accountability', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Inventory::class)->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('history')->nullable();
            $table->string('date_received')->nullable();
            $table->string('date_returned')->nullable();
            $table->string('returned_to')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountability');
    }
};
