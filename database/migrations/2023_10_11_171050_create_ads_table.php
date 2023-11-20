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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description');
            $table->string('price');
            $table->string('out_price')->nullable();
            $table->string('slug')->unique();
            $table->string('meta_title');
            $table->text('meta_description')->nullable();
            $table->string('state')->default('Pending');
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\City::class);
            $table->foreignIdFor(\App\Models\Product::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
