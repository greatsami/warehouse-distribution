<?php
declare(strict_types=1);

use App\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default(ProductStatus::IN_STOKE->value);

            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('cost')->default(0);
            $table->unsignedBigInteger('weight')->default(0);
            $table->unsignedBigInteger('stock')->default(0);

            $table->json('dimensions')->nullable();

            $table->foreignUlid('category_id')->nullable()->index()->constrained()->cascadeOnDelete();
            $table->foreignUlid('supplier_id')->nullable()->index()->constrained()->cascadeOnDelete();
            $table->foreignUlid('warehouse_id')->nullable()->index()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
