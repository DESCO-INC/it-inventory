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
        Schema::create('department', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->string('status')->nullable();
            $table->timestamps();
        });
        
        DB::table('department')->insert([
            ['department' => 'IT', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'HRAD', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'ACCOUNTING', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'MAINTENANCE', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'HSES', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'ANGAT', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'MAGAT', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'ISABEL LEYTE', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'BACMAN', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'MAKBAN', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'ORMOC', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'TIWI', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'DRILLING', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'ECP', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'MCP', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'MSVS', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'OFFICE OF THE PRES', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'OFFICE OF THE VP', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'OPERATIONS', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'QA & ENGINEERING', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['department' => 'SALES AND MARKETING', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department');
    }
};
