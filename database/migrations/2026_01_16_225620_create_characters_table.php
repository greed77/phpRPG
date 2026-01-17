<?php

use App\Models\User;
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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->unsignedInteger('level')->default(1);
            $table->unsignedInteger('energy')->default(100);
            $table->string('race')->nullable();
            $table->string('class')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedInteger('hit_points')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
