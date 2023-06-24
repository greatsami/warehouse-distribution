<?php
declare(strict_types=1);

use App\Enums\CategoryStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('categories', static function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('name');
            $table->string('status')->default(CategoryStatus::ACTIVE->value);
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
