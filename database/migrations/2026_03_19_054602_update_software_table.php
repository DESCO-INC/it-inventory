<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('software', function (Blueprint $table) {
            // Drop unused columns
            $table->dropColumn(['serial', 'product_key']);

            // Add new column
            $table->string('created_by')->nullable()->after('category');
        });
    }

    public function down()
    {
        Schema::table('software', function (Blueprint $table) {
            // Restore dropped columns
            $table->string('serial')->nullable();
            $table->string('product_key')->nullable();

            // Remove added column
            $table->dropColumn('created_by');
        });
    }
};
