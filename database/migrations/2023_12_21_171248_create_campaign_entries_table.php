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
        Schema::create('campaign_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Campaign::class, 'campaign_id')->constrained();
            $table->string('entry_id')->nullable();
            $table->string('entry_name')->nullable();
            $table->string('entry_phone_number')->nullable();
            $table->string('entry_source')->nullable();
            $table->string('entry_destination')->nullable();
            $table->string('entry_notes')->nullable();
            $table->dateTime('entry_created_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_entries');
    }
};
