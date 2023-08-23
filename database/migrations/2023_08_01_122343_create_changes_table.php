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
        Schema::create('changes', function (Blueprint $table) {
            $table->id();
            // $table->morphs('changeable');
            $table->unsignedBigInteger('changeable_id');
            $table->string('changeable_type');
            $table->string('change_description');
            $table->string('data_key');
            $table->unsignedBigInteger('linkedable_id');
            $table->string('linkedable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('changes');
    }
};
