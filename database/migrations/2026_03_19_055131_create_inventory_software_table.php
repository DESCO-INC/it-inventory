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
        Schema::create('inventory_software', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Inventory::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Software::class)->constrained()->cascadeOnDelete();
            $table->string('product_key')->nullable();
            $table->date('date_installed')->nullable();
            $table->date('date_expired')->nullable();
            $table->string('installed_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_software');
    }
};
