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
        Schema::table('orders', function (Blueprint $table) {
            // Add payment_date column after the payment_status column
            if (!Schema::hasColumn('orders', 'payment_date')) {
                $table->dateTime('payment_date')->nullable()->after('payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the payment_date column if it exists
            if (Schema::hasColumn('orders', 'payment_date')) {
                $table->dropColumn('payment_date');
            }
        });
    }
};
?>
