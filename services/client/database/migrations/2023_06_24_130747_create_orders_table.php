<?php
declare(strict_types=1);

use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders',static function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('status')->default(OrderStatus::DRAFT->value);

            $table->unsignedBigInteger('weight')->default(0);

            $table->json('shipping')->nullable();
            $table->json('billing')->nullable();

            $table->foreignUlid('client_id')->index()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
