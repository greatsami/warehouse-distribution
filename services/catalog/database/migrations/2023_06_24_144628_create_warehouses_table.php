<?php
declare(strict_types=1);

use App\Enums\WarehouseStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('warehouses', static function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name');
            $table->string('manager');
            $table->string('email')->unique();
            $table->string('status')->default(WarehouseStatus::ONLINE->value);

            $table->json('address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
