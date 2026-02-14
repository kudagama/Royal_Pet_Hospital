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
        Schema::create('opd_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_visit_id')->constrained('opd_visits')->onDelete('cascade');
            $table->string('service_title');
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->longText('touch_panel_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_services');
    }
};
