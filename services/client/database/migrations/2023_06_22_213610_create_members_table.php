<?php
declare(strict_types=1);

use App\Enums\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', static function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('role')->default(Role::USER->value);;
            $table->foreignUlid('client_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignUlid('company_id')->index()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
