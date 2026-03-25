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
        Schema::create('unit_category', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('count_index');
            $table->string('years_depreciation');
            $table->timestamps();
            $table->softDeletes();
        });
        
        DB::table('unit_category')->insert([
            [
                'code' => 'NDSU',
                'name' => 'DESKTOP SYSTEM UNIT',
                'count_index' => '1',
                'years_depreciation' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NLSU',
                'name' => 'LAPTOP SYSTEM UNIT',
                'count_index' => '2',
                'years_depreciation' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NPSU',
                'name' => 'PRINTER SYSTEM UNIT',
                'count_index' => '3',
                'years_depreciation' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NHWU',
                'name' => 'HARDWARE SYSTEM UNIT',
                'count_index' => '4',
                'years_depreciation' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NSWU',
                'name' => 'SOFTWARE UNIT',
                'count_index' => '5',
                'years_depreciation' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_category');
    }
};
