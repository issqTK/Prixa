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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('title');
            $table->text('description_header');
            $table->text('description_footer');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->string('slug');
            $table->json('product_ids');
            $table->foreignIdFor(\App\Models\City::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
