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
        Schema::create('call_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\CampaignEntry::class, 'campaign_entry_id')->constrained();
            $table->string('call_id')->nullable();
            $table->dateTime('call_attempt_start');
            $table->dateTime('call_attempt_end')->nullable();
            $table->boolean('successful')->nullable();
            $table->string('error_message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_attempts');
    }
};
