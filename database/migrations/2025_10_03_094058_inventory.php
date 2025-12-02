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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('control_no');
            $table->foreignIdFor(\App\Models\UnitCategory::class);
            $table->string('model_name')->nullable();
            $table->string('serial')->nullable();
            $table->string('purchase_no')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('manufacturing_date')->nullable();
            $table->string('depreciation_date')->nullable();
            $table->string('remarks')->nullable();
            $table->string('status');
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
